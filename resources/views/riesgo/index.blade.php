@extends('layouts.app')

@section('content')

    <div class="pagetitle">
    <h1>Riesgos</h1>
    <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item">Riesgos</li>
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
                                                    <label class="col-sm-3 col-form-label">Efectividad</label>
                                                    <div class="col-sm-9">
                                                        <select id="efectividad" class="form-control select2">
                                                            <option value=""></option>
                                                            @foreach ($efectividades as $e)
                                                                <option value="{{ $e->id }}">{{ $e->nombre }}</option>
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

                            @can('create', App\Models\Riesgo::class)
                                <a href="{{ route('riesgos.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                    <th>Codigo</th>
                                    <th style="width: 25% !important">Descripcion</th>
                                    <th>Estado</th> 
                                    <th>Proceso</th>
                                    <th>Fecha de Notificación</th>
                                    <th>Evaluación</th>
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

            select_menu('riesgos')

            @include('layouts.message')

            var columns = [
                {data: 'id'},
                {data: 'codigo'},
                {data: 'descripcion'},
                {data: 'estado'},               
                {data: 'proceso_id'},
                {data: 'fechanotificacion'},
                {data: 'valoracion_id'},
            ];

            var route = '{{ Route("riesgos.index") }}'; 
            var sortcolumns = [0];
            dataTable = createDatatable(route, columns, sortcolumns);

            $('.filter-button').click(function (e) {

                e.preventDefault();

                var fechanotificacion = $('#fechanotificacion').val();
                var fechacierre = $('#fechacierre').val();
                var proceso = $('#proceso').val();
                var efectividad = $('#efectividad').val();

                if((fechanotificacion != '') || (fechacierre != '') || (proceso != "") || (efectividad != "")){

                    $('#loading').removeClass('d-none');

                    dataTable.destroy();
                    var columns = [
                        {data: 'id'},
                        {data: 'codigo'},
                        {data: 'descripcion'},
                        {data: 'estado'},               
                        {data: 'proceso_id'},
                        {data: 'fechanotificacion'},
                        {data: 'evaluacion_id'}, 
                    ];

                    var route = '{!! Route("riesgos.index", ["fechanotificacion" => "paramfechanotificacion","fechacierre" => "paramfechacierre","proceso" => "paramproceso", "efectividad" => "paramefectividad"]) !!}'; 
                    
                    route = route.replace('paramfechanotificacion', fechanotificacion)
                    route = route.replace('paramfechacierre', fechacierre)
                    route = route.replace('paramproceso', proceso)
                    route = route.replace('paramefectividad', efectividad)

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
                var efectividad = $('#efectividad').val();

                $('#loading').removeClass('d-none');

                dataTable.destroy();
                var columns = [
                    {data: 'id'},
                        {data: 'codigo'},
                        {data: 'descripcion'},
                        {data: 'estado'},               
                        {data: 'proceso_id'},
                        {data: 'fechanotificacion'},
                        {data: 'evaluacion_id'}, 
                    ];

                var sortcolumns = [0];
                var route = '{!! Route("riesgos.index", ["fechanotificacion" => "paramfechanotificacion","fechacierre" => "paramfechacierre","proceso" => "paramproceso", "efectividad" => "paramefectividad"]) !!}'; 
                        
                route = route.replace('paramfechanotificacion', fechanotificacion)
                route = route.replace('paramfechacierre', fechacierre)
                route = route.replace('paramproceso', proceso)
                route = route.replace('paramefectividad', efectividad)
                
                dataTable = createDatatable(route, columns, sortcolumns);

                $('#filter').modal('hide');

            });
          
    </script>


@endsection