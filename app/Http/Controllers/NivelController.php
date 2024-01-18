<?php

namespace App\Http\Controllers;

use App\Models\Nivel;
use Illuminate\Http\Request;
use App\Rules\Alphanum_spaces;

class NivelController extends Controller
{

    public function index(Request $request)
    {
        // ----- Security Policy---------
        $this->authorize('index', Nivel::class);

        if ($request->ajax()) {
            $data = Nivel::orderBy('id', 'desc')->get();
            
            return dataTables()->of($data)
                ->editColumn('id','')
                ->addColumn('action', function(Nivel $nivel){
                    return '<div class="text-center">
                            <form action="'. route('niveles.destroy',$nivel->id) .'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                                <a href="'. route("niveles.edit",$nivel->id) .'" class="edit btn btn-success btn-sm"><i class="bi bi-pencil"></i> Editar</a> 
                                <a href="javascript:void(0)" class="delete btn btn-danger btn-sm"><i class="bi bi-trash"></i> Eliminar</a>
                            </form>
                            </div>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('nivel.index');
    }

    public function create()
    {
        // ----- Security Policy---------
        $this->authorize('create', Nivel::class);

        $nivel = new Nivel();
        return view('nivel.create', compact('nivel'));
    }

    public function store(Request $request)
    {
        // ----- Security Policy---------
        $this->authorize('create', Nivel::class);

        $validate = request()->validate([
            'nombre' => ['required', new Alphanum_spaces, 'unique:niveles']
        ]);

        $nivel = Nivel::create($validate);

        return redirect()->route('niveles.index')
            ->with('success', 'El elemento se ha insertado corréctamente.');
    }

    public function edit($id)
    {
        // ----- Security Policy---------
        $this->authorize('update', Nivel::class);

        $nivel = Nivel::find($id);

        return view('nivel.edit', compact('nivel'));
    }

    public function update(Request $request, Nivel $nivel)
    {
        // ----- Security Policy---------
        $this->authorize('update', Nivel::class);

        $validate = request()->validate([
            'nombre' => ['required', new Alphanum_spaces, 'unique:niveles,nombre,'. $nivel->id]
        ]);

        $nivel->update($validate);

        return redirect()->route('niveles.index')
            ->with('success', 'El elemento se ha editado corréctamente.');
    }

    public function destroy($id)
    {
        // ----- Security Policy---------
        $this->authorize('delete', Nivel::class);

        try {
            $fuente = Nivel::find($id)->delete();

            return redirect()->route('niveles.index')
            ->with('success', 'El elemento se ha eliminado corréctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('niveles.index')
            ->with('danger', 'No se pudo eliminar el elemento seleccionado, ya que puede estar siendo usado.'); 
        }
    }
    
}
