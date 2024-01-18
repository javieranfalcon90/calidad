<?php

namespace App\Http\Controllers;

use App\Models\Valoracion;
use App\Models\Efectividad;
use App\Models\Riesgo;
use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\Alphanum_spaces;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RiesgoAlert;


class ValoracionController extends Controller
{

    public function create(Request $request)
    {
        $riesgo = Riesgo::find($request->riesgo_id);
        // ----- Security Policy---------
        $this->authorize('create', [Valoracion::class, $riesgo]);

        $riesgo_id = $request->riesgo_id;
        $efectividades = Efectividad::all()->pluck('nombre', 'id');

        $valoracion = new Valoracion();
        return view('valoracion.create', compact('valoracion', 'riesgo_id', 'efectividades'));
    }

    public function store(Request $request)
    {
        $riesgo = Riesgo::find($request->riesgo_id);
        // ----- Security Policy---------
        $this->authorize('create', [Valoracion::class, $riesgo]);
        
        $validate = request()->validate([
            'riesgo_id' => 'required',
            'descripcion' => ['required'],
            'fecha' => ['required', 'date'],
            'efectividad_id' => 'required',
        ]);

        $valoracion = Valoracion::create($validate);

        $users = User::role('ROLE_CALIDAD')->get();

        $valoracion->riesgo->update(['estado' => 'Evaluado']);

        if(!$users->isEmpty()){
            Notification::send($users, new RiesgoAlert($valoracion->riesgo));
        }

        return redirect()->route('riesgos.show', $valoracion->riesgo->id)
            ->with('success', 'El elemento se ha insertado corréctamente.');
    }

    public function edit($id)
    {
        $valoracion = Valoracion::find($id);
        // ----- Security Policy---------
        $this->authorize('update', $valoracion);

        $efectividades = Efectividad::all()->pluck('nombre', 'id');
        $riesgo_id = $valoracion->riesgo_id;

        return view('valoracion.edit', compact('valoracion', 'riesgo_id', 'efectividades'));
    }

    public function update(Request $request, Valoracion $valoracion)
    {
        // ----- Security Policy---------
        $this->authorize('update', $valoracion);

        $validate = request()->validate([
            'riesgo_id' => 'required',
            'descripcion' => ['required'],
            'conclusion' => ['required'],
            'fecha' => ['required', 'date'],
            'efectividad_id' => 'required'
        ]);

        $valoracion->update($validate);

        return redirect()->route('riesgos.show', $valoracion->riesgo->id)
            ->with('success', 'El elemento se ha editado corréctamente.');
    }

    public function destroy($id)
    {
        $valoracion = Valoracion::find($id);
        // ----- Security Policy---------
        $this->authorize('delete', $valoracion);

        try {
            
            $riesgo = $valoracion->riesgo;
            $valoracion->delete();

            $riesgo->update(['estado' => 'En Seguimiento']);

            return redirect()->route('riesgos.show', $riesgo->id)
            ->with('success', 'El elemento se ha eliminado corréctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('riesgos.show', $riesgo->id)
            ->with('danger', 'No se pudo eliminar el elemento seleccionado, ya que puede estar siendo usado.'); 
        }
    }

}
