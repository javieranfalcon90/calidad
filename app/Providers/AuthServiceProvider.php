<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Models\Fuente;
use App\Models\Requisito;
use App\Models\Clasificacion;
use App\Models\Proceso;
use App\Models\Tipo;
use App\Models\Responsable;
use App\Models\Efectividad;
use App\Models\Nivel;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Audit;
use App\Models\Seguimiento;
use App\Models\Noconformidad;
use App\Models\Riesgo;
use App\Models\Analisis;
use App\Models\Accion;
use App\Models\Valoracion;
use App\Models\Oportunidad;

use App\Policies\FuentePolicy;
use App\Policies\RequisitoPolicy;
use App\Policies\ClasificacionPolicy;
use App\Policies\ProcesoPolicy;
use App\Policies\TipoPolicy;
use App\Policies\ResponsablePolicy;
use App\Policies\EfectividadPolicy;
use App\Policies\NivelPolicy;
use App\Policies\UserPolicy;
use App\Policies\RolePolicy;
use App\Policies\PermissionPolicy;
use App\Policies\AuditPolicy;
use App\Policies\SeguimientoPolicy;
use App\Policies\NoconformidadPolicy;
use App\Policies\RiesgoPolicy;
use App\Policies\AnalisisPolicy;
use App\Policies\AccionPolicy;
use App\Policies\ValoracionPolicy;
use App\Policies\OportunidadPolicy;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Fuente::class => FuentePolicy::class,
        Requisito::class => RequisitoPolicy::class,
        Clasificacion::class => ClasificacionPolicy::class,
        Proceso::class => ProcesoPolicy::class,
        Tipo::class => TipoPolicy::class,
        Responsable::class => ResponsablePolicy::class,
        Efectividad::class => EfectividadPolicy::class,
        Nivel::class => NivelPolicy::class,
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
        Audit::class => AuditPolicy::class,
        Seguimiento::class => SeguimientoPolicy::class,
        Noconformidad::class => NoconformidadPolicy::class,
        Riesgo::class => RiesgoPolicy::class,
        Analisis::class => AnalisisPolicy::class,
        Accion::class => AccionPolicy::class,
        Valoracion::class => ValoracionPolicy::class,
        Oportunidad::class => OportunidadPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

        $this->registerPolicies();


       /* Gate::before(function ($user, $ability) {
            return $user->hasRole('ROLE_ADMIN') ? true : null;
        });*/



       /* 
        Gate::define('owner', function (User $user, $entity) {

            if($user->hasRole('ROLE_ADMIN')){
                return true;
            }

            //-------------NO CONFORMIDADES------------------
            if($entity instanceof Noconformidad){
                if($user->roles[0]->hasPermissionTo('Show_Own_Noconformidades') or $user->roles[0]->hasPermissionTo('Edit_Own_Noconformidades')){                    
                    if($user->proceso == $entity->proceso){
                        return true;
                    }
                }elseif($user->roles[0]->hasPermissionTo('Show_Any_Noconformidades') or $user->roles[0]->hasPermissionTo('Edit_Any_Noconformidades')){        
                    return true;
                }
            }

            //------------------RIESGOS------------------
            if($entity instanceof Riesgo){
                if($user->roles[0]->hasPermissionTo('Show_Own_Riesgos') or $user->roles[0]->hasPermissionTo('Edit_Own_Riesgos')){                    
                    if($user->proceso == $entity->proceso){
                        return true;
                    }
                }elseif($user->roles[0]->hasPermissionTo('Show_Any_Riesgos') or $user->roles[0]->hasPermissionTo('Edit_Any_Riesgos')){
                    return true;
                }
            }
            
            //-----------------ANALISIS-------------------
            if($entity instanceof Analisis){
                if( $user->roles[0]->hasPermissionTo('Edit_Own_Analisis')){
                    if($user->proceso == $entity->analisisable->proceso){
                        return true;
                    }
                }elseif($user->roles[0]->hasPermissionTo('Edit_Any_Analisis')){
                    return true;
                }
            }

            // --------------ACCIONES---------------------
            if($entity instanceof Accion){
                if($user->roles[0]->hasPermissionTo('Show_Own_Acciones') or $user->roles[0]->hasPermissionTo('Edit_Own_Acciones')){
                    if($user->proceso == $entity->analisis->analisisable->proceso){
                        return true;
                    }    
                }elseif($user->roles[0]->hasPermissionTo('Show_Any_Acciones') or $user->roles[0]->hasPermissionTo('Edit_Any_Acciones')){
                    return true;
                }
            }

            //-------------SEGUIMIENTOS--------------------
            if($entity instanceof Seguimiento){
                if($user->roles[0]->hasPermissionTo('Edit_Own_Seguimientos') ){  
                    if($user->id == $entity->user->id){
                        return true;
                    }
                }elseif($user->roles[0]->hasPermissionTo('Edit_Any_Seguimientos') ){
                    return true;
                }
            }

            //---------------VALORACIONES------------------------
            if($entity instanceof Valoracion){
                if($user->roles[0]->hasPermissionTo('Edit_Own_Valoraciones') ){
                    if($user->proceso == $entity->riesgo->proceso){
                        return true;
                    }
                }elseif($user->roles[0]->hasPermissionTo('Edit_Any_Valoraciones')){
                    return true;
                }
            }

            //---------------OPORTUNIDADES------------------------
            if($entity instanceof Oportunidad){
                if($user->roles[0]->hasPermissionTo('Edit_Own_Oportunidades') ){
                    if($user->proceso == $entity->proceso){
                        return true;
                    }
                }elseif($user->roles[0]->hasPermissionTo('Edit_Any_Oportunidades')){
                    return true;
                }
            }
               
            return false;
        });
        */

    }
}
