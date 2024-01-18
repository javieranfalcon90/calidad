<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\Alphanum_spaces;
use App\Models\Role;
use App\Models\Permission;

class RoleController extends Controller
{

    public function index(Request $request)
    {
        // ----- Security Policy---------
        $this->authorize('index', Role::class);

        if ($request->ajax()) {
            $data = Role::orderBy('id', 'desc')->get();
            return dataTables()->of($data)
                ->editColumn('id','')
                ->addColumn('permissions', function(Role $role){

                    $permisos = '';
                    $permissions = $role->permissions()->get();
                    foreach($permissions as $p){
                        $permisos .= '<span class="badge bg-primary">'.$p->name.'</span>&nbsp;';
                    }
                    return $permisos;
                })
                ->addColumn('action', function(Role $role){
                    return '<div class="text-center">
                            <form action="'. route('roles.destroy',$role->id) .'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                                <a href="'. route("roles.edit",$role->id) .'" class="edit btn btn-success btn-sm"><i class="bi bi-pencil"></i> Editar</a> 
                                <a href="javascript:void(0)" class="delete btn btn-danger btn-sm"><i class="bi bi-trash"></i> Eliminar</a>
                            </form>
                            </div>';
                })
                ->rawColumns(['permissions', 'action'])
                ->toJson();
        }

        return view('role.index');
    }

    public function create()
    {
        // ----- Security Policy---------
        $this->authorize('create', Role::class);

        $role = new Role();
        $permissions = Permission::all();

        $g = [];
        foreach($permissions as $p){
            $g[] = $p->group;
        }

        $groups = array_unique($g);
       
        return view('role.create', compact('role', 'permissions', 'groups'));
    }

    public function store(Request $request)
    {
        // ----- Security Policy---------
        $this->authorize('create', Role::class);

        $validate = request()->validate([
            'name' => ['required', 'unique:roles']
        ]);

        $role = Role::create($validate);

        $role->syncPermissions($request->permissions);

        return redirect()->route('roles.index')
            ->with('success', 'El elemento se ha insertado corréctamente.');
    }

    public function edit($id)
    {
        // ----- Security Policy---------
        $this->authorize('update', Role::class);

        $role = Role::find($id);
        $permissions = Permission::all();

        $g = [];
        foreach($permissions as $p){
            $g[] = $p->group;
        }

        $groups = array_unique($g);

        return view('role.edit', compact('role', 'permissions', 'groups'));
    }

    public function update(Request $request, Role $role)
    {
        // ----- Security Policy---------
        $this->authorize('update', Role::class);

        $validate = request()->validate([
            'name' => ['required', 'unique:roles,name,'. $role->id]
        ]);

        $role->update($validate);

        $role->syncPermissions($request->permissions);

        return redirect()->route('roles.index')
            ->with('success', 'El elemento se ha editado corréctamente.');
    }

    public function destroy($id)
    {
        // ----- Security Policy---------
        $this->authorize('delete', Role::class);

        try {
            $role = Role::find($id)->delete();

            return redirect()->route('roles.index')
            ->with('success', 'El elemento se ha eliminado corréctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('roles.index')
            ->with('danger', 'No se pudo eliminar el elemento seleccionado, ya que puede estar siendo usado.'); 
        }
    }
    
}
