<?php

namespace App\Http\Controllers;

use App\Models\Fuente;
use Illuminate\Http\Request;
use App\Rules\Alphanum_spaces;

class FuenteController extends Controller
{

    public function index(Request $request)
    {
        // ----- Security Policy---------
        $this->authorize('index', Fuente::class);

        if ($request->ajax()) {
            $data = Fuente::orderBy('id', 'desc')->get();
            
            return dataTables()->of($data)
                ->editColumn('id','')
                ->addColumn('action', function(Fuente $fuente){
                    return '<div class="text-center">
                            <form action="'. route('fuentes.destroy',$fuente->id) .'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                                <a href="'. route("fuentes.edit",$fuente->id) .'" class="edit btn btn-success btn-sm"><i class="bi bi-pencil"></i> Editar</a> 
                                <a href="javascript:void(0)" class="delete btn btn-danger btn-sm"><i class="bi bi-trash"></i> Eliminar</a>
                            </form>
                            </div>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('fuente.index');
    }

    public function create()
    {
        // ----- Security Policy---------
        $this->authorize('create', Fuente::class);

        $fuente = new Fuente();

        return view('fuente.create', compact('fuente'));
    }

    public function store(Request $request)
    {
        // ----- Security Policy---------
        $this->authorize('create', Fuente::class);

        $validate = request()->validate([
            'nombre' => ['required', new Alphanum_spaces, 'unique:fuentes']
        ]);

        $fuente = Fuente::create($validate);

        return redirect()->route('fuentes.index')
            ->with('success', 'El elemento se ha insertado corréctamente.');
    }

    public function edit($id)
    {
        // ----- Security Policy---------
        $this->authorize('update', Fuente::class);

        $fuente = Fuente::find($id);

        return view('fuente.edit', compact('fuente'));
    }

    public function update(Request $request, Fuente $fuente)
    {
        // ----- Security Policy---------
        $this->authorize('update', Fuente::class);

        $validate = request()->validate([
            'nombre' => ['required', new Alphanum_spaces, 'unique:fuentes,nombre,'. $fuente->id]
        ]);

        $fuente->update($validate);

        return redirect()->route('fuentes.index')
            ->with('success', 'El elemento se ha editado corréctamente.');
    }

    public function destroy($id)
    {
        // ----- Security Policy---------
        $this->authorize('delete', Fuente::class);

        try {
            $fuente = Fuente::find($id)->delete();

            return redirect()->route('fuentes.index')
            ->with('success', 'El elemento se ha eliminado corréctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('fuentes.index')
            ->with('danger', 'No se pudo eliminar el elemento seleccionado, ya que puede estar siendo usado.'); 
        }
    }
    
}
