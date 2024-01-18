<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Rules\Alphanum_spaces;

class PermissionController extends Controller
{

    public function index(Request $request)
    {
        // ----- Security Policy---------
        $this->authorize('index', Permission::class);

        if ($request->ajax()) {
            $data = Permission::orderBy('id', 'desc')->get();
            return dataTables()->of($data)
                ->editColumn('id','')
                ->addColumn('action', function(Permission $permission){
                    return '<div class="text-center">
                            <form action="'. route('permissions.destroy',$permission->id) .'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                                <a href="'. route("permissions.edit",$permission->id) .'" class="edit btn btn-success btn-sm"><i class="bi bi-pencil"></i> Editar</a> 
                                <a href="javascript:void(0)" class="delete btn btn-danger btn-sm"><i class="bi bi-trash"></i> Eliminar</a>
                            </form>
                            </div>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('permission.index');
    }

    public function create()
    {
        // ----- Security Policy---------
        $this->authorize('create', Permission::class);

        $permission = new Permission();
        return view('permission.create', compact('permission'));
    }

    public function store(Request $request)
    {
        // ----- Security Policy---------
        $this->authorize('create', Permission::class);

        $validate = request()->validate([
            'name' => ['required', 'unique:permissions'],
            'group' => 'required'
        ]);

        $permission = Permission::create($validate);

        return redirect()->route('permissions.index')
            ->with('success', 'El elemento se ha insertado corréctamente.');
    }

    public function edit($id)
    {
        // ----- Security Policy---------
        $this->authorize('update', Permission::class);

        $permission = Permission::find($id);

        return view('permission.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        // ----- Security Policy---------
        $this->authorize('update', Permission::class);

        $validate = request()->validate([
            'name' => ['required', 'unique:permissions,name,'. $permission->id],
            'group' => 'required'
        ]);

        $permission->update($validate);

        return redirect()->route('permissions.index')
            ->with('success', 'El elemento se ha editado corréctamente.');
    }

    public function destroy($id)
    {
        // ----- Security Policy---------
        $this->authorize('delete', Permission::class);

        try {
            $permission = Permission::find($id)->delete();

            return redirect()->route('permissions.index')
            ->with('success', 'El elemento se ha eliminado corréctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('permissions.index')
            ->with('danger', 'No se pudo eliminar el elemento seleccionado, ya que puede estar siendo usado.'); 
        }
    }
    
}
