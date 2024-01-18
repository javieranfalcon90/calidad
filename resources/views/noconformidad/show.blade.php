@extends('layouts.app')

@section('content')

    <div class="pagetitle">
        <h1>No Conformidades</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">No Conformidades</li>
                <li class="breadcrumb-item active">Detalles</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">

            {{-- Inicio de la seccion de detalles de No Conformidad --}}
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body">

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h5 class="card-title text-primary">{{ __('No Conformidad') }}</h5>
                            <div class="float-right">

                                <form action="{{ route('noconformidades.destroy', $noconformidad->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    @can('update', $noconformidad)
                                        <a href="{{ route('noconformidades.edit', $noconformidad->id) }}"
                                            class="edit btn btn-success btn-sm"><i class="bi bi-pencil"></i> Editar</a>
                                    @endcan

                                    @can('delete', $noconformidad)
                                        <a href="javascript:void(0)" class="delete_noconformidad btn btn-danger btn-sm"><i
                                                class="bi bi-trash"></i> Eliminar</a>
                                    @endcan
                                </form>


                                @can('close', $noconformidad)
                                    <form action="{{ route('noconformidades.cerrar', $noconformidad->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf

                                        @if ($noconformidad->estado == 'En Seguimiento')
                                            <a href="javascript:void(0)" class="cerrar_noconformidad btn btn-primary btn-sm">
                                                <i class="bi bi-bookmark-check"></i> Cerrar
                                            </a>
                                        @elseif($noconformidad->estado == 'Cerrado')
                                            <a href="javascript:void(0)" class="reabrir_noconformidad btn btn-warning btn-sm"><i
                                                    class="bi bi-arrow-clockwise"></i> Re Abrir</a>
                                        @endif

                                    </form>
                                @endcan

                            </div>
                        </div>

                        <div class="row g-3 mb-3">

                            <div class="col-md-6">
                                <label class="form-label">Código</label>
                                <input type="text" class="form-control" disabled value="{{ $noconformidad->codigo }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Fecha de Notificación</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $noconformidad->fechanotificacion }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Fuente</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $noconformidad->fuente->nombre }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Requisito</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $noconformidad->requisito->nombre }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Clasificación</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $noconformidad->clasificacion->nombre }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Proceso</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $noconformidad->proceso->nombre }}">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Descripción</label>
                                <textarea class="form-control" disabled rows="4"> {{ $noconformidad->descripcion }} </textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Estado</label>
                                <div class="col-12">
                                    @if ($noconformidad->estado == 'Nuevo')
                                        <span class="badge bg-primary">{{ $noconformidad->estado }}</span>
                                    @elseif($noconformidad->estado == 'En Seguimiento')
                                        <span class="badge bg-warning">{{ $noconformidad->estado }}</span>
                                    @else
                                        <span class="badge bg-success">{{ $noconformidad->estado }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Fecha de Cierre</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $noconformidad->fechacierre ? $noconformidad->fechacierre : '-' }}">
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            {{-- Fin de la seccion de detalles de No Conformidad --}}

            {{-- Inicio de la seccion de detalles de Analisis --}}
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body">

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h5 class="card-title text-primary">{{ __('Análisis') }}</h5>

                            <div class="float-right">

                                @can('create', [App\Models\Analisis::class, $noconformidad])
                                    <a href="{{ route('analisis.create', ['analisisable_id' => $noconformidad->id, 'analisisable_type' => 'App\Models\Noconformidad']) }}"
                                        class="btn btn-primary btn-sm float-right" data-placement="left">
                                        <i class="bi bi-plus-lg"></i> {{ __('Insertar') }}
                                    </a>
                                @endcan

                                @if ($noconformidad->analisis)
                                    <form action="{{ route('analisis.destroy', $noconformidad->analisis->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        @can('update', [App\Models\Analisis::class, $noconformidad->analisis])
                                            <a href="{{ route('analisis.edit', $noconformidad->analisis->id) }}"
                                                class="edit btn btn-success btn-sm"><i class="bi bi-pencil"></i> Editar</a>
                                        @endcan
                                        @can('delete', [App\Models\Analisis::class, $noconformidad->analisis])
                                            <a href="javascript:void(0)" class="delete_analisis btn btn-danger btn-sm"><i
                                                    class="bi bi-trash"></i> Eliminar</a>
                                        @endcan
                                    </form>
                                @endif

                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            @if ($noconformidad->analisis)
                                <div class="col-md-12">
                                    <label class="form-label">Causa</label>
                                    <textarea class="form-control" disabled rows="4"> {{ $noconformidad->analisis->causa }} </textarea>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Fecha</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $noconformidad->analisis->fecha }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Participantes</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $noconformidad->analisis->participantes }}">
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
            {{-- Fin de la seccion de detalles de Analisis --}}

            {{-- Inicio de la seccion de detalles de Acciones --}}
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body">

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h5 class="card-title text-primary">{{ __('Acciones') }}</h5>

                            <div class="float-right">

                                @if ($noconformidad->analisis)
                                    @can('create', [App\Models\Accion::class, $noconformidad->analisis])
                                        <a href="{{ route('acciones.create', ['accionable_id' => $noconformidad->analisis->id, 'accionable_type' => 'App\Models\Analisis']) }}"
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
                                        <th>Tipo</th>
                                        <th>Responsable</th>
                                        <th>Fecha de Cumplimiento</th>
                                        <th>Cumplimiento</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if ($noconformidad->analisis and !$noconformidad->analisis->acciones->isEmpty())
                                        @foreach ($noconformidad->analisis->acciones as $accion)
                                            <tr>
                                                <td>{{ $accion->accion }}</td>
                                                <td>{{ $accion->tipo->nombre }}</td>
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
                                            <td colspan="7" class="text-center"> No hay acciones para mostrar </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                        </div>

                    </div>

                </div>
            </div>
            {{-- Fin de la seccion de detalles de Acciones --}}

        </div>
    </section>

    <script type="text/javascript">
        $(function() {

            select_menu('noconformidades')

            @include('layouts.message')

            $(".delete_noconformidad").on("click", function() {
                var form = $(this).closest("form");
                createDelete(form)
            });

            $(".delete_analisis").on("click", function() {
                var form = $(this).closest("form");
                createDelete(form)
            });

            $(".cerrar_noconformidad").on("click", function() {
                var form = $(this).closest("form");
                createCerrar(form)
            });

            $(".reabrir_noconformidad").on("click", function() {
                var form = $(this).closest("form");
                createReabrir(form)
            });

        });
    </script>

@endsection
