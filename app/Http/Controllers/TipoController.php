<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use Illuminate\Http\Request;
use App\Rules\Alphanum_spaces;

class TipoController extends Controller
{

    public function index(Request $request)
    {
        // ----- Security Policy---------
        $this->authorize('index', Tipo::class);

        if ($request->ajax()) {
            $data = Tipo::orderBy('id', 'desc')->get();
            
            return dataTables()->of($data)
                ->editColumn('id','')
                ->addColumn('action', function(Tipo $tipo){
                    return '<div class="text-center">
                            <form action="'. route('tipos.destroy',$tipo->id) .'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                                <a href="'. route("tipos.edit",$tipo->id) .'" class="edit btn btn-success btn-sm"><i class="bi bi-pencil"></i> Editar</a> 
                                <a href="javascript:void(0)" class="delete btn btn-danger btn-sm"><i class="bi bi-trash"></i> Eliminar</a>
                            </form>
                            </div>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('tipo.index');
    }

    public function create()
    {
        // ----- Security Policy---------
        $this->authorize('create', Tipo::class);

        $tipo = new Tipo();
        return view('tipo.create', compact('tipo'));
    }

    public function store(Request $request)
    {
        // ----- Security Policy---------
        $this->authorize('create', Tipo::class);

        $validate = request()->validate([
            'nombre' => ['required', new Alphanum_spaces, 'unique:tipos']
        ]);

        $tipo = Tipo::create($validate);

        return redirect()->route('tipos.index')
            ->with('success', 'El elemento se ha insertado corréctamente.');
    }

    public function edit($id)
    {
        // ----- Security Policy---------
        $this->authorize('update', Tipo::class);

        $tipo = Tipo::find($id);

        return view('tipo.edit', compact('tipo'));
    }

    public function update(Request $request, Tipo $tipo)
    {
        // ----- Security Policy---------
        $this->authorize('update', Tipo::class);

        $validate = request()->validate([
            'nombre' => ['required', new Alphanum_spaces, 'unique:tipos,nombre,'. $tipo->id]
        ]);

        $tipo->update($validate);

        return redirect()->route('tipos.index')
            ->with('success', 'El elemento se ha editado corréctamente.');
    }

    public function destroy($id)
    {
        // ----- Security Policy---------
        $this->authorize('delete', Tipo::class);

        try {
            $tipo = Tipo::find($id)->delete();

            return redirect()->route('tipos.index')
            ->with('success', 'El elemento se ha eliminado corréctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('tipos.index')
            ->with('danger', 'No se pudo eliminar el elemento seleccionado, ya que puede estar siendo usado.'); 
        }
    }
    
}
