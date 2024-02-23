@extends('layouts.app')

@section('content')

    <div class="pagetitle">
    <h1>Oportunidades</h1>
    <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item">Oportunidades</li>
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

                        @can('create', App\Models\Oportunidad::class)
                            <div class="float-right">
                                <a href="{{ route('oportunidades.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                    <i class="bi bi-plus-lg"></i> {{ __('Insertar') }}
                                </a>
                            </div>
                        @endcan
                    </div>

                    <div class="table-responsive p-2">
                        <table class="table table-hover" id="datatable" style="width: 100%">
                            <thead class="thead">
                                <tr>
                                    <th></th>
                                    <th>Código</th>
                                    <th>Tipo</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
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

        select_menu('oportunidades')

        @include('layouts.message')

        $("#datatable tbody").on("click", ".delete", function() {
            var form = $(this).closest("form");
            createDelete(form)
        });

        var columns = [
            {data: 'id'},
            {data: 'codigo'},
            {data: 'tipo'},
            {data: 'descripcion'},
            {data: 'estado'},
            {data: 'proceso_id'},
            {data: 'fechanotificacion'},

        ];

        var route = '{{ Route("oportunidades.index") }}'; 
        var sortcolumns = [0];
        createDatatable(route, columns, sortcolumns);
      
    });
</script>


@endsection