<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oportunidad;
use App\Models\Proceso;
use App\Models\User;

use App\Rules\Alphanum_spaces;
use Carbon\Carbon;

use Illuminate\Support\Facades\Notification;
use App\Notifications\OportunidadAlert;

class OportunidadController extends Controller
{
    public function index(Request $request)
    {
        // ----- Security Policy---------
        $this->authorize('index', Oportunidad::class);

        if ($request->ajax()) {

            $user = $request->user();

            if( $user->proceso ){

                $query = Oportunidad::select('oportunidades.*')
                        ->join('procesos', 'procesos.id', '=', 'oportunidades.proceso_id')
                        ->join('users', 'procesos.id', '=', 'users.proceso_id')
                        ->where('users.id', $user->id)
                        ->orderBy('oportunidades.id', 'desc');
            }else{

                $query = Oportunidad::select('oportunidades.*')
                        ->orderBy('id', 'desc');

            }

            //---------------Inicio de Seccion de Filtros Avanzados----------------------------
                $proceso = ($request->get('proceso')) ? $request->get('proceso') : '%';

                /*$fechacumplimientostartdate = null;
                $fechacumplimientoenddate = null;
                if($fechacumplimiento = $request->get('fechacumplimiento')){
                    $range = explode(" a ", $fechacumplimiento);
                    $fechacumplimientostartdate = new Carbon($range[0]);
                    $fechacumplimientoenddate = new Carbon($range[1]);

                    $query->whereBetween('oportunidades.fechacumplimiento', [$fechacumplimientostartdate, $fechacumplimientoenddate]);
                }
        
                $query->where('oportunidades.proceso_id', 'LIKE', $proceso);*/


            //---------------Fin de Seccion de Filtros Avanzados----------------------------
        
            $data = $query->get();

            return dataTables()->of($data)
                ->editColumn('id','')
                ->addColumn('codigo', function(Oportunidad $oportunidad){
                    return '<a class="btn btn-link" href="'. route('oportunidades.show', $oportunidad->id) .'">'. $oportunidad->codigo .'</a>';
                })
                ->addColumn('descripcion', function(Oportunidad $oportunidad){
                    return substr($oportunidad->descripcion, 0, 80) . '...';
                })
                ->addColumn('proceso_id', function(Oportunidad $oportunidad){
                    return $oportunidad->proceso->nombre;
                })
                ->addColumn('estado', function(Oportunidad $oportunidad){

                    if($oportunidad->estado == 'Nuevo'){
                        $estado = '<span class="badge bg-primary">'. $oportunidad->estado .'</span>';
                    }elseif($oportunidad->estado == 'En Seguimiento'){
                        $estado = '<span class="badge bg-warning">'. $oportunidad->estado .'</span>';
                    }else{
                        $estado = '<span class="badge bg-success">'. $oportunidad->estado .'</span>';
                    }

                    return $estado;
                })
                ->addColumn('fechanotificacion', function(Oportunidad $oportunidad){
                    return $oportunidad->fechanotificacion;
                })
                ->rawColumns(['codigo', 'descripcion', 'proceso_id', 'estado', 'fechanotificacion'])

                ->toJson()->header('Content-Type', 'application/json');;
        }

        $procesos = Proceso::all();

        return view('oportunidad.index', compact('procesos'));
    }

    public function create()
    {
        // ----- Security Policy---------
        $this->authorize('create', Oportunidad::class);

        $oportunidad = new Oportunidad();

        $procesos = Proceso::all()->pluck('nombre', 'id');

        return view('oportunidad.create', compact('oportunidad', 'procesos'));
    }

    public function store(Request $request)
    {
        // ----- Security Policy---------
        $this->authorize('create', Oportunidad::class);

        if(auth()->user()->proceso){
            $proceso_id = auth()->user()->proceso->id;
            $request->request->add(['proceso_id' => $proceso_id]); //add request
        }

        $request->request->add(['estado' => 'Nuevo']); //add request

        $validate = request()->validate([
            'codigo' => ['required', new Alphanum_spaces, 'unique:oportunidades'],
            'tipo' => 'required',
            'descripcion' => 'required',
            'proceso_id' => 'required',
            'estado' => 'required',
            'fechanotificacion' => 'required',
        ]);

        $oportunidad = Oportunidad::create($validate);

        $users = User::with('roles')->whereHas("roles", function($q) {
            $q->where("name", 'ROLE_CALIDAD');
        })->get();
        
        if($users){
            Notification::send($users, new OportunidadAlert($oportunidad));
        }

        return redirect()->route('oportunidades.show', $oportunidad->id)
            ->with('success', 'El elemento se ha insertado corréctamente.');
    }

