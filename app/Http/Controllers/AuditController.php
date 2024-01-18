<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Audit;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        // ----- Security Policy---------
        $this->authorize('index', Audit::class);

        if ($request->ajax()) {

            $data = Audit::orderBy('created_at', 'desc')->get();

            return dataTables()->of($data)
                ->editColumn('id','')
                ->addColumn('user', function(Audit $audit){
                    return ($audit->user) ? $audit->user->name : '-';
                })
                ->addColumn('event', function(Audit $audit){
                    if($audit->event == 'created'){
                        return '<span class="badge bg-success">'. $audit->event .'</span>';
                    }elseif($audit->event == 'updated'){
                        return '<span class="badge bg-warning">'. $audit->event .'</span>';
                    }elseif($audit->event == 'delete'){
                        return '<span class="badge bg-danger">'. $audit->event .'</span>';
                    }else{
                        return '<span class="badge bg-info">'. $audit->event .'</span>';
                    }
                })
                ->addColumn('created_at', function(Audit $audit){
                    return $audit->created_at->format('d-m-Y h:i a');
                })


                ->addColumn('details', function(Audit $audit){

                    $old ='';
                    if($audit->old_values){
                        foreach($audit->old_values as $attribute  => $value){

                            $val = ($value) ? $value : '-';

                            $old .= '<br><b>'.$attribute.':</b> '.$val.'';
                        }
                    }else{
                        $old = '<br>No hay datos para mostrar';
                    }

                    $new = '';
                    if($audit->new_values){
                        foreach($audit->new_values as $attribute  => $value){

                            $val = ($value) ? $value : '-';
                            $new .= '<br><b>'.$attribute.':</b> '.$val.'';
                        }

                    }else{
                        $new = '<br>No hay datos para mostrar';
                    }

                    $link = '<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#audit'. $audit->id .'">Detalles</button>';

                    $modal = '
                    
                    <div class="modal fade" id="audit'. $audit->id .'" tabindex="-1" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title">Detalles</h5>

                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                                <div class="modal-body">
                                <label class="text-primary"><b>Old Values</b></label>'.$old.'<br><br>
                                <label class="text-primary"><b>New Values</b></label>'.$new.'<br>
                                </div>


                            <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                        </div>
                    </div>

                    ';

                    return $link . $modal;

                })
                
                ->rawColumns(['user', 'event', 'created_at', 'details'])
                ->toJson();


        }

        return view('audits.index');
    }
}