@extends('layouts.app')

@section('content')

    <div class="pagetitle">
        <h1>Riesgos</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">Riesgos</li>
                <li class="breadcrumb-item active">Detalles</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">

            {{-- Inicio de la seccion de detalles de RIESGO --}}
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body">

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h5 class="card-title text-primary">{{ __('Riesgo') }}</h5>
                            <div class="float-right">

                                <form action="{{ route('riesgos.destroy', $riesgo->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    @can('update', $riesgo)
                                        <a href="{{ route('riesgos.edit', $riesgo->id) }}"
                                            class="edit btn btn-success btn-sm"><i class="bi bi-pencil"></i> Editar</a>
                                    @endcan

                                    @can('delete', $riesgo)
                                        <a href="javascript:void(0)" class="delete_riesgo btn btn-danger btn-sm"><i
                                                class="bi bi-trash"></i> Eliminar</a>
                                    @endcan
                                </form>

                                @can('close', $riesgo)
                                    <form action="{{ route('riesgos.cerrar', $riesgo->id) }}" method="POST">
                                        @csrf
                                        @if ($riesgo->estado == 'Evaluado')
                                            <a href="javascript:void(0)" class="cerrar_riesgo btn btn-primary btn-sm">
                                                <i class="bi bi-bookmark-check"></i> Cerrar
                                            </a>
                                        @elseif($riesgo->estado == 'Cerrado')
                                            <a href="javascript:void(0)" class="reabrir_riesgo btn btn-warning btn-sm"><i
                                                    class="bi bi-arrow-clockwise"></i> Re Abrir</a>
                                        @endif
                                    </form>
                                @endcan

                            </div>
                        </div>

                        <div class="row g-3 mb-3">

                            <div class="col-md-4">
                                <label class="form-label">Código</label>
                                <input type="text" class="form-control" disabled value="{{ $riesgo->codigo }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Fecha de Notificación</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $riesgo->fechanotificacion }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Proceso</label>
                                <input type="text" class="form-control" disabled value="{{ $riesgo->proceso->nombre }}">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Descripción</label>
                                <textarea class="form-control" disabled rows="4"> {{ $riesgo->descripcion }} </textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Estado</label>
                                <div class="col-12">

                                    @if ($riesgo->estado == 'Nuevo')
                                        <span class="badge bg-primary">{{ $riesgo->estado }}</span>
                                    @elseif($riesgo->estado == 'En Seguimiento')
                                        <span class="badge bg-warning">{{ $riesgo->estado }}</span>
                                    @elseif($riesgo->estado == 'Evaluado')
                                        <span class="badge bg-info">{{ $riesgo->estado }}</span>
                                    @else
                                        <span class="badge bg-success">{{ $riesgo->estado }}</span>
                                    @endif

                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Fecha de Cierre</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $riesgo->fechacierre ? $riesgo->fechacierre : '-' }}">
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            {{-- Fin de la seccion de detalles de RIESGO --}}

            {{-- Inicio de la seccion de detalles de ANALISIS --}}
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body">

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h5 class="card-title text-primary">{{ __('Análisis') }}</h5>

                            <div class="float-right">


                                @can('create', [App\Models\Analisis::class, $riesgo])
                                    <a href="{{ route('analisis.create', ['analisisable_id' => $riesgo->id, 'analisisable_type' => 'App\Models\Riesgo']) }}"
                                        class="btn btn-primary btn-sm float-right" data-placement="left">
                                        <i class="bi bi-plus-lg"></i> {{ __('Insertar') }}
                                    </a>
                                @endcan

                                @if ($riesgo->analisis)
                                    <form action="{{ route('analisis.destroy', $riesgo->analisis->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        @can('update', [App\Models\Analisis::class, $riesgo->analisis])
                                            <a href="{{ route('analisis.edit', $riesgo->analisis->id) }}"
                                                class="edit btn btn-success btn-sm"><i class="bi bi-pencil"></i> Editar</a>
                                        @endcan
                                        @can('delete', [App\Models\Analisis::class, $riesgo->analisis])
                                            <a href="javascript:void(0)" class="delete_analisis btn btn-danger btn-sm"><i
                                                    class="bi bi-trash"></i> Eliminar</a>
                                        @endcan
                                    </form>
                                @endif

                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            @if ($riesgo->analisis)
                                <div class="col-md-12">
                                    <label class="form-label">Causa</label>
                                    <textarea class="form-control" disabled rows="4"> {{ $riesgo->analisis->causa }} </textarea>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Fecha</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $riesgo->analisis->fecha }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Participantes</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $riesgo->analisis->participantes }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Manifestaciones Negativas</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $riesgo->analisis->manifestacionesnegativas }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Nivel</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $riesgo->analisis->nivel->nombre }}">
                                </div>
                            @else
                                <div class="text-center">
                                    No hay datos para mostrar
                                </div>
                            @endif
                        </div>

                    </div>
                </div>

            </div>
            {{-- Fin de la seccion de detalles de ANALISIS --}}

            {{-- Inicio de la seccion de detalles de ACCIONES --}}
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body">

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h5 class="card-title text-primary">{{ __('Acciones') }}</h5>

                            <div class="float-right">

                                @if ($riesgo->analisis)
                                    @can('create', [App\Models\Accion::class, $riesgo->analisis])
                                        <a href="{{ route('acciones.create', ['accionable_id' => $riesgo->analisis->id, 'accionable_type' => 'App\Models\Analisis']) }}"
                                            class="btn btn-primary btn-sm float-right" data-placement="left">
                                            <i class="bi bi-plus-lg"></i> {{ __('Insertar') }}
                                        </a>
                                    @endcan
                                @endif


                            </div>
                        </div>

                        <div class="table-responsive p-2">

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 40%;">Accion</th>
                                        <th>Responsable</th>
                                        <th>Fecha de Cumplimiento</th>
                                        <th>Cumplimiento</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if ($riesgo->analisis and !$riesgo->analisis->acciones->isEmpty())
                                        @foreach ($riesgo->analisis->acciones as $accion)
                                            <tr>
                                                <td>{{ $accion->accion }}</td>
                                                <td>{{ $accion->responsable->nombre }}</td>
                                                <td>{{ $accion->fechacumplimiento }}</td>
                                                <td>{{ $accion->cumplimiento ? $accion->cumplimiento : '-' }}
                                                <td>
                                                    @if ($accion->estado == 'Nuevo')
                                                        <span class="badge bg-primary">{{ $accion->estado }}</span>
                                                    @elseif($accion->estado == 'En Seguimiento')
                                                        <span class="badge bg-warning">{{ $accion->estado }}</span>
                                                    @else
                                                        <span class="badge bg-success">{{ $accion->estado }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('acciones.show', $accion->id) }}"
                                                        class="btn btn-sm btn-link">Detalles</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center"> No hay acciones para mostrar </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                        </div>

                    </div>

                </div>
            </div>
            {{-- Fin de la seccion de detalles de ACCIONES --}}

            {{-- Inicio de la seccion de detalles de VALORACIONES --}}
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body">

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h5 class="card-title text-primary">{{ __('Valoración') }}</h5>

                            <div class="float-right">

                            
                                @if ($riesgo->valoracion)
                                    <form action="{{ route('valoraciones.destroy', $riesgo->valoracion->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        @can('update', $riesgo->valoracion)
                                            <a href="{{ route('valoraciones.edit', $riesgo->valoracion->id) }}"
                                                class="edit btn btn-success btn-sm"><i class="bi bi-pencil"></i> Editar</a>
                                        @endcan
                                        @can('delete', $riesgo->valoracion)
                                            <a href="javascript:void(0)" class="delete_valoracion btn btn-danger btn-sm"><i
                                                    class="bi bi-trash"></i> Eliminar</a>
                                        @endcan
                                    </form>
                                @else
                                    @can('create', [App\Models\Valoracion::class, $riesgo])
                                    <a href="{{ route('valoraciones.create', ['riesgo_id' => $riesgo->id]) }}"
                                        class="btn btn-primary btn-sm float-right" data-placement="left">
                                        <i class="bi bi-plus-lg"></i> {{ __('Insertar') }}
                                    </a>
                                    @endcan
                                @endif

                            </div>

                        </div>

                        <div class="row g-3 mb-3">

                            @if ($riesgo->valoracion)
                                <div class="col-md-12">
                                    <label class="form-label">Descripción</label>
                                    <textarea class="form-control" disabled rows="4"> {{ $riesgo->valoracion->descripcion }} </textarea>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Fecha</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $riesgo->valoracion->fecha }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Efectividad</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $riesgo->valoracion->efectividad->nombre }}">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Conclusión</label>
                                    <textarea class="form-control" disabled rows="4"> {{ $riesgo->valoracion->conclusion ? $riesgo->valoracion->conclusion : '-'  }} </textarea>
                                </div>
                            @else
                                <div class="text-center">
                                    No hay datos para mostrar
                                </div>
                            @endif
                        </div>

                    </div>

                </div>
            </div>
            {{-- Fin de la seccion de detalles de VALORACION --}}


        </div>
    </section>

    <script type="text/javascript">
        $(function() {

            select_menu('riesgos')

            @include('layouts.message')

            $(".delete_riesgo").on("click", function() {
                var form = $(this).closest("form");
                createDelete(form)
            });

            $(".delete_analisis").on("click", function() {
                var form = $(this).closest("form");
                createDelete(form)
            });

            $(".delete_valoracion").on("click", function() {
                var form = $(this).closest("form");
                createDelete(form)
            });

            $(".cerrar_riesgo").on("click", function() {
                var form = $(this).closest("form");
                createCerrar(form)
            });

            $(".reabrir_riesgo").on("click", function() {
                var form = $(this).closest("form");
                createReabrir(form)
            });


        });
    </script>

@endsection
