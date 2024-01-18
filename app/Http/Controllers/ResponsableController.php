<?php

namespace App\Http\Controllers;

use App\Models\Responsable;
use Illuminate\Http\Request;
use App\Rules\Alphanum_spaces;

class ResponsableController extends Controller
{

    public function index(Request $request)
    {
        // ----- Security Policy---------
        $this->authorize('index', Responsable::class);

        if ($request->ajax()) {
            $data = Responsable::orderBy('id', 'desc')->get();
            
            return dataTables()->of($data)
                ->editColumn('id','')
                ->addColumn('action', function(Responsable $responsable){
                    return '<div class="text-center">
                            <form action="'. route('responsables.destroy',$responsable->id) .'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                                <a href="'. route("responsables.edit",$responsable->id) .'" class="edit btn btn-success btn-sm"><i class="bi bi-pencil"></i> Editar</a> 
                                <a href="javascript:void(0)" class="delete btn btn-danger btn-sm"><i class="bi bi-trash"></i> Eliminar</a>
                            </form>
                            </div>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('responsable.index');
    }

    public function create()
    {
        // ----- Security Policy---------
        $this->authorize('create', Responsable::class);

        $responsable = new Responsable();
        return view('responsable.create', compact('responsable'));
    }

    public function store(Request $request)
    {
        // ----- Security Policy---------
        $this->authorize('create', Responsable::class);

        $validate = request()->validate([
            'nombre' => ['required', new Alphanum_spaces, 'unique:responsables']
        ]);

        $responsable = Responsable::create($validate);

        return redirect()->route('responsables.index')
            ->with('success', 'El elemento se ha insertado corréctamente.');
    }

    public function edit($id)
    {
        // ----- Security Policy---------
        $this->authorize('update', Responsable::class);

        $responsable = Responsable::find($id);

        return view('responsable.edit', compact('responsable'));
    }

    public function update(Request $request, Responsable $responsable)
    {
        // ----- Security Policy---------
        $this->authorize('update', Responsable::class);

        $validate = request()->validate([
            'nombre' => ['required', new Alphanum_spaces, 'unique:responsables,nombre,'. $responsable->id]
        ]);

        $responsable->update($request->all());

        return redirect()->route('responsables.index')
            ->with('success', 'El elemento se ha editado corréctamente.');
    }

    public function destroy($id)
    {
        // ----- Security Policy---------
        $this->authorize('delete', Responsable::class);

        try {
            $responsable = Responsable::find($id)->delete();

            return redirect()->route('responsables.index')
            ->with('success', 'El elemento se ha eliminado corréctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('responsables.index')
            ->with('danger', 'No se pudo eliminar el elemento seleccionado, ya que puede estar siendo usado.'); 
        }
    }
    
}
