<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Noconformidad;
use App\Models\Riesgo;
use App\Models\Oportunidad;
use App\Models\Accion;
use App\Models\Proceso;
use App\Models\Nivel;
use App\Models\Efectividad;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function home(Request $request)
    {


        $cant_noconformidades = count(Noconformidad::all());
        $cant_riesgos = count(Riesgo::all());
        $cant_oportunidades = count(Oportunidad::all());



        
        $start1 = Carbon::now()->startOfYear();
        $end1 = Carbon::now()->endOfYear();
        $year[] = Carbon::now()->year;

        $start2 = Carbon::now()->subYear()->startOfYear();
        $end2 = Carbon::now()->subYear()->endOfYear();
        $year[] = Carbon::now()->subYear()->year;

        $start3 = Carbon::now()->subYears(2)->startOfYear();
        $end3 = Carbon::now()->subYears(2)->endOfYear();
        $year[] = Carbon::now()->subYears(2)->year;

        $start4 = Carbon::now()->subYears(3)->startOfYear();
        $end4 = Carbon::now()->subYears(3)->endOfYear();
        $year[] = Carbon::now()->subYears(3)->year;

        $start5 = Carbon::now()->subYears(4)->startOfYear();
        $end5 = Carbon::now()->subYears(4)->endOfYear();
        $year[] = Carbon::now()->subYears(4)->year;

        //---------------------------------------------------------------------------------------------------

        $cant[] = count(Noconformidad::select('noconformidades.*')->whereBetween('noconformidades.fechanotificacion', [$start1, $end1])->get());
        $cant[] = count(Noconformidad::select('noconformidades.*')->whereBetween('noconformidades.fechanotificacion', [$start2, $end2])->get());
        $cant[] = count(Noconformidad::select('noconformidades.*')->whereBetween('noconformidades.fechanotificacion', [$start3, $end3])->get());
        $cant[] = count(Noconformidad::select('noconformidades.*')->whereBetween('noconformidades.fechanotificacion', [$start4, $end4])->get());
        $cant[] = count(Noconformidad::select('noconformidades.*')->whereBetween('noconformidades.fechanotificacion', [$start5, $end5])->get());
        
        //------------------------------------------------------------------------------------------------------

        $cantnoconf2[] = count(Noconformidad::where('noconformidades.estado', 'Nuevo')->get());
        $cantnoconf2[] = count(Noconformidad::where('noconformidades.estado', 'En Seguimiento')->get());
        $cantnoconf2[] = count(Noconformidad::where('noconformidades.estado', 'Cerrado')->get());

        //-----------------------------------------------------------------------------------------------------------

        $cantnoconf3[] = count(Accion::join('analisis', 'analisis.id', '=', 'acciones.accionable_id')->where('analisis.analisisable_type', '=', 'App\Models\Noconformidad')->where('acciones.estado', 'Nuevo')->get());
        $cantnoconf3[] = count(Accion::join('analisis', 'analisis.id', '=', 'acciones.accionable_id')->where('analisis.analisisable_type', '=', 'App\Models\Noconformidad')->where('acciones.estado', 'En Seguimiento')->get());
        $cantnoconf3[] = count(Accion::join('analisis', 'analisis.id', '=', 'acciones.accionable_id')->where('analisis.analisisable_type', '=', 'App\Models\Noconformidad')->where('acciones.estado', 'Cerrado')->get());


        //---------------------------------------------------------------------------------------------------------------

        $procesosall = Proceso::all();
        foreach($procesosall as $p){
            $procesos[] = $p->nombre;
            $cantnoconf4[] = count(Noconformidad::where('noconformidades.proceso_id', '=', $p->id)->whereBetween('noconformidades.fechanotificacion', [$start1, $end1])->get());
        }

        //--------------------------------------------------------------------------------------------------------------------
        foreach($procesosall as $p){
            $acc = Accion::join('analisis', 'analisis.id', '=', 'acciones.accionable_id')
                    ->join('noconformidades', 'noconformidades.id', '=', 'analisis.analisisable_id')
                    ->where('analisis.analisisable_type', '=', 'App\Models\Noconformidad')
                    ->where('noconformidades.proceso_id', '=', $p->id)
                    ->get();
            $total[] = count($acc);

            $c = 0;
            foreach($acc as $a){
                if($a->cumplimiento == 'Cumplido'){
                    $c++;
                }
            }
            $cumplidos[] = $c;     
        }

        //----------------------------------------------------------------------------------------------------------------------

        $nivelesall = Nivel::all();
        foreach($nivelesall as $n){
            $niveles[] = $n->nombre;
            $cantrisk1[] = count(Riesgo::join('analisis', 'analisis.analisisable_id', '=', 'riesgos.id')
                    ->where('analisis.analisisable_type', 'App\Models\Riesgo')
                    ->where('analisis.nivel_id', $n->id)->get());
        }

        //----------------------------------------------------------------------------------------------------------------

        for ($i=1; $i <= 5 ; $i++) { 

            $accionesall = Accion::join('analisis', 'analisis.id', '=', 'acciones.accionable_id')
            ->join('riesgos', 'riesgos.id', '=', 'analisis.analisisable_id')
            ->where('analisis.analisisable_type', 'App\Models\Riesgo')
            ->where('acciones.estado', 'Cerrado')
            ->whereBetween('riesgos.fechanotificacion', [${"start" . $i} , ${"end" . $i}])->get();

            $t = 0;
            if(!$accionesall->isEmpty()){
                $t = count($accionesall);
                $cantcumplido = 0;
                foreach($accionesall as $a){
                    if($a->cumplimiento == 'Cumplido'){
                        $cantcumplido++;
                    }
                }
    
                $porcientocumplido[] = round(($cantcumplido*100)/$t);
                $porcientonocumplido[] = round(100 - ($cantcumplido*100)/$t);
            }else{
                $porcientocumplido[] = 0;
                $porcientonocumplido[] = 0;
            }

        }
        //----------------------------------------------------------------------------------------------------------------

        $efectividadesall = Efectividad::all();
        $porcientoxefectividades = [];

        foreach($efectividadesall as $e){

            $c = 0;
            $porciento = [];

            $efectividades[] = $e->nombre;

            for ($i=1; $i <= 5 ; $i++) { 

                $c = count($riesgosall = Riesgo::join('valoraciones', 'riesgos.id', '=', 'valoraciones.riesgo_id')
                                                    ->where('valoraciones.efectividad_id', $e->id)
                                                    ->whereBetween('riesgos.fechanotificacion', [${"start" . $i} , ${"end" . $i}])->get()
                            );
                
                $porciento[] = round(($c*100)/$cant_riesgos);  

            }
            
        
            $porcientoxefectividades[] = $porciento;

        }

        //-----------------------------------------------------------------------------------------------------------------


        foreach($procesosall as $p){
            $cantidad = [];
            foreach($efectividadesall as $e){
                for ($i=1; $i <= 5 ; $i++) { 
                    $c = count($riesgosall = Riesgo::join('valoraciones', 'riesgos.id', '=', 'valoraciones.riesgo_id')
                                                    ->where('riesgos.proceso_id', $p->id)
                                                    ->where('valoraciones.efectividad_id', $e->id)
                                                    ->whereBetween('riesgos.fechanotificacion', [${"start" . $i} , ${"end" . $i}])->get()
                            );

                    $cantidad[] = $c;
                }
            }
            $cantriesgosxefectividadxannoxproceso[] = $cantidad;
        }

        //------------------------------------------------------------------------------------------------------------------

        $cantoportunidadesxanno = [];
        for ($i=1; $i <= 5 ; $i++) { 

            $cantoportunidadesxanno[] = count(Oportunidad::whereBetween('oportunidades.fechanotificacion', [${"start" . $i} , ${"end" . $i}])->get());

        }

        //-----------------------------------------------------------------------------------------------------------------

        return view('home', compact('cant_noconformidades', 'cant_riesgos', 'cant_oportunidades', 
                                    'year', 'cant', 
                                    'cantnoconf2', 
                                    'cantnoconf3', 
                                    'procesos', 'cantnoconf4', 
                                    'total', 'cumplidos',
                                    'niveles', 'cantrisk1',
                                    'porcientocumplido', 'porcientonocumplido',
                                    'efectividades', 'porcientoxefectividades',
                                    'cantriesgosxefectividadxannoxproceso',
                                    'cantoportunidadesxanno'
                                
                                ));
    }
}
