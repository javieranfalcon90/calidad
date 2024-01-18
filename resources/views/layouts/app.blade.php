@extends('layouts.base')

@section('app')

<header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('home') }}" class="logo d-flex align-items-center">
                <img src="{{ URL::asset('img/logo_min.png') }}" alt="">
        <span class="d-none d-lg-block">CALIDAD</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center" >

                <li class="nav-item dropdown">

                        <a class="nav-link nav-icon show" href="#" data-bs-toggle="dropdown" aria-expanded="true">
                          <i class="bi bi-bell"></i>
                          @if( count(auth()->user()->unreadNotifications) > 0)
                          <span class="badge bg-primary badge-number">{{ count(auth()->user()->unreadNotifications) }}</span>
                          @endif
                        </a><!-- End Notification Icon -->
              
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages" data-popper-placement="bottom-end" style="min-width: 20em !important">
                          <li class="dropdown-header">
                                Tienes <b>{{ count(auth()->user()->unreadNotifications ) }}</b> notificacion/es sin leer.
                          </li>
                          <li>
                            <hr class="dropdown-divider">
                          </li>
              
                          @php($newnotifications = auth()->user()->unreadNotifications->take(-4))
                          @foreach ($newnotifications  as $note)
                          <li class="message-item">
                                <a href="{{ route('notifications.read', $note->id) }}">
                                        <i style="font-size: 25px; margin: 5px 10px" class="bi bi-exclamation-circle mr-3 text-{{$note->data['type']}}"></i>
                                <div>
                                        <h4>{{$note->data['username']}}</h4>
                                        <p>{{$note->data['text']}}</p>
                                        <p><b>{{$note->created_at->diffForHumans(Carbon\Carbon::now())}}</b></p>
                                </div>
                                </a>
                          </li>
              
                          <li>
                            <hr class="dropdown-divider">
                          </li>
                          @endforeach
              
                
                          <li>
                            <hr class="dropdown-divider">
                          </li>
                          <li class="dropdown-footer">
                            <a href="{{ route('notifications.readall') }}">Marcar todas como leídas.</a>
                          </li>
              
                        </ul><!-- End Notification Dropdown Items -->
              
                      </li>


        
                <li class="nav-item dropdown pe-3">

                        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i>
                                <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()->name }}</span>
                        </a><!-- End Profile Iamge Icon -->

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                                <li class="dropdown-header">
                                <h6>{{ auth()->user()->name }}</h6>
                                <span>{{ auth()->user()->getRoleNames()->first() }}</span>
                                </li>
                                <li>
                                <hr class="dropdown-divider">
                                </li>

                                <li>
                                <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                        
                                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                                this.closest('form').submit();">
                                                <i class="bi bi-box-arrow-right"></i>Logout
                                        </a>
                                </form>
                                </li>

                        </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

        </ul>
        </nav><!-- End Icons Navigation -->
        
</header>

<aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">
            
                <li class="nav-item">
                    <a class="nav-link collapsed" href="{{ route('home') }}" id="dashboard">
                      <i class="bi bi-clipboard-data"></i>
                      <span>Dashboard</span>
                    </a>
                </li><!-- End Dashboard Nav -->
            
                <li class="nav-heading">Principal</li>

                @can('index', App\Models\Noconformidad::class)
                <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route('noconformidades.index') }}" id="noconformidades">
                          <i class="bi bi-files"></i>
                          <span>No Conformidades</span>
                        </a>
                </li><!-- End Dashboard Nav -->
                @endcan

                @can('index', App\Models\Riesgo::class)
                <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route('riesgos.index') }}" id="riesgos">
                          <i class="bi bi-grid"></i>
                          <span>Riesgos</span>
                        </a>
                </li><!-- End Dashboard Nav -->
                @endcan

                @can('index', App\Models\Oportunidad::class)
                <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route('oportunidades.index') }}" id="oportunidades">
                          <i class="bi bi-grid"></i>
                          <span>Oportunidades</span>
                        </a>
                </li><!-- End Dashboard Nav -->
                @endcan
        


                @if(auth()->user()->can('index', App\Models\Fuente::class) or 
                    auth()->user()->can('index', App\Models\Requisito::class) or
                    auth()->user()->can('index', App\Models\Clasificacion::class) or
                    auth()->user()->can('index', App\Models\Proceso::class) or
                    auth()->user()->can('index', App\Models\Tipo::class) or
                    auth()->user()->can('index', App\Models\Responsable::class) or
                    auth()->user()->can('index', App\Models\Efectividad::class) or
                    auth()->user()->can('index', App\Models\Nivel::class)
                )

                <li class="nav-heading">Configuración</li>
        
                @can('index', App\Models\Fuente::class)
                <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ Route('fuentes.index') }}" id="fuentes">
                        <i class="bi bi-person"></i>
                        <span>Fuentes</span>
                        </a>
                </li><!-- End Profile Page Nav -->
                @endcan
                
                @can('index', App\Models\Requisito::class)
                <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ Route('requisitos.index') }}" id="requisitos">
                        <i class="bi bi-person"></i>
                        <span>Requisitos</span>
                        </a>
                </li><!-- End Profile Page Nav -->
                @endcan

                @can('index', App\Models\Clasificacion::class)
                <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ Route('clasificaciones.index') }}" id="clasificaciones">
                        <i class="bi bi-person"></i>
                        <span>Clasificaciones</span>
                        </a>
                </li><!-- End Profile Page Nav -->
                @endcan

                @can('index', App\Models\Proceso::class)
                <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ Route('procesos.index') }}" id="procesos">
                        <i class="bi bi-person"></i>
                        <span>Procesos</span>
                        </a>
                </li><!-- End Profile Page Nav -->
                @endcan

                @can('index', App\Models\Tipo::class)
                <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ Route('tipos.index') }}" id="tiposaccion">
                        <i class="bi bi-person"></i>
                        <span>Tipos de Acción</span>
                        </a>
                </li><!-- End Profile Page Nav -->
                @endcan

                @can('index', App\Models\Responsable::class)
                <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ Route('responsables.index') }}" id="responsables">
                        <i class="bi bi-person"></i>
                        <span>Responsables</span>
                        </a>
                </li><!-- End Profile Page Nav -->
                @endcan

                @can('index', App\Models\Efectividad::class)
                <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ Route('efectividades.index') }}" id="efectividades">
                        <i class="bi bi-person"></i>
                        <span>Efectividades</span>
                        </a>
                </li><!-- End Profile Page Nav -->
                @endcan

                @can('index', App\Models\Nivel::class)
                <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ Route('niveles.index') }}" id="niveles">
                        <i class="bi bi-person"></i>
                        <span>Niveles</span>
                        </a>
                </li><!-- End Profile Page Nav -->
                @endcan

                @endif


                @if(auth()->user()->can('index', App\Models\User::class) or 
                    auth()->user()->can('index', App\Models\Role::class) or
                    auth()->user()->can('index', App\Models\Permission::class) 
                )
                <li class="nav-heading">Administración</li>

                <li class="nav-item">
                        <a class="nav-link collapsed" data-bs-target="#seguridad-nav" data-bs-toggle="collapse" href="#">
                                <i class="bi bi-lock"></i><span>Seguridad</span><i class="bi bi-chevron-down ms-auto"></i>
                        </a>
                        <ul id="seguridad-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                                @can('index', App\Models\User::class)
                                <li>
                                <a href="{{ Route('users.index') }}"><i class="bi bi-circle"></i><span>Usuarios</span></a>
                                </li>
                                @endcan

                                @can('index', App\Models\Role::class)
                                <li>
                                <a href="{{ Route('roles.index') }}"><i class="bi bi-circle"></i><span>Roles</span></a>
                                </li>
                                @endcan

                                @can('index', App\Models\User::class)
                                <li>
                                <a href="{{ Route('permissions.index') }}"><i class="bi bi-circle"></i><span>Permisos</span></a>
                                </li>
                                @endcan
                        </ul>
                </li><!-- End Seguridad Nav -->
                @endif

                @can('index', App\Models\Audit::class)
                
                <li class="nav-heading">Seguridad</li>

                <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ Route('audits.index') }}" id="trazas"><i class="bi bi-grid"></i><span>Trazas</span></a>
                </li><!-- End Trasas Nav -->
                @endcan
                        
        </ul>
            
</aside>

<main id="main" class="main">

@yield('content')

</main>

@endsection