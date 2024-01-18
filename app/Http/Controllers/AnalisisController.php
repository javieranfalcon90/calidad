<?php

namespace App\Http\Controllers;

use App\Models\Analisis;
use App\Models\Nivel;
use App\Models\Noconformidad;
use App\Models\Riesgo;
use Illuminate\Http\Request;
use App\Rules\Alphanum_spaces;

class AnalisisController extends Controller
{

    public function create(Request $request)
    {
        if($request->analisisable_type == 'App\Models\Riesgo'){
            $entity = Riesgo::find($request->analisisable_id);
        }else{
            $entity = Noconformidad::find($request->analisisable_id);
        }
        // ----- Security Policy---------
        $this->authorize('create', [Analisis::class, $entity]);

        $analisisable_id = $request->analisisable_id;
        $analisisable_type = $request->analisisable_type;

        $niveles = Nivel::all()->pluck('nombre', 'id');

        $analisis = new Analisis();
        return view('analisis.create', compact('analisis', 'niveles', 'analisisable_id', 'analisisable_type'));
    }

    public function store(Request $request)
    {

        if($request->analisisable_type == 'App\Models\Riesgo'){
            $entity = Riesgo::find($request->analisisable_id);
        }else{
            $entity = Noconformidad::find($request->analisisable_id);
        }
        // ----- Security Policy---------
        $this->authorize('create', [Analisis::class, $entity]);

        if($request->analisisable_type == 'App\Models\Noconformidad'){

            $route = 'noconformidades.show';

            $validate = request()->validate([
                'causa' => ['required'],
                'fecha' => ['required', 'date'],
                'participantes' => 'required',
                'analisisable_id' => 'required',
                'analisisable_type' => 'required'
            ]);

        }else{

            $route = 'riesgos.show';
            
            $validate = request()->validate([
                'causa' => ['required'],
                'fecha' => ['required', 'date'],
                'participantes' => 'required',
                'nivel_id' => 'required',
                'manifestacionesnegativas' => 'required',
                'analisisable_id' => 'required',
                'analisisable_type' => 'required'
            ]);

        }

        $analisis = Analisis::create($validate);

        return redirect()->route($route, $request->analisisable_id)
            ->with('success', 'El elemento se ha insertado corréctamente.');
    }

    public function edit($id)
    {
        $analisis = Analisis::find($id);
        // ----- Security Policy---------
        $this->authorize('update', $analisis);

        $niveles = Nivel::all()->pluck('nombre', 'id');

        $analisisable_id = $analisis->analisisable_id;
        $analisisable_type = $analisis->analisisable_type;

        return view('analisis.edit', compact('analisis', 'niveles', 'analisisable_id', 'analisisable_type'));
    }

    public function update(Request $request, Analisis $analisis)
    {
        // ----- Security Policy---------
        $this->authorize('update', $analisis);

        if($request->analisisable_type == 'App\Models\Noconformidad'){
            $route = 'noconformidades.show';

            $validate = request()->validate([
                'causa' => ['required'],
                'fecha' => ['required', 'date'],
                'participantes' => 'required',
                'analisisable_id' => 'required',
                'analisisable_type' => 'required'
            ]);

        }else{
            $route = 'riesgos.show';
            
            $validate = request()->validate([
                'causa' => ['required'],
                'fecha' => ['required', 'date'],
                'participantes' => 'required',
                'nivel_id' => 'required',
                'manifestacionesnegativas' => 'required',
                'analisisable_id' => 'required',
                'analisisable_type' => 'required'
            ]);
        }

        $analisis->update($validate);

        return redirect()->route($route, $analisis->analisisable_id)
            ->with('success', 'El elemento se ha editado corréctamente.');
    }

    public function destroy($id)
    {
        $analisis = Analisis::find($id);
        // ----- Security Policy---------
        $this->authorize('delete', $analisis);

        $analisisable_id = $analisis->analisisable_id;

        if($analisis->analisisable_type == 'App\Models\Noconformidad'){
            $route = 'noconformidades.show';

        }else{
            $route = 'riesgos.show';
        }

        //Si la no conformidad asociada tiene acciones
        if($analisis->acciones->isEmpty()){

            $analisis->delete();

            return redirect()->route($route, $analisisable_id)
            ->with('success', 'El elemento se ha eliminado corréctamente.');
        }else{
            return redirect()->route($route, $analisisable_id)
            ->with('danger', 'No se pudo eliminar el elemento seleccionado, ya que puede estar siendo usado.'); 
        }

    }

}
