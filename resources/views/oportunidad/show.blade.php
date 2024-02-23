@extends('layouts.app')

@section('content')

    <div class="pagetitle">
        <h1>Oportunidades</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">Oportunidades</li>
                <li class="breadcrumb-item active">Detalles</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">

            {{-- Inicio de la seccion de detalles de Oportunidades --}}
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h5 class="card-title text-primary">{{ __('Oportunidad') }}</h5>
                            <div class="float-right">

                                @can('update', $oportunidad)
                                    @if ($oportunidad->estado != 'Cerrado')
                                        <form action="{{ route('oportunidades.destroy', $oportunidad->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('oportunidades.edit', $oportunidad->id) }}"
                                                class="edit btn btn-success btn-sm"><i class="bi bi-pencil"></i> Editar</a>
                                            <a href="javascript:void(0)" class="delete_oportunidad btn btn-danger btn-sm"><i
                                                    class="bi bi-trash"></i> Eliminar</a>
                                        </form>
                                    @endif
                                @endcan

                                @can('close', $oportunidad)
                                    <form action="{{ route('oportunidad.cerrar', $oportunidad->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf

                                        @if ($puedeCerrar == true)
                                            <a href="javascript:void(0)" class="cerrar_oportunidad btn btn-primary btn-sm">
                                                <i class="bi bi-bookmark-check"></i> Cerrar
                                            </a>
                                        @elseif($oportunidad->estado == 'Cerrado')
                                            <a href="javascript:void(0)" class="reabrir_oportunidad btn btn-warning btn-sm"><i
                                                    class="bi bi-arrow-clockwise"></i> Re Abrir</a>
                                        @endif
                                    </form>
                                @endcan

                            </div>
                        </div>

                        <div class="row g-3 mb-3">

                            <div class="col-md-4">
                                <label class="form-label">Código</label>
                                <input type="text" class="form-control" disabled value="{{ $oportunidad->codigo }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Tipo</label>
                                <input type="text" class="form-control" disabled value="{{ $oportunidad->tipo }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Fecha de Notificación</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $oportunidad->fechanotificacion }}">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Proceso</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $oportunidad->proceso->nombre }}">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Descripción</label>
                                <textarea class="form-control" disabled rows="4"> {{ $oportunidad->descripcion }}</textarea>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Estado</label>
                                <div class="col-8">
                                    @if ($oportunidad->estado == 'Nuevo')
                                        <span class="badge bg-primary">{{ $oportunidad->estado }}</span>
                                    @elseif($oportunidad->estado == 'En Seguimiento')
                                        <span class="badge bg-warning">{{ $oportunidad->estado }}</span>
                                    @else
                                        <span class="badge bg-success">{{ $oportunidad->estado }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Fecha de Cierre</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $oportunidad->fechacierre ? $oportunidad->fechacierre : '-' }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Aprovechamiento</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $oportunidad->aprovechamiento ? $oportunidad->aprovechamiento : '-' }}">
                            </div>

                        </div>

                    </div>

                </div>
            </div>
            {{-- Fin de la seccion de detalles de Oportunidades --}}

            {{-- Inicio de la seccion de detalles de Acciones --}}
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body">

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h5 class="card-title text-primary">{{ __('Acciones') }}</h5>

                            <div class="float-right">

                                @can('create', [App\Models\Accion::class, $oportunidad])
                                    @if ($oportunidad->estado != 'Cerrado')
                                        <a href="{{ route('acciones.create', ['accionable_id' => $oportunidad->id, 'accionable_type' => 'App\Models\Oportunidad']) }}"
                                            class="btn btn-primary btn-sm float-right" data-placement="left">
                                            <i class="bi bi-plus-lg"></i> {{ __('Insertar') }}
                                        </a>
                                    @endif
                                @endcanany

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

                                    @if (!$oportunidad->acciones->isEmpty())
                                        @foreach ($oportunidad->acciones as $accion)
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

            select_menu('oportunidades')


            @include('layouts.message')

            $(".delete_oportunidad").on("click", function() {
                var form = $(this).closest("form");
                createDelete(form)
            });

            $(".cerrar_oportunidad").on("click", function() {
                var form = $(this).closest("form");
                createCerrar(form)
            });

            $(".reabrir_oportunidad").on("click", function() {
                var form = $(this).closest("form");
                createReabrir(form)
            });



        });
    </script>

@endsection
