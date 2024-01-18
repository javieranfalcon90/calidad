@extends('layouts.app')

@section('content')

    <div class="pagetitle">
    <h1>Trazas</h1>
    <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item">Trazas</li>
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

                        </div>
    
                        <div class="table-responsive p-2">
                            <table class="table table-hover" id="datatable" style="width: 100%">
                                <thead class="thead">
                                    <tr>
                                        <th></th>
                                        <th>Action</th>
										<th>Model</th>
                                        <th>User</th>
                                        <th>Time</th>
                                        <th>IP</th>
                                        <th>Details</th>    
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

            select_menu('trazas')

            var columns = [
                {data: 'id'},

                {data: 'event'},
                {data: 'auditable_type'},
                {data: 'user'},
                {data: 'created_at'},
                {data: 'ip_address'},
                {data: 'details'},
 
            ];

            var route = '{{ Route("audits.index") }}'; 
            var sorcolumns = [0, 6];
            createDatatable(route, columns, sorcolumns);
          
        });
    </script>

@endsection
