<?php

namespace App\Http\Controllers;

use App\Models\Accion;
use App\Models\Tipo;
use App\Models\Responsable;
use App\Models\Analisis;
use App\Models\Oportunidad;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AccionAlert;

class AccionController extends Controller
{

    public function create(Request $request)
    {

        if($request->accionable_type == 'App\Models\Oportunidad'){
            $entity = Oportunidad::find($request->accionable_id);
        }else{
            $entity = Analisis::find($request->accionable_id);
        }
        // ----- Security Policy---------
        $this->authorize('create', [Accion::class, $entity]);


        $accionable_id = $request->accionable_id;
        $accionable_type = $request->accionable_type;

        if($request->accionable_type == 'App\Models\Oportunidad'){
            $toid = $request->accionable_id;
            $type = $request->accionable_type;
        }else{
            $toid = Analisis::find($request->accionable_id)->analisisable_id;
            $type = Analisis::find($request->accionable_id)->analisisable_type;
        }

        $tipos = Tipo::all()->pluck('nombre', 'id');
        $responsables = Responsable::all()->pluck('nombre', 'id');

        $accion = new Accion();
        return view('accion.create', compact('accion', 'tipos', 'responsables', 'accionable_id', 'accionable_type','toid', 'type'));
    }

    public function store(Request $request)
    {
        if($request->accionable_type == 'App\Models\Oportunidad'){
            $entity = Oportunidad::find($request->accionable_id);
        }else{
            $entity = Analisis::find($request->accionable_id);
        }
        // ----- Security Policy---------
        $this->authorize('create', [Accion::class, $entity]);

        $request->request->add(['estado' => 'Nuevo']); //add request

        $validate = request()->validate([
            'accion' => 'required',
            'tipo_id' => 'required',
            'responsable_id' => 'required',
            'fechacumplimiento' => ['required', 'date'],
            'recurso' => '',
            'estado' => 'required',
            'accionable_id' => 'required',
            'accionable_type' => 'required',
        ]);

        $accion = Accion::create($validate);

        $users = User::role('ROLE_CALIDAD')->get();
        if(!$users->isEmpty()){
            Notification::send($users, new AccionAlert($accion));
        }

        if($accion->accionable_type == 'App\Models\Oportunidad'){
            $accion->accionable->update(['estado' => 'En Seguimiento']);
            $redirect = 'oportunidades.show';
            $to = $accion->accionable->id;
        }else{
            $accion->accionable->analisisable->update(['estado' => 'En Seguimiento']); 
            if($accion->accionable->analisisable_type == 'App\Models\Noconformidad'){
                $redirect = 'noconformidades.show';
            }else{
                $redirect = 'riesgos.show';
            } 
            $to = $accion->accionable->analisisable->id;
        }
        
        return redirect()->route($redirect, $to)
            ->with('success', 'El elemento se ha insertado corréctamente.');
    }

    public function show($id)
    {
        $accion = Accion::find($id);
        // ----- Security Policy---------
        $this->authorize('show', $accion);

        return view('accion.show', compact('accion'));
    }

    public function edit( $id)
    {
        $accion = Accion::find($id);
        // ----- Security Policy---------
        $this->authorize('update', $accion);

        $accionable_id= $accion->accionable_id;
        $accionable_type= $accion->accionable_type;

        if($accion->accionable_type == 'App\Models\Oportunidad'){
            $toid = $accion->accionable_id;
            $type = $accion->accionable_type;
        }else{
            $toid = Analisis::find($accion->accionable_id)->analisisable_id;
            $type = Analisis::find($accion->accionable_id)->analisisable_type;
        }

        $tipos = Tipo::all()->pluck('nombre', 'id');
        $responsables = Responsable::all()->pluck('nombre', 'id');

        return view('accion.edit', compact('accion', 'responsables', 'tipos', 'accionable_id', 'accionable_type','toid', 'type'));
    }

    public function update(Request $request, Accion $accion)
    {
        // ----- Security Policy---------
        $this->authorize('update', $accion);

        $validate = request()->validate([
            'accion' => 'required',
            'responsable_id' => 'required',
            'fechacumplimiento' => ['required', 'date'],
            'recurso' => '',
        ]);

        $accion->update($validate);

        return redirect()->route('acciones.show', $accion->id)
            ->with('success', 'El elemento se ha editado corréctamente.');
    }

    public function destroy($id)
    {
        $accion = Accion::find($id);
        // ----- Security Policy---------
        $this->authorize('delete', $accion);

        if($accion->seguimientos->isEmpty()){

            if($accion->accionable_type == 'App\Models\Oportunidad'){
                $accion->accionable->update(['estado' => 'En Seguimiento']);
                $redirect = 'oportunidades.show';
                $to = $accion->accionable->id;
            }else{
                $accion->accionable->analisisable->update(['estado' => 'En Seguimiento']); 
                if($accion->accionable->analisisable_type == 'App\Models\NoConformidad'){
                    $redirect = 'noconformidades.show';
                }else{
                    $redirect = 'riesgos.show';
                } 
                $to = $accion->accionable->analisisable->id;
            }

            $accion->delete();

            return redirect()->route($redirect, $to)
                ->with('success', 'El elemento se ha eliminado corréctamente.');
        }else{
            return redirect()->route('acciones.show', $accion->id)
                ->with('danger', 'No se pudo eliminar el elemento seleccionado, ya que puede estar siendo usado.'); 
        }

    }

    public function cerrar(Request $request, $id)
    {

        $accion = Accion::find($id);
        // ----- Security Policy---------
        $this->authorize('close', $accion);

        if ($accion->estado == 'En Seguimiento') {
            
            if($request->cumplimiento){
                $cumplimiento = $request->cumplimiento;
            }else{
                $cumplimiento ="Cumplido";
            }

            $accion->update(['fechacierre' => Carbon::now(), 'estado' => 'Cerrado', 'cumplimiento' => $cumplimiento]);

            if($accion->accionable_type == "App\Models\Oportunidad"){
                $u = $accion->accionable->proceso->user;
            }else{
                $u = $accion->accionable->analisisable->proceso->user;
            }
            Notification::send($u, new AccionAlert($accion));
            

            return redirect()->route('acciones.show', $accion->id)
                ->with('success', 'El elemento se ha cerrado corréctamente.');
        }else{
            $accion->update(['fechacierre' => null, 'estado' => 'En Seguimiento', 'cumplimiento' => null]);

            return redirect()->route('acciones.show', $accion->id)
                ->with('success', 'El elemento se ha re abierto corréctamente.');
        } 

        

    }

}
