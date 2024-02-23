<?php

namespace App\Http\Controllers;

use App\Models\Riesgo;
use Illuminate\Http\Request;
use App\Rules\Alphanum_spaces;

use App\Models\Efectividad;
use App\Models\Evaluacion;
use App\Models\Proceso;
use App\Models\User;

use Carbon\Carbon;

use Illuminate\Support\Facades\Notification;
use App\Notifications\RiesgoAlert;

class RiesgoController extends Controller
{

    public function index(Request $request)
    {

        // ----- Security Policy---------
        $this->authorize('index', Riesgo::class);

        if ($request->ajax()) {

            $user = $request->user();

            if( $user->proceso ){

                $query = Riesgo::select('riesgos.*')
                        ->join('procesos', 'procesos.id', '=', 'riesgos.proceso_id')
                        ->join('users', 'procesos.id', '=', 'users.proceso_id')
                        ->where('users.id', $user->id)
                        ->orderBy('riesgos.id', 'desc');
            }else{

                $query = Riesgo::select('riesgos.*')
                        ->orderBy('id', 'desc');
            }
            
        //---------------Inicio de Seccion de Filtros Avanzados----------------------------
            
            $proceso = '%';
            if($proceso = $request->get('proceso')){
                $query->where('riesgos.proceso_id', 'LIKE', $proceso);
            }

            $efectividad = '%';
            if($efectividad = $request->get('efectividad')){
                $query->leftjoin('valoraciones', 'riesgos.id', '=', 'valoraciones.riesgo_id')
                    ->where('valoraciones.efectividad_id', 'LIKE', $efectividad);
            }

            $fechanotificacionstartdate = null;
            $fechanotificacionenddate = null;
            if($fechanotificacion = $request->get('fechanotificacion')){
                $range = explode(" a ", $fechanotificacion);
                $fechanotificacionstartdate = new Carbon($range[0]);
                $fechanotificacionenddate = new Carbon($range[1]);

                $query->whereBetween('riesgos.fechanotificacion', [$fechanotificacionstartdate, $fechanotificacionenddate]);
            }
    
            $fechacierrestartdate = null;
            $fechacierreenddate = null;
            if($fechacierre = $request->get('fechacierre')){
                $range2 = explode(" a ", $fechacierre);
                $fechacierrestartdate = new Carbon($range2[0]);
                $fechacierreenddate = new Carbon($range2[0]);

                $query->whereBetween('riesgos.fechacierre', [$fechacierrestartdate, $fechacierreenddate]);
            }

        //---------------Fin de Seccion de Filtros Avanzados----------------------------
                

        $data = $query->get();


        return dataTables()->of($data)
                ->editColumn('id','')
                ->addColumn('codigo', function(Riesgo $riesgo){
                    return '<a class="btn btn-link" href="'. route('riesgos.show', $riesgo->id) .'">'. $riesgo->codigo .'</a>';
                })
                ->addColumn('descripcion', function(Riesgo $riesgo){
                    return substr($riesgo->descripcion, 0, 80) . '...';
                })
                ->addColumn('valoracion_id', function(Riesgo $riesgo){
                    return ($riesgo->valoracion) ? $riesgo->valoracion->efectividad->nombre : '-';
                })
                ->addColumn('proceso_id', function(Riesgo $riesgo){
                    return $riesgo->proceso->nombre;
                })
                ->addColumn('fechanotificacion', function(Riesgo $riesgo){
                    return $riesgo->fechanotificacion;
                })
                ->addColumn('estado', function(Riesgo $riesgo){
                    if($riesgo->estado == 'Nuevo'){
                        $estado = '<span class="badge bg-primary">'. $riesgo->estado .'</span>';
                    }elseif($riesgo->estado == 'En Seguimiento'){
                        $estado = '<span class="badge bg-warning">'. $riesgo->estado .'</span>';
                    }elseif($riesgo->estado == 'Evaluado'){
                        $estado = '<span class="badge bg-info">'. $riesgo->estado .'</span>';
                    }else{
                        $estado = '<span class="badge bg-success">'. $riesgo->estado .'</span>';
                    }

                    return $estado;
                })
                ->rawColumns(['codigo', 'descripcion', 'valoracion_id', 'proceso_id', 'fechanotificacion', 'estado'])
                ->toJson();
        }

        $efectividades = Efectividad::all();
        $procesos = Proceso::all();

        return view('riesgo.index', compact('procesos', 'efectividades'));
    }