    public function show($id)
    {
        $oportunidad = Oportunidad::find($id);
        // ----- Security Policy---------
        $this->authorize('show', $oportunidad);

       $puedeCerrar = false;
        $flag = 0;
        if($oportunidad->acciones){
            foreach ($oportunidad->acciones as $accion) {
                if($accion->estado != "Cerrado"){
                    $flag = 1;
                }
            }
        }

        if($flag == 0 && $oportunidad->estado == "En Seguimiento" && !$oportunidad->acciones->isEmpty()){
            $puedeCerrar = true;
        }

        return view('oportunidad.show', compact('oportunidad', 'puedeCerrar'));
    }

    public function edit($id)
    {
        $oportunidad = Oportunidad::find($id);
        // ----- Security Policy---------
        $this->authorize('update', $oportunidad);

        $procesos = Proceso::all()->pluck('nombre', 'id');

        return view('oportunidad.edit', compact('oportunidad', 'procesos'));
    }

    public function update(Request $request, Oportunidad $oportunidad)
    {
        // ----- Security Policy---------
        $this->authorize('update', $oportunidad);

        if(auth()->user()->proceso){
            $proceso_id = auth()->user()->proceso->id;
            $request->request->add(['proceso_id' => $proceso_id]); //add request
        }

        $validate = request()->validate([
            'codigo' => ['required', new Alphanum_spaces, 'unique:oportunidades,codigo,'. $oportunidad->id],
            'tipo' => 'required',
            'descripcion' => 'required',
            'proceso_id' => 'required',
            'fechanotificacion' => 'required'
        ]);

        $oportunidad->update($validate);

        return redirect()->route('oportunidades.show', $oportunidad->id)
            ->with('success', 'El elemento se ha editado corréctamente.');
    }

    public function destroy($id)
    {
        $oportunidad = Oportunidad::find($id);
        // ----- Security Policy---------
        $this->authorize('delete', $oportunidad);

        if($oportunidad->acciones->isEmpty()){
            $oportunidad->delete();

            return redirect()->route('oportunidades.index')
            ->with('success', 'El elemento se ha eliminado corréctamente.');
        }else{
            return redirect()->route('oportunidades.show', $id)
            ->with('danger', 'No se pudo eliminar el elemento seleccionado, ya que puede estar siendo usado.'); 
        }

    }

    public function cerrar($id)
    {
        $oportunidad = Oportunidad::find($id);
        // ----- Security Policy---------
        $this->authorize('close', $oportunidad);

        if ($oportunidad->estado == 'En Seguimiento') {
            
            $flag = 0;
            foreach($oportunidad->acciones as $a){
                if($a->cumplimiento == "No Cumplido"){
                    $flag = 1;
                    break;
                }
            }

            if($flag == 0){
                $aprovechamiento = "Aprovechado";
            }else{
                $aprovechamiento = "No Aprovechado";
            }

            $oportunidad->update(['fechacierre' => Carbon::now(), 'estado' => 'Cerrado', 'aprovechamiento' => $aprovechamiento]);

            if($oportunidad->proceso->user){
                Notification::send($oportunidad->proceso->user, new OportunidadAlert($oportunidad));
            }

            return redirect()->route('oportunidades.show', $oportunidad->id)
                ->with('success', 'El elemento se ha cerrado corréctamente.');
        }else{
            $oportunidad->update(['fechacierre' => null, 'estado' => 'En Seguimiento', 'aprovechamiento' => null]);

            return redirect()->route('oportunidades.show', $oportunidad->id)
                ->with('success', 'El elemento se ha re abierto corréctamente.');
        } 

        

    }

}
