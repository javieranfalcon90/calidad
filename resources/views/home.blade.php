@extends('layouts.app')

@section('content')

  <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </nav>
  </div>

  <section class="section dashboard">
  <div class="row">
    <div class="col-8">
        <div class="row">

          <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card">
        
              <div class="card-body">
                <h5 class="card-title text-primary">No Conformidades <span>| Total</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-files"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{ $cant_noconformidades }}</h6>
                  </div>
                </div>
              </div>

            </div>
          </div>

          <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card">
              <div class="card-body">
                <h5 class="card-title text-primary">Riesgos <span>| Total</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-exclamation-triangle"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{ $cant_riesgos }}</h6>
                  </div>
                </div>
              </div>

            </div>
          </div>

          <div class="col-xxl-4 col-md-6">
            <div class="card info-card customers-card">
        
              <div class="card-body">
                <h5 class="card-title text-primary">Oportunidades <span>| Total</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-card-checklist"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{ $cant_oportunidades }}</h6>
                  </div>
                </div>
              </div>

            </div>
          </div>

        </div>


        <div class="col-lg-12">
    
            <div class="card">
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h5 class="card-title text-primary">{{ __('Cantidad de No Conformidades por Años') }}</h5>
                    </div>
  
                    <div id="chart" style="min-height: 365px;"></div>
  
              </div>
            </div>
    
        </div>
    
        <div class="col-lg-12">
  
          <div class="card">
              <div class="card-body">
                  <div style="display: flex; justify-content: space-between; align-items: center;">
                      <h5 class="card-title text-primary">{{ __('Cantidad de No Conformidades por Procesos este Año') }}</h5>
                  </div>

                  <div id="noconf4" style="min-height: 365px;"></div>
            </div>
          </div>
  
        </div>

        <div class="col-lg-12">
    
          <div class="card">
              <div class="card-body">
                  <div style="display: flex; justify-content: space-between; align-items: center;">
                      <h5 class="card-title text-primary">{{ __('Porciento de cumplimiento de Acciones de Riesgos por Años') }}</h5>
                  </div>

                  <div id="risk2" style="min-height: 365px;"></div>

            </div>
          </div>
  
        </div>

        <div class="col-lg-12">
    
          <div class="card">
              <div class="card-body">
                  <div style="display: flex; justify-content: space-between; align-items: center;">
                      <h5 class="card-title text-primary">{{ __('Porciento de Riesgos por Efectividad por Años') }}</h5>
                  </div>

                  <div id="risk3" style="min-height: 365px;"></div>

            </div>
          </div>
  
        </div>

        <div class="col-lg-12">
    
          <div class="card">
              <div class="card-body">
                  <div style="display: flex; justify-content: space-between; align-items: center;">
                      <h5 class="card-title text-primary">{{ __('Porciento de Riesgos por Efectividad por Años') }}</h5>
                  </div>

                  <div id="risk4">

                    <table class="table bordered">
                      <thead>

                        <tr>
                          <th rowspan="2">Procesos</th>
                          @foreach ($year as $y)
                              <th colspan="2" class="text-center">{{ $y }} </th>
                          @endforeach
                        </tr>

                        <tr>
                          @foreach ($year as $y)
                          @foreach ($efectividades as $e)
                            <th class="text-center">{{ $e }}</th>
                          @endforeach
                          @endforeach
                        </tr>
                      </thead>
                      <tbody>

                        @php($i = 0)
                        @foreach ($procesos as $p)
                          <tr>
                              <th>{{ $p }}</th>
                              @php($j = 0)
                              @foreach ($year as $y)
                                @foreach ($efectividades as $e)
                                <td class="text-center">{{ $cantriesgosxefectividadxannoxproceso[$i][$j] }}</td>
                                @php($j++)
                                @endforeach
                              @endforeach 
                              
                          </tr>
                          @php($i++)
                        @endforeach
                      </tbody>

                    </table>
                  
                  </div>

            </div>
          </div>
  
        </div>

    </div>

    <div class="col-4">
      <div class="row">

        <div class="col-lg-12">
  
          <div class="card">
              <div class="card-body">
                  <div style="display: flex; justify-content: space-between; align-items: center;">
                      <h5 class="card-title text-primary">{{ __('Cantidad de No Conformidades por Estados') }}</h5>
                  </div>

                  <div id="noconf2" style="min-height: 365px;"></div>

            </div>
          </div>
  
        </div>

        <div class="col-lg-12">
  
          <div class="card">
              <div class="card-body">
                  <div style="display: flex; justify-content: space-between; align-items: center;">
                      <h5 class="card-title text-primary">{{ __('Cantidad de Acciones de No Conformidades por Estados') }}</h5>
                  </div>

                  <div id="noconf3" style="min-height: 365px;"></div>

            </div>
          </div>
  
        </div>

        <div class="col-lg-12">
  
          <div class="card">
              <div class="card-body">
                  <div style="display: flex; justify-content: space-between; align-items: center;">
                      <h5 class="card-title text-primary">{{ __('Cantidad de Acciones de No Conformidades por Procesos') }}</h5>
                  </div>

                  <div id="noconf5" style="min-height: 365px;">
                  
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Procesos</th>
                          <th class="text-center">Total</th>
                          <th class="text-center">Cumplido</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php($i = 0)
                        @foreach ($procesos as $p)
                          <tr>
                            <td>{{ $p }}</td>
                            <td class="text-center">{{ $total[$i] }}</td>
                            <td class="text-center">{{ $cumplidos[$i] }}</td>
                          </tr>
                          @php($i++)
                        @endforeach
                      </tbody>
                    </table>
                  
                  </div>

            </div>
          </div>
  
        </div>

        <div class="col-lg-12">
  
          <div class="card">
              <div class="card-body">
                  <div style="display: flex; justify-content: space-between; align-items: center;">
                      <h5 class="card-title text-primary">{{ __('Cantidad de Riesgos por Nivel') }}</h5>
                  </div>

                  <div id="risk1" style="min-height: 365px;"></div>

            </div>
          </div>
  
        </div>

        <div class="col-lg-12">
  
          <div class="card">
              <div class="card-body">
                  <div style="display: flex; justify-content: space-between; align-items: center;">
                      <h5 class="card-title text-primary">{{ __('Cantidad de Oportunidades por Año') }}</h5>
                  </div>

                  <div id="oportunidad1" style="min-height: 365px;"></div>

            </div>
          </div>
  
        </div>

      </div>


    </div>


  </div>
  </section>

