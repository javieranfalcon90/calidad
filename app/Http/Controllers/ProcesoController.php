<?php

namespace App\Http\Controllers;

use App\Models\Proceso;
use Illuminate\Http\Request;
use App\Rules\Alphanum_spaces;

class ProcesoController extends Controller
{

    public function index(Request $request)
    {
        // ----- Security Policy---------
        $this->authorize('index', Proceso::class);

        if ($request->ajax()) {
            $data = Proceso::orderBy('id', 'desc')->get();
            
            return dataTables()->of($data)
                ->editColumn('id','')
                ->addColumn('action', function(Proceso $proceso){
                    return '<div class="text-center">
                            <form action="'. route('procesos.destroy',$proceso->id) .'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                                <a href="'. route("procesos.edit",$proceso->id) .'" class="edit btn btn-success btn-sm"><i class="bi bi-pencil"></i> Editar</a> 
                                <a href="javascript:void(0)" class="delete btn btn-danger btn-sm"><i class="bi bi-trash"></i> Eliminar</a>
                            </form>
                            </div>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('proceso.index');
    }

    public function create()
    {
        // ----- Security Policy---------
        $this->authorize('create', Proceso::class);

        $proceso = new Proceso();
        return view('proceso.create', compact('proceso'));
    }

    public function store(Request $request)
    {
        // ----- Security Policy---------
        $this->authorize('create', Proceso::class);

        $validate = request()->validate([
            'nombre' => ['required', new Alphanum_spaces, 'unique:procesos']
        ]);

        $proceso = Proceso::create($validate);

        return redirect()->route('procesos.index')
            ->with('success', 'El elemento se ha insertado corréctamente.');
    }

    public function edit($id)
    {
        // ----- Security Policy---------
        $this->authorize('update', Proceso::class);

        $proceso = Proceso::find($id);

        return view('proceso.edit', compact('proceso'));
    }

    public function update(Request $request, Proceso $proceso)
    {
        // ----- Security Policy---------
        $this->authorize('update', Proceso::class);

        $validate = request()->validate([
            'nombre' => ['required', new Alphanum_spaces, 'unique:procesos,nombre,'. $proceso->id]
        ]);

        $proceso->update($validate);

        return redirect()->route('procesos.index')
            ->with('success', 'El elemento se ha editado corréctamente.');
    }

    public function destroy($id)
    {
        // ----- Security Policy---------
        $this->authorize('delete', Proceso::class);

        try {
            $proceso = Proceso::find($id)->delete();

            return redirect()->route('procesos.index')
            ->with('success', 'El elemento se ha eliminado corréctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('procesos.index')
            ->with('danger', 'No se pudo eliminar el elemento seleccionado, ya que puede estar siendo usado.'); 
        }
    }
    
}
