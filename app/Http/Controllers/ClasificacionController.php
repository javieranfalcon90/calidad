<?php

namespace App\Http\Controllers;

use App\Models\Clasificacion;
use Illuminate\Http\Request;
use App\Rules\Alphanum_spaces;

class ClasificacionController extends Controller
{

    public function index(Request $request)
    {
        // ----- Security Policy---------
        $this->authorize('index', Clasificacion::class);

        if ($request->ajax()) {
            $data = Clasificacion::orderBy('id', 'desc')->get();
            
            return dataTables()->of($data)
                ->editColumn('id','')
                ->addColumn('action', function(Clasificacion $clasificacion){
                    return '<div class="text-center">
                            <form action="'. route('clasificaciones.destroy',$clasificacion->id) .'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                                <a href="'. route("clasificaciones.edit",$clasificacion->id) .'" class="edit btn btn-success btn-sm"><i class="bi bi-pencil"></i> Editar</a> 
                                <a href="javascript:void(0)" class="delete btn btn-danger btn-sm"><i class="bi bi-trash"></i> Eliminar</a>
                            </form>
                            </div>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('clasificacion.index');
    }

    public function create()
    {
        // ----- Security Policy---------
        $this->authorize('create', Clasificacion::class);

        $clasificacion = new Clasificacion();
        return view('clasificacion.create', compact('clasificacion'));
    }

    public function store(Request $request)
    {
        // ----- Security Policy---------
        $this->authorize('create', Clasificacion::class);

        $validate = request()->validate([
            'nombre' => ['required', new Alphanum_spaces, 'unique:clasificaciones']
        ]);

        $clasificacion = Clasificacion::create($validate);

        return redirect()->route('clasificaciones.index')
            ->with('success', 'El elemento se ha insertado corréctamente.');
    }

    public function edit($id)
    {
        // ----- Security Policy---------
        $this->authorize('update', Clasificacion::class);

        $clasificacion = Clasificacion::find($id);

        return view('clasificacion.edit', compact('clasificacion'));
    }

    public function update(Request $request, Clasificacion $clasificacion)
    {
        // ----- Security Policy---------
        $this->authorize('update', Clasificacion::class);

        $validate = request()->validate([
            'nombre' => ['required', new Alphanum_spaces, 'unique:clasificaciones,nombre,'. $clasificacion->id]
        ]);

        $clasificacion->update($validate);

        return redirect()->route('clasificaciones.index')
            ->with('success', 'El elemento se ha editado corréctamente.');
    }

    public function destroy($id)
    {
        // ----- Security Policy---------
        $this->authorize('delete', Clasificacion::class);

        try {
            $clasificacion = Clasificacion::find($id)->delete();

            return redirect()->route('clasificaciones.index')
            ->with('success', 'El elemento se ha eliminado corréctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('clasificaciones.index')
            ->with('danger', 'No se pudo eliminar el elemento seleccionado, ya que puede estar siendo usado.'); 
        }
    }
    
}
