@extends('layouts.app')

@section('content')

    <div class="pagetitle">
    <h1>No Conformidades</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item">No Conformidades</li>
            <li class="breadcrumb-item active">Listado</li>
            </ol>
        </nav>

    </div>

    <section class="section">
        <div class="row">

            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body">

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h5 class="card-title text-primary">{{ __('Listado') }}</h5>

                            <div class="float-right">

                                {{-- Inicio de la seccion de detalles de Filtros --}}
                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#filter">
                                        <i class="bi bi-search"></i>
                                    </button>

                                    <div class="modal fade" id="filter" role="dialog" aria-labelledby="filter" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Filtros</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                                                    <p>Seleccione las opciones para realizar filtros avanzados.</p><br>

                                                    <form id="filter-form" autocomplete="off">

                                                    <div class=" g-3">

                                                        <div class="row mb-3">
                                                            <label class="col-sm-3 col-form-label">Fecha de Notificación</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" id="fechanotificacion" name="fechanotificacion" class="form-control daterange" aria-required="true" value="" placeholder="">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-3 col-form-label">Fecha de Cierre</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" id="fechacierre" name="fechacierre" class="form-control daterange" aria-required="true" value="" placeholder="">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-3 col-form-label">Fuente</label>
                                                            <div class="col-sm-9">
                                                                <select id="fuente" class="form-control select2">
                                                                    <option value=""></option>
                                                                    @foreach ($fuentes as $f)
                                                                        <option value="{{ $f->id }}">{{ $f->nombre }}</option>
                                                                    @endforeach
                                                                </select>    
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-3 col-form-label">Requisito</label>
                                                            <div class="col-sm-9">
                                                                <select id="requisito" class="form-control select2">
                                                                    <option value=""></option>
                                                                    @foreach ($requisitos as $r)
                                                                        <option value="{{ $r->id }}">{{ $r->nombre }}</option>
                                                                    @endforeach
                                                                </select>    
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-3 col-form-label">Clasificación</label>
                                                            <div class="col-sm-9">
                                                                <select id="clasificacion" class="form-control select2">
                                                                    <option value=""></option>
                                                                    @foreach ($clasificaciones as $c)
                                                                        <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                                                                    @endforeach
                                                                </select>  
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-3 col-form-label">Proceso</label>
                                                            <div class="col-sm-9">
                                                                <select id="proceso" class="form-control select2">
                                                                    <option value=""></option>
                                                                    @foreach ($procesos as $p)
                                                                        <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                                                    @endforeach
                                                                </select>  
                                                            </div>
                                                        </div>
                                                
                                                        <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary reset-button">Limpiar</button>
                                                        <button type="button" class="btn btn-primary filter-button">Filtrar</button>
                                                        </div>
                                                    </div>
                                                    </form>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                {{-- Fin de la seccion de detalles de Filtros --}}

                                @can('create', App\Models\Noconformidad::class)
                                    <a href="{{ route('noconformidades.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                        <i class="bi bi-plus-lg"></i> {{ __('Insertar') }}
                                    </a>
                                @endcan

                            </div>
                        </div>

                        <div class="table-responsive p-2">
                            <table class="table table-hover" id="datatable" style="width: 100%">
                                <thead class="thead">
                                    <tr>
                                        <th></th>
                                        <th>Código</th>
                                        <th style="width: 30% !important">Descripción</th>
                                        <th>Estado</th> 
                                        <th>Fuente</th>
                                        <th>Requisito</th>
                                        <th>Clasificación</th>
                                        <th>Proceso</th>
                                        <th>Fecha de Notificación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </section>

    <script type="text/javascript">
        $(function () {

            select_menu('noconformidades')

            @include('layouts.message')

            var columns = [
                {data: 'id'},
                {data: 'codigo'},
                {data: 'descripcion'},
                {data: 'estado'},
                {data: 'fuente_id'},
                {data: 'requisito_id'},
                {data: 'clasificacion_id'},
                {data: 'proceso_id'},
                {data: 'fechanotificacion'},  
            ];

            var route = '{{ Route("noconformidades.index") }}'; 
            var sortcolumns = [0];
            dataTable = createDatatable(route, columns, sortcolumns);


            $('.filter-button').click(function (e) {

                e.preventDefault();

                var fechanotificacion = $('#fechanotificacion').val();
                var fechacierre = $('#fechacierre').val();
                var proceso = $('#proceso').val();
                var fuente = $('#fuente').val();
                var clasificacion = $('#clasificacion').val();
                var requisito = $('#requisito').val();

                if((fechanotificacion != '') || (fechacierre != '') || (proceso != "") || (fuente != "") || (clasificacion != "") || (requisito != "")){

                    $('#loading').removeClass('d-none');

                    dataTable.destroy();
                    var columns = [
                        {data: 'id'},
                        {data: 'codigo'},
                        {data: 'descripcion'},
                        {data: 'estado'},
                        {data: 'fuente_id'},
                        {data: 'requisito_id'},
                        {data: 'clasificacion_id'},
                        {data: 'proceso_id'},
                        {data: 'fechanotificacion'},  
                    ];

                    var route = '{!! Route("noconformidades.index", ["fechanotificacion" => "paramfechanotificacion","fechacierre" => "paramfechacierre","proceso" => "paramproceso","fuente" => "paramfuente","requisito" => "paramrequisito", "clasificacion" => "paramclasificacion"]) !!}'; 
                    
                    route = route.replace('paramfechanotificacion', fechanotificacion)
                    route = route.replace('paramfechacierre', fechacierre)
                    route = route.replace('paramproceso', proceso)
                    route = route.replace('paramfuente', fuente)
                    route = route.replace('paramrequisito', requisito)
                    route = route.replace('paramclasificacion', clasificacion)

                    var sortcolumns = [0];
                    dataTable = createDatatable(route, columns, sortcolumns);

                    $('#filter').modal('hide');

                }else{
                    Swal.fire('Faltan campos para filtrar');
                }


                });

            });

            $('.reset-button').click(function () {
                $('#filter-form').trigger("reset");
                $('.select2').val(null).trigger('change');

                var fechanotificacion = $('#fechanotificacion').val();
                var fechacierre = $('#fechacierre').val();
                var proceso = $('#proceso').val();
                var fuente = $('#fuente').val();
                var clasificacion = $('#clasificacion').val();
                var requisito = $('#requisito').val();

                $('#loading').removeClass('d-none');

                dataTable.destroy();
                var columns = [
                    {data: 'id'},
                    {data: 'codigo'},
                    {data: 'descripcion'},
                    {data: 'estado'},
                    {data: 'fuente_id'},
                    {data: 'requisito_id'},
                    {data: 'clasificacion_id'},
                    {data: 'proceso_id'},
                    {data: 'fechanotificacion'},   
                    ];

                var sortcolumns = [0];
                var route = '{!! Route("noconformidades.index", ["fechanotificacion" => "paramfechanotificacion","fechacierre" => "paramfechacierre","proceso" => "paramproceso","fuente" => "paramfuente","requisito" => "paramrequisito", "clasificacion" => "paramclasificacion"]) !!}'; 
                        
                route = route.replace('paramfechanotificacion', fechanotificacion)
                route = route.replace('paramfechacierre', fechacierre)
                route = route.replace('paramproceso', proceso)
                route = route.replace('paramfuente', fuente)
                route = route.replace('paramrequisito', requisito)
                route = route.replace('paramclasificacion', clasificacion)
                
                dataTable = createDatatable(route, columns, sortcolumns);

                $('#filter').modal('hide');

            });








    </script>

@endsection