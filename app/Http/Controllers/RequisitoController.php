<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requisito;
use App\Rules\Alphanum_spaces;

class RequisitoController extends Controller
{

    public function index(Request $request)
    {
        // ----- Security Policy---------
        $this->authorize('index', Requisito::class);

        if ($request->ajax()) {
            $data = Requisito::orderBy('id', 'desc')->get();
            
            return dataTables()->of($data)
                ->editColumn('id','')
                ->addColumn('action', function(Requisito $requisito){
                    return '<div class="text-center">
                            <form action="'. route('requisitos.destroy',$requisito->id) .'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                                <a href="'. route("requisitos.edit",$requisito->id) .'" class="edit btn btn-success btn-sm"><i class="bi bi-pencil"></i> Editar</a> 
                                <a href="javascript:void(0)" class="delete btn btn-danger btn-sm"><i class="bi bi-trash"></i> Eliminar</a>
                            </form>
                            </div>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('requisito.index');
    }

    public function create()
    {
        // ----- Security Policy---------
        $this->authorize('create', Requisito::class);

        $requisito = new Requisito();

        return view('requisito.create', compact('requisito'));
    }

    public function store(Request $request)
    {
        // ----- Security Policy---------
        $this->authorize('create', Requisito::class);

        $validate = request()->validate([
            'nombre' => ['required', new Alphanum_spaces, 'unique:requisitos']
        ]);

        $requisito = Requisito::create($validate);

        return redirect()->route('requisitos.index')
            ->with('success', 'El elemento se ha insertado corréctamente.');
    }

    public function edit($id)
    {
        // ----- Security Policy---------
        $this->authorize('update', Requisito::class);

        $requisito = Requisito::find($id);

        return view('requisito.edit', compact('requisito'));
    }

    public function update(Request $request, Requisito $requisito)
    {
        // ----- Security Policy---------
        $this->authorize('update', Requisito::class);

        $validate = request()->validate([
            'nombre' => ['required', new Alphanum_spaces, 'unique:requisitos,nombre,'. $requisito->id]
        ]);

        $requisito->update($validate);

        return redirect()->route('requisitos.index')
            ->with('success', 'El elemento se ha editado corréctamente.');
    }

    public function destroy($id)
    {
        // ----- Security Policy---------
        $this->authorize('delete', Requisito::class);

        try {
            $requisito = Requisito::find($id)->delete();

            return redirect()->route('requisitos.index')
            ->with('success', 'El elemento se ha eliminado corréctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('requisitos.index')
            ->with('danger', 'No se pudo eliminar el elemento seleccionado, ya que puede estar siendo usado.'); 
        }
    }
    
}