<script type="text/javascript">
  $(function () {

      select_menu('dashboard')

      var options = {
        series: [
          {
            name: "No Conformidades",
            data: @json($cant),
          },
        ],
        
        chart: {
          height: 300,
          type: 'bar',
          zoom: {
            enabled: false
          },
          toolbar: {
            show: true
          }
        },
        dataLabels: {
          enabled: false
        },
        xaxis: {
          categories: @json($year),
        },
        legend: {
          position: 'top',
        },

      };

      var chart = new ApexCharts(document.querySelector("#chart"), options);
      chart.render();

      //--------------------------------------------------------------------------------------------

      var options = {
        series: @json($cantnoconf2),

        chart: {
          height: 250,
          type: 'pie',
          zoom: {
            enabled: false
          },
          toolbar: {
            show: true
          }
        },
        dataLabels: {
          enabled: false
        },
        labels: ['Nuevo', 'En Seguimiento', 'Cerrado'],
        legend: {
          position: 'top',
        },

      };

      var chart = new ApexCharts(document.querySelector("#noconf2"), options);
      chart.render();

      //-------------------------------------------------------------------------------------------

      var options = {
        series: @json($cantnoconf3),

        chart: {
          height: 250,
          type: 'pie',
          zoom: {
            enabled: false
          },
          toolbar: {
            show: true
          }
        },
        dataLabels: {
          enabled: false
        },
        labels: ['Nuevo', 'En Seguimiento', 'Cerrado'],
        legend: {
          position: 'top',
        },

      };

      var chart = new ApexCharts(document.querySelector("#noconf3"), options);
      chart.render();

      //-------------------------------------------------------------------------------------------

      var options = {
          series: [{
            name: 'Cantidad',
            data: @json($cantnoconf4),
        }],
          chart: {
          type: 'bar',
          height: 300
        },
        plotOptions: {
          bar: {
            borderRadius: 4,
            horizontal: true,
          }
        },
        dataLabels: {
          enabled: false
        },
        xaxis: {
          categories: @json($procesos),
        }
        };

      var chart = new ApexCharts(document.querySelector("#noconf4"), options);
      chart.render();

      //-------------------------------------------------------------------------------------------

      var options = {
        series: @json($cantrisk1),

        chart: {
          height: 250,
          type: 'pie',
          zoom: {
            enabled: false
          },
          toolbar: {
            show: true
          }
        },
        dataLabels: {
          enabled: false
        },
        labels: @json($niveles),
        legend: {
          position: 'top',
        },

      };

      var chart = new ApexCharts(document.querySelector("#risk1"), options);
      chart.render();

      //----------------------------------------------------------------------------

      var options = {
        series: [
          {
            name: "Cumplidos",
            data: @json($porcientocumplido),
          },
          {
            name: "No Cumplidos",
            data: @json($porcientonocumplido),
          },
        ],
        
        chart: {
          height: 300,
          type: 'bar',
          zoom: {
            enabled: false
          },
          toolbar: {
            show: true
          }
        },
        dataLabels: {
          enabled: false
        },
        xaxis: {
          categories: @json($year),
        },
        legend: {
          position: 'top',
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return val + " %"
            }
          }
        }

      };

      var chart = new ApexCharts(document.querySelector("#risk2"), options);
      chart.render();

      //----------------------------------------------------------------------------
   
     var options = {
        series: [

          @php($i = 0)
          @foreach ($efectividades as $e)
            {
              name: "{{ $e }}",
              data: @json($porcientoxefectividades[$i]),
            },
          @php($i++)
          @endforeach

        ],
        
        chart: {
          height: 300,
          type: 'bar',
          zoom: {
            enabled: false
          },
          toolbar: {
            show: true
          }
        },
        dataLabels: {
          enabled: false
        },
        xaxis: {
          categories: @json($year),
        },
        legend: {
          position: 'top',
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return val + " %"
            }
          }
        }

    };

      var chart = new ApexCharts(document.querySelector("#risk3"), options);
      chart.render();

      //----------------------------------------------------------------------------------

      
      var options = {
        series: @json($cantoportunidadesxanno),

        chart: {
          height: 250,
          type: 'donut',
          zoom: {
            enabled: false
          },
          toolbar: {
            show: true
          }
        },
        dataLabels: {
          enabled: false
        },
        labels: @json($year),
        legend: {
          position: 'top',
        },

      };

      var chart = new ApexCharts(document.querySelector("#oportunidad1"), options);
      chart.render();



  });
</script>

@endsection