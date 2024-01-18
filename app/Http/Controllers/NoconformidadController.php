<?php

namespace App\Http\Controllers;

use App\Models\Noconformidad;
use Illuminate\Http\Request;
use App\Rules\Alphanum_spaces;

use App\Models\Fuente;
use App\Models\Clasificacion;
use App\Models\Proceso;
use App\Models\Requisito;

use App\Models\Analisis;

use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NoconformidadAlert;

class NoconformidadController extends Controller
{

    public function index(Request $request)
    {
        // ----- Security Policy---------
        $this->authorize('index', Noconformidad::class);

        if ($request->ajax()) {

            $user = $request->user();

            if( $user->proceso ){

                $query = Noconformidad::select('noconformidades.*')
                        ->join('procesos', 'procesos.id', '=', 'noconformidades.proceso_id')
                        ->join('users', 'procesos.id', '=', 'users.proceso_id')
                        ->where('users.id', $user->id)
                        ->orderBy('noconformidades.id', 'desc');
            }else{

                $query = Noconformidad::select('noconformidades.*')
                        ->orderBy('id', 'desc');

            }

            //---------------Inicio de Seccion de Filtros Avanzados----------------------------
                $proceso = ($request->get('proceso')) ? $request->get('proceso') : '%';
                $fuente = ($request->get('fuente')) ? $request->get('fuente') : '%';
                $clasificacion = ($request->get('clasificacion')) ? $request->get('clasificacion') : '%';
                $requisito = ($request->get('requisito')) ? $request->get('requisito') : '%';
                
                $fechanotificacionstartdate = null;
                $fechanotificacionenddate = null;
                if($fechanotificacion = $request->get('fechanotificacion')){
                    $range = explode(" a ", $fechanotificacion);
                    $fechanotificacionstartdate = new Carbon($range[0]);
                    $fechanotificacionenddate = new Carbon($range[1]);

                    $query->whereBetween('noconformidades.fechanotificacion', [$fechanotificacionstartdate, $fechanotificacionenddate]);
                }
        
                $fechacierrestartdate = null;
                $fechacierreenddate = null;
                if($fechacierre = $request->get('fechacierre')){
                    $range2 = explode(" a ", $fechacierre);
                    $fechacierrestartdate = new Carbon($range2[0]);
                    $fechacierreenddate = new Carbon($range2[1]);

                    $query->whereBetween('noconformidades.fechacierre', [$fechacierrestartdate, $fechacierreenddate]);
                }

                $query->where('noconformidades.proceso_id', 'LIKE', $proceso)
                ->where('noconformidades.fuente_id', 'LIKE', $fuente)
                ->where('noconformidades.clasificacion_id', 'LIKE', $clasificacion)
                ->where('noconformidades.requisito_id', 'LIKE', $requisito);

            //---------------Fin de Seccion de Filtros Avanzados----------------------------
        
            $data = $query->get();

            return dataTables()->of($data)
                ->editColumn('id','')
                ->addColumn('codigo', function(Noconformidad $noconformidad){
                    return '<a class="btn btn-link" href="'. route('noconformidades.show', $noconformidad->id) .'">'. $noconformidad->codigo .'</a>';
                })
                ->addColumn('descripcion', function(Noconformidad $noconformidad){
                    return substr($noconformidad->descripcion, 0, 80) . '...';
                })
                ->addColumn('fuente_id', function(Noconformidad $noconformidad){
                    return $noconformidad->fuente->nombre;
                })
                ->addColumn('clasificacion_id', function(Noconformidad $noconformidad){
                    return $noconformidad->clasificacion->nombre;
                })
                ->addColumn('proceso_id', function(Noconformidad $noconformidad){
                    return $noconformidad->proceso->nombre;
                })
                ->addColumn('requisito_id', function(Noconformidad $noconformidad){
                    return $noconformidad->requisito->nombre;
                })
                ->addColumn('fechanotificacion', function(Noconformidad $noconformidad){
                    return $noconformidad->fechanotificacion;
                })
                ->addColumn('estado', function(Noconformidad $noconformidad){

                    if($noconformidad->estado == 'Nuevo'){
                        $estado = '<span class="badge bg-primary">'. $noconformidad->estado .'</span>';
                    }elseif($noconformidad->estado == 'En Seguimiento'){
                        $estado = '<span class="badge bg-warning">'. $noconformidad->estado .'</span>';
                    }else{
                        $estado = '<span class="badge bg-success">'. $noconformidad->estado .'</span>';
                    }

                    return $estado;
                })
                ->rawColumns(['codigo', 'descripcion', 'fuente_id', 'clasificacion_id', 'proceso_id', 'requisito_id', 'fechanotificacion', 'estado'])

                ->toJson()->header('Content-Type', 'application/json');;
        }

        $fuentes = Fuente::all();
        $clasificaciones = Clasificacion::all();
        $procesos = Proceso::all();
        $requisitos = Requisito::all();


        return view('noconformidad.index', compact('fuentes', 'clasificaciones', 'procesos', 'requisitos'));
    }

