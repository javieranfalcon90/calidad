<?php

namespace App\Http\Controllers;

use App\Models\Seguimiento;
use App\Models\Accion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class SeguimientoController extends Controller
{

    public function create(Request $request)
    {
        $accion = Accion::find($request->accion_id);
        // ----- Security Policy---------
        $this->authorize('create', [Seguimiento::class, $accion]);

        $accion_id = $request->accion_id;

        $seguimiento = new Seguimiento();
        return view('seguimiento.create', compact('seguimiento', 'accion_id', 'accion' ));
    }

    public function store(Request $request)
    {
        $accion = Accion::find($request->accion_id);
        // ----- Security Policy---------
        $this->authorize('create', [Seguimiento::class, $accion]);

        $request->request->add(['user_id' => Auth::user()->id]); //add request

        $validate = request()->validate([
            'seguimiento' => 'required',
            'evidencia' => '',
            'fecha' => 'required',
            'accion_id' => 'required',
            'user_id' => 'required'
        ]);
       
        $seguimiento = Seguimiento::create($validate);

        $seguimiento->accion->update(['estado' => 'En Seguimiento']);

        $newName = null;
        if($request->hasFile('evidencia') && $seguimiento){
            $newName = time(). '.' .$request->evidencia->extension();
            $request->file('evidencia')->storeAs('evidencias', $newName, 'public');

            $seguimiento->update(['evidencia' => $newName]);
        }

        

        return redirect()->route('acciones.show', $seguimiento->accion_id)
            ->with('success', 'El elemento se ha insertado corréctamente.');
    }

    public function edit($id)
    {
        $seguimiento = Seguimiento::find($id);
        // ----- Security Policy---------
        $this->authorize('update', $seguimiento);

        $accion_id = $seguimiento->accion_id;
        $accion = $seguimiento->accion;

        return view('seguimiento.edit', compact('seguimiento', 'accion_id', 'accion'));
    }

    public function update(Request $request, Seguimiento $seguimiento)
    {
        // ----- Security Policy---------
        $this->authorize('update', $seguimiento);

        $request->request->add(['user_id' => Auth::user()->id]); //add request

        $validate = request()->validate([
            'seguimiento' => 'required',
            'evidencia' => '',
            'fecha' => 'required',
            'user_id' => 'required'
        ]);

        $seguimiento->update($validate);

        $newName = null;
        if($request->hasFile('evidencia') && $seguimiento){
            $newName = time(). '.' .$request->evidencia->extension();
            $request->file('evidencia')->storeAs('evidencias', $newName, 'public');

            $seguimiento->update(['evidencia' => $newName]);
        }

        

        return redirect()->route('acciones.show', $seguimiento->accion_id)
            ->with('success', 'El elemento se ha editado corréctamente.');
    }

    public function destroy($id)
    {
        $seguimiento = Seguimiento::find($id);
        // ----- Security Policy---------
        $this->authorize('delete', $seguimiento);

        try {
            $file_path = public_path('storage/evidencias/'.$seguimiento->evidencia);
            $seguimiento->delete();
            if(file_exists($file_path)){
                unlink($file_path);
            }

            return redirect()->route('acciones.show', $seguimiento->accion_id)
            ->with('success', 'El elemento se ha eliminado corréctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('acciones.show', $seguimiento->accion_id)
            ->with('danger', 'No se pudo eliminar el elemento seleccionado, ya que puede estar siendo usado.'); 
        }
    }
    
}
