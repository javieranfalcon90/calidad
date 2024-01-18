<?php

namespace App\Http\Controllers;

use App\Models\Efectividad;
use Illuminate\Http\Request;
use App\Rules\Alphanum_spaces;

class EfectividadController extends Controller
{

    public function index(Request $request)
    {
        // ----- Security Policy---------
        $this->authorize('index', Efectividad::class);

        if ($request->ajax()) {
            $data = Efectividad::orderBy('id', 'desc')->get();
            
            return dataTables()->of($data)
                ->editColumn('id','')
                ->addColumn('action', function(Efectividad $efectividad){
                    return '<div class="text-center">
                            <form action="'. route('efectividades.destroy',$efectividad->id) .'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                                <a href="'. route("efectividades.edit",$efectividad->id) .'" class="edit btn btn-success btn-sm"><i class="bi bi-pencil"></i> Editar</a> 
                                <a href="javascript:void(0)" class="delete btn btn-danger btn-sm"><i class="bi bi-trash"></i> Eliminar</a>
                            </form>
                            </div>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('efectividad.index');
    }

    public function create()
    {
        // ----- Security Policy---------
        $this->authorize('create', Efectividad::class);

        $efectividad = new Efectividad();
        return view('efectividad.create', compact('efectividad'));
    }

    public function store(Request $request)
    {
        // ----- Security Policy---------
        $this->authorize('create', Efectividad::class);

        $validate = request()->validate([
            'nombre' => ['required', new Alphanum_spaces, 'unique:efectividades']
        ]);

        $efectividad = Efectividad::create($validate);

        return redirect()->route('efectividades.index')
            ->with('success', 'El elemento se ha insertado corréctamente.');
    }

    public function edit($id)
    {
        // ----- Security Policy---------
        $this->authorize('update', Efectividad::class);

        $efectividad = Efectividad::find($id);

        return view('efectividad.edit', compact('efectividad'));
    }

    public function update(Request $request, Efectividad $efectividad)
    {
        // ----- Security Policy---------
        $this->authorize('update', Efectividad::class);

        $validate = request()->validate([
            'nombre' => ['required', new Alphanum_spaces, 'unique:efectividades,nombre,'. $efectividad->id]
        ]);

        $efectividade->update($validate);

        return redirect()->route('efectividades.index')
            ->with('success', 'El elemento se ha editado corréctamente.');
    }

    public function destroy($id)
    {
        // ----- Security Policy---------
        $this->authorize('delete', Efectividad::class);

        try {
            $efectividad = Efectividad::find($id)->delete();

            return redirect()->route('efectividades.index')
            ->with('success', 'El elemento se ha eliminado corréctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('efectividades.index')
            ->with('danger', 'No se pudo eliminar el elemento seleccionado, ya que puede estar siendo usado.'); 
        }
    }
    
}
