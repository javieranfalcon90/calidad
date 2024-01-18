@extends('layouts.app')

@section('content')

    <div class="pagetitle">
        <h1>Acciones</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">Acciones</li>
                <li class="breadcrumb-item active">Detalles</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">

            {{-- Inicio de la seccion de detalles de Acciones --}}
            <div class="col-lg-7 col-md-6">
                <div class="card">

                    <div class="card-body">

                        {{-- ------ INICIO ACCIONABLE ------- --}}
                        @if ($accion->accionable_type == 'App\Models\Oportunidad')
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <h5 class="card-title text-primary">{{ __('Oportunidad') }}</h5>
                                <div class="float-right">
                                    <a href="{{ route('oportunidades.show', $accion->accionable_id) }}"
                                        class="btn btn-sm btn-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
                                </div>
                            </div>

                            <div class="row g-3 mb-3">

                                <div class="col-md-6">
                                    <label class="form-label">Código</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $accion->accionable->codigo }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Fecha de Notificacion</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $accion->accionable->fechanotificacion }}">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Descripción</label>
                                    <textarea class="form-control" disabled rows="4"> {{ $accion->accionable->descripcion }}</textarea>
                                </div>

                            </div>
                        @elseif($accion->accionable->analisisable_type == 'App\Models\Riesgo')
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <h5 class="card-title text-primary">{{ __('Riesgo') }}</h5>
                                <div class="float-right">
                                    <a href="{{ route('riesgos.show', $accion->accionable->analisisable_id) }}"
                                        class="btn btn-sm btn-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
                                </div>
                            </div>

                            <div class="row g-3 mb-3">

                                <div class="col-md-6">
                                    <label class="form-label">Código</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $accion->accionable->analisisable->codigo }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Fecha de Notificacion</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $accion->accionable->analisisable->fechanotificacion }}">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Descripción</label>
                                    <textarea class="form-control" disabled rows="4"> {{ $accion->accionable->analisisable->descripcion }}</textarea>
                                </div>

                            </div>
                        @else
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <h5 class="card-title text-primary">{{ __('No Conformidad') }}</h5>
                                <div class="float-right">
                                    <a href="{{ route('noconformidades.show', $accion->accionable->analisisable_id) }}"
                                        class="btn btn-sm btn-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
                                </div>
                            </div>

                            <div class="row g-3 mb-3">

                                <div class="col-md-6">
                                    <label class="form-label">Código</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $accion->accionable->analisisable->codigo }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Fecha de Notificacion</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $accion->accionable->analisisable->fechanotificacion }}">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Descripción</label>
                                    <textarea class="form-control" disabled rows="4"> {{ $accion->accionable->analisisable->descripcion }}</textarea>
                                </div>

                            </div>
                        @endif
                        {{-- ------ FIN ACCIONABLE ------- --}}

                    </div>

                </div>

                {{-- ---- INICIO ACCION ------ --}}
                <div class="card">
                    <div class="card-body">

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h5 class="card-title text-primary">{{ __('Acción') }}</h5>
                            <div class="float-right">

                                <form action="{{ route('acciones.destroy', $accion->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    @can('update', $accion)
                                        <a href="{{ route('acciones.edit', $accion->id) }}"
                                            class="edit btn btn-success btn-sm"><i class="bi bi-pencil"></i> Editar</a>
                                    @endcan
                                    @can('delete', $accion)
                                        <a href="javascript:void(0)" class="delete_accion btn btn-danger btn-sm"><i
                                                class="bi bi-trash"></i> Eliminar</a>
                                    @endcan
                                </form>

                                @can('close', $accion)
                                    <form action="{{ route('acciones.cerrar', $accion->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="cumplimiento" class="cumplimiento" value="">
                                        @if ($accion->estado == 'En Seguimiento')
                                            <a href="javascript:void(0)" class="cerrar_accion btn btn-primary btn-sm">
                                                <i class="bi bi-bookmark-check"></i> Cerrar
                                            </a>
                                        @elseif($accion->estado == 'Cerrado')
                                            @if (
                                                $accion->accionable_type == 'App\Models\Oportunidad' and $accion->accionable->estado != 'Cerrado' or
                                                    $accion->accionable->analisisable->estado != 'Cerrado')
                                                <a href="javascript:void(0)" class="reabrir_accion btn btn-warning btn-sm"><i
                                                        class="bi bi-arrow-clockwise"></i> Re Abrir</a>
                                            @endif
                                        @endif
                                    </form>
                                @endcan

                            </div>
                        </div>

                        <div class="row g-3 mb-3">

                            <div class="col-md-12">
                                <label class="form-label">Acción</label>
                                <textarea class="form-control" disabled rows="4"> {{ $accion->accion }}</textarea>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Tipo de Acción</label>
                                <input type="text" class="form-control" disabled value="{{ $accion->tipo->nombre }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Responsable</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $accion->responsable->nombre }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Fecha de Cumplimiento</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $accion->fechacumplimiento }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Estado</label>
                                <div class="col-8">
                                    @if ($accion->estado == 'Nuevo')
                                        <span class="badge bg-primary">{{ $accion->estado }}</span>
                                    @elseif($accion->estado == 'En Seguimiento')
                                        <span class="badge bg-warning">{{ $accion->estado }}</span>
                                    @else
                                        <span class="badge bg-success">{{ $accion->estado }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Fecha de Cierre</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $accion->fechacierre ? $accion->fechacierre : '-' }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Cumplimiento</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $accion->cumplimiento ? $accion->cumplimiento : '-' }}">
                            </div>

                        </div>

                    </div>

                </div>
                {{-- ---- FIN ACCION ------ --}}

            </div>
            {{-- Fin de la seccion de detalles de Acciones --}}

            {{-- Inicio de la seccion de detalles de Seguimientos --}}
            <div class="col-lg-5 col-md-6">
                <div class="card">

                    <div class="card-body">

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h5 class="card-title text-primary">{{ __('Seguimientos') }}</h5>

                            <div class="float-right">

                                @can('create', [App\Models\Seguimiento::class, $accion])
                                    <a href="{{ route('seguimientos.create', ['accion_id' => $accion->id]) }}"
                                        class="btn btn-primary btn-sm float-right" data-placement="left">
                                        <i class="bi bi-plus-lg"></i> {{ __('Insertar') }}
                                    </a>
                                @endcan

                            </div>
                        </div>

                        <div class="table-responsive p-2">

                            <div class="activity">

                                @if (!$accion->seguimientos->isEmpty())
                                    @foreach ($accion->seguimientos->sortByDesc('id') as $seguimiento)
                                        <div class="activity-item d-flex">
                                            <div class="activite-label">{{ $seguimiento->fecha }}</div>
                                            <i class="bi bi-circle-fill activity-badge text-primary align-self-start"></i>

                                            <div class="activity-content comments-style w-100">

                                                <div class="row m-0">


                                                    <div class="col-9 ">
                                                        <h5>{{ $seguimiento->user->name }}</h5>
                                                    </div>
                                                    <div class="col-3 text-end">

                                                        <form
                                                            action="{{ route('seguimientos.destroy', $seguimiento->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')

                                                            @can('update', $seguimiento)
                                                                <a class="text-primary"
                                                                    href="{{ route('seguimientos.edit', $seguimiento->id) }}"><i
                                                                        class="bi bi-pencil fs-6"></i></a>
                                                            @endcan

                                                            @can('delete', $seguimiento)
                                                                <a href="javascript:void(0)"
                                                                    class="delete_seguimiento text-danger"><i
                                                                        class="bi bi-trash fs-6"></i> </a>
                                                            @endcan
                                                        </form>

                                                    </div>

                                                    <div class="col-12">
                                                        <div style="white-space: pre-wrap;">
                                                            {{ $seguimiento->seguimiento }}</div>

                                                        @if ($seguimiento->evidencia)
                                                            <b>Evidencia: </b>
                                                            <a target="_blank"
                                                                href="{{ asset('storage/evidencias/' . $seguimiento->evidencia) }}"><i
                                                                    class="bi bi-paperclip fs-6 text-info"></i>
                                                                Descargar</a>
                                                        @endif

                                                    </div>

                                                </div>

                                            </div>

                                        </div><!-- End activity item-->
                                    @endforeach
                                @else
                                    <div class="text-center">
                                        No hay datos para mostrar
                                    </div>
                                @endif

                            </div>


                        </div>

                    </div>

                </div>
            </div>
            {{-- Fin de la seccion de detalles de Seguimientos --}}

        </div>
    </section>

    <script type="text/javascript">
        $(function() {

            if ('{{ $accion->accionable_type }}' == 'App\Models\Oportunidad') {
                select_menu('oportunidades')
            } else if ('{{ $accion->accionable->analisisable_type }}' == 'App\Models\Riesgo') {
                select_menu('riesgos')
            } else {
                select_menu('noconformidades')
            }

            @include('layouts.message')

            $(".delete_accion").on("click", function() {
                var form = $(this).closest("form");
                createDelete(form)
            });

            $(".delete_seguimiento").on("click", function() {
                var form = $(this).closest("form");
                createDelete(form)
            });

            $(".cerrar_accion").on("click", function() {
                var form = $(this).closest("form");
                if ('{{ $accion->accionable->analisisable_type }}' == 'App\Models\Noconformidad') {
                    createCerrar(form)
                } else {
                    createCerrarParameter(form)
                }
            });

            $(".reabrir_accion").on("click", function() {
                var form = $(this).closest("form");
                createReabrir(form)
            });

        });
    </script>

@endsection
