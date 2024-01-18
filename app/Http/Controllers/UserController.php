<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Proceso;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Rules\Alphanum_spaces;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    public function index(Request $request)
    {
        // ----- Security Policy---------
        $this->authorize('index', User::class);

        if ($request->ajax()) {
            $data = User::orderBy('id', 'desc')->get();
            
            return dataTables()->of($data)
                ->editColumn('id','')
                ->addColumn('proceso', function(User $user){
                    return ($user->proceso) ? $user->proceso->nombre : '-';
                })
                ->addColumn('roles', function(User $user){
                    $roles = '';
                    $rols = $user->getRoleNames();
                    if($user->getRoleNames()->count() > 0){
                        foreach($rols as $r){
                            $roles .= '<span class="badge bg-primary">'.$r.'</span>&nbsp;';
                        }
                    }else{
                        $roles = '-';
                    }
                    
                    return $roles;
                })
                ->addColumn('action', function(User $user){
                    return '<div class="text-center">
                            <form action="'. route('users.destroy',$user->id) .'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                                <a href="'. route("users.edit",$user->id) .'" class="edit btn btn-success btn-sm"><i class="bi bi-pencil"></i> Editar</a> 
                                <a href="javascript:void(0)" class="delete btn btn-danger btn-sm"><i class="bi bi-trash"></i> Eliminar</a>
                            </form>
                            </div>';
                })
                ->rawColumns(['roles', 'proceso', 'action'])
                ->toJson();
        }

        return view('user.index');
    }

    public function create()
    {
        // ----- Security Policy---------
        $this->authorize('create', User::class);

        $user = new User();
        $procesos = Proceso::all()->pluck('nombre', 'id');
        $roles = Role::all()->pluck('name', 'name');

        return view('user.create', compact('user', 'roles', 'procesos'));
    }

    public function store(Request $request)
    {
        // ----- Security Policy---------
        $this->authorize('create', User::class);

        request()->validate([
            'name' => ['required', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'proceso_id' => '',
            'roles' => ['required'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'proceso_id' => $request->especialista_id
        ]);

        $user->assignRole($request->roles);

        return redirect()->route('users.index')
            ->with('success', 'El elemento se ha insertado corréctamente.');
    }

    public function edit($id)
    {
        // ----- Security Policy---------
        $this->authorize('update', User::class);

        $user = User::find($id);
        $procesos = Proceso::all()->pluck('nombre', 'id');
        $roles = Role::all()->pluck('name', 'id');

        return view('user.edit', compact('user', 'procesos', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        // ----- Security Policy---------
        $this->authorize('update', User::class);

        request()->validate([
            'name' => ['required', new Alphanum_spaces,'unique:users,name,'.$user->id],
            'email' => ['required', 'email', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'proceso_id' => '',
            'roles' => ['required'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'proceso_id' => $request->proceso_id
        ]);

        if($request->password){
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        foreach($user->roles as $r){
            $user->removeRole($r);
        }

        $user->assignRole($request->roles);

        return redirect()->route('users.index')
            ->with('success', 'El elemento se ha editado corréctamente.');
    }

    public function destroy($id)
    {
        // ----- Security Policy---------
        $this->authorize('delete', User::class);

        $user = User::find($id)->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
    
}