    public function create()
    {
        // ----- Security Policy---------
        $this->authorize('create', Noconformidad::class);

        $noconformidad = new Noconformidad();

        $fuentes = Fuente::all()->pluck('nombre', 'id');
        $clasificaciones = Clasificacion::all()->pluck('nombre', 'id');
        $procesos = Proceso::all()->pluck('nombre', 'id');
        $requisitos = Requisito::all()->pluck('nombre', 'id');

        return view('noconformidad.create', compact('noconformidad', 'fuentes', 'clasificaciones', 'procesos', 'requisitos'));
    }

    public function store(Request $request)
    {
        // ----- Security Policy---------
        $this->authorize('create', Noconformidad::class);

        $request->request->add(['estado' => 'Nuevo']); //add request

        $validate = request()->validate([
            'codigo' => ['required', new Alphanum_spaces, 'unique:noconformidades'],
            'descripcion' => 'required',
            'fechanotificacion' => ['required'],
            'fuente_id' => 'required',
            'clasificacion_id' => 'required',
            'proceso_id' => 'required',
            'requisito_id' => 'required',
            'estado' => 'required' 
        ]);

        $noconformidad = Noconformidad::create($validate);

        if($noconformidad->proceso->user){
            Notification::send($noconformidad->proceso->user, new NoconformidadAlert($noconformidad));
        }

        return redirect()->route('noconformidades.show', $noconformidad->id)
            ->with('success', 'El elemento se ha insertado corréctamente.');
    }

    public function show($id)
    {
        $noconformidad = Noconformidad::find($id);
        // ----- Security Policy---------
        $this->authorize('show', $noconformidad);

        return view('noconformidad.show', compact('noconformidad'));
    }

    public function edit($id)
    {
        $noconformidad = Noconformidad::find($id);
        // ----- Security Policy---------
        $this->authorize('update', $noconformidad);

        $fuentes = Fuente::all()->pluck('nombre', 'id');
        $clasificaciones = Clasificacion::all()->pluck('nombre', 'id');
        $procesos = Proceso::all()->pluck('nombre', 'id');
        $requisitos = Requisito::all()->pluck('nombre', 'id');

        return view('noconformidad.edit', compact('noconformidad', 'fuentes', 'clasificaciones', 'procesos', 'requisitos'));
    }

    public function update(Request $request, Noconformidad $noconformidad)
    {
        // ----- Security Policy---------
        $this->authorize('update', $noconformidad);

        $validate = request()->validate([
            'codigo' => ['required', new Alphanum_spaces, 'unique:noconformidades,codigo,'. $noconformidad->id],
            'descripcion' => 'required',
            'fechanotificacion' => ['required', 'date'],
            'fuente_id' => 'required',
            'clasificacion_id' => 'required',
            'requisito_id' => 'required',
            'proceso_id' => 'required'
        ]);

        $noconformidad->update($validate);

        return redirect()->route('noconformidades.show', $noconformidad->id)
            ->with('success', 'El elemento se ha editado corréctamente.');
    }

    public function destroy($id)
    {
        $noconformidad = Noconformidad::find($id);
        // ----- Security Policy---------
        $this->authorize('delete', $noconformidad);        

        if(!$noconformidad->analisis){
            $noconformidad->delete();

            return redirect()->route('noconformidades.index')
            ->with('success', 'El elemento se ha eliminado corréctamente.');
        }else{
            return redirect()->route('noconformidades.show', $id)
            ->with('danger', 'No se pudo eliminar el elemento seleccionado, ya que puede estar siendo usado.'); 
        }

    }

    public function cerrar($id)
    {
        $noconformidad = Noconformidad::find($id);
        // ----- Security Policy---------
        $this->authorize('close', $noconformidad);

        if ($noconformidad->estado == 'En Seguimiento') {
            $noconformidad->update(['fechacierre' => Carbon::now(), 'estado' => 'Cerrado']);

            if($noconformidad->proceso->user){
                Notification::send($noconformidad->proceso->user, new NoconformidadAlert($noconformidad));
            }

            return redirect()->route('noconformidades.show', $noconformidad->id)
                ->with('success', 'El elemento se ha cerrado corréctamente.');
        }else{
            $noconformidad->update(['fechacierre' => null, 'estado' => 'En Seguimiento']);

            return redirect()->route('noconformidades.show', $noconformidad->id)
                ->with('success', 'El elemento se ha re abierto corréctamente.');
        } 

        

    }

}