    public function create()
    {
        // ----- Security Policy---------
        $this->authorize('create', Riesgo::class);

        $riesgo = new Riesgo();

        $procesos = Proceso::all()->pluck('nombre', 'id');

        return view('riesgo.create', compact('riesgo', 'procesos'));
    }

    public function store(Request $request)
    {
        // ----- Security Policy---------
        $this->authorize('create', Riesgo::class);

        $request->request->add(['estado' => 'Nuevo']); //add request

        if(auth()->user()->proceso){
            $proceso_id = auth()->user()->proceso->id;
            $request->request->add(['proceso_id' => $proceso_id]); //add request
        }

        $validate = request()->validate([
            'codigo' => ['required', new Alphanum_spaces, 'unique:riesgos'],
            'descripcion' => 'required',
            'fechanotificacion' => ['required', 'date'],
            'proceso_id' => 'required',
            'estado' => 'required' 
        ]);

        $riesgo = Riesgo::create($validate);

        $users = User::with('roles')->whereHas("roles", function($q) {
            $q->where("name", 'ROLE_CALIDAD');
        })->get();
        if($users){
            Notification::send($users, new RiesgoAlert($riesgo));
        }

        return redirect()->route('riesgos.show', $riesgo->id)
            ->with('success', 'El elemento se ha insertado corréctamente.');
    }

    public function show($id)
    {
        $riesgo = Riesgo::find($id);
        // ----- Security Policy---------
        $this->authorize('show', $riesgo);

        return view('riesgo.show', compact('riesgo'));
    }

    public function edit($id)
    {
        $riesgo = Riesgo::find($id);
        // ----- Security Policy---------
        $this->authorize('update', $riesgo);

        $procesos = Proceso::all()->pluck('nombre', 'id');

        return view('riesgo.edit', compact('riesgo', 'procesos'));
    }

    public function update(Request $request, Riesgo $riesgo)
    {
        // ----- Security Policy---------
        $this->authorize('update', $riesgo);

        if(auth()->user()->proceso){
            $proceso_id = auth()->user()->proceso->id;
            $request->request->add(['proceso_id' => $proceso_id]); //add request
        }

        $validate = request()->validate([
            'codigo' => ['required', new Alphanum_spaces, 'unique:riesgos,codigo,'. $riesgo->id],
            'descripcion' => 'required',
            'fechanotificacion' => ['required', 'date'],
            'proceso_id' => 'required', 
        ]);

        $riesgo->update($validate);

        return redirect()->route('riesgos.show', $riesgo->id)
            ->with('success', 'El elemento se ha editado corréctamente.');
    }

    public function destroy($id)
    {

        $riesgo = Riesgo::find($id);
        // ----- Security Policy---------
        $this->authorize('delete', $riesgo);

        if(!$riesgo->analisis){
            $riesgo->delete();

            return redirect()->route('riesgos.index')
            ->with('success', 'El elemento se ha eliminado corréctamente.');
        }else{
            return redirect()->route('riesgos.show', $id)
            ->with('danger', 'No se pudo eliminar el elemento seleccionado, ya que puede estar siendo usado.'); 
        }
    }

    public function cerrar($id)
    {
        $riesgo = Riesgo::find($id);
        // ----- Security Policy---------
        $this->authorize('close', $riesgo);

        if ($riesgo->estado == 'Evaluado') {

            $riesgo->update(['fechacierre' => Carbon::now(), 'estado' => 'Cerrado']);

            if($riesgo->proceso->user){
                Notification::send($riesgo->proceso->user, new RiesgoAlert($riesgo));
            }
            return redirect()->route('riesgos.show', $riesgo->id)
                ->with('success', 'El elemento se ha cerrado corréctamente.');
        }else{
            $riesgo->update(['fechacierre' => null, 'estado' => 'Evaluado']);

            return redirect()->route('riesgos.show', $riesgo->id)
                ->with('success', 'El elemento se ha re abierto corréctamente.');
        } 

        

    }
    
}
