<?php

namespace App\Policies;

use App\Models\Accion;
use App\Models\Oportunidad;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AccionPolicy
{

    public function show(User $user, Accion $accion): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Show_Any_Acciones') ){
                return true;
            }elseif($role->hasPermissionTo('Show_Own_Acciones')){
                if($accion->accionable_type == 'App\Models\Oportunidad'){
                    if($user->proceso == $accion->accionable->proceso){
                        return true;
                    }
                }else{
                    if($user->proceso == $accion->accionable->analisisable->proceso){
                        return true;
                    }
                }
                
            }
        } 
        return false;
    }

    public function create(User $user, $entity): bool
    {

        foreach($user->roles as $role){
            if($entity instanceof Oportunidad){
                if($entity->estado != "Cerrado"){
                    if($role->hasPermissionTo('Create_Any_Acciones') ){
                        return true;
                    }elseif($role->hasPermissionTo('Create_Own_Acciones')){                        
                        if($user->proceso == $entity->proceso){
                            return true;
                        }
                    } 
                }
            }else{

                if($entity->analisisable->estado != "Cerrado"){

                    if($entity->analisisable_type == "App\Models\Riesgo"){ 
                        if($entity->analisisable->estado != "Evaluado"){
                            if($role->hasPermissionTo('Create_Any_Acciones') ){ 
                                return true;
                            }elseif($role->hasPermissionTo('Create_Own_Acciones')){                        
                                if($user->proceso == $entity->analisisable->proceso){
                                    return true;
                                }
                            }
                        } 
                    }else{
                        if($role->hasPermissionTo('Create_Any_Acciones') ){ 
                            return true;
                        }elseif($role->hasPermissionTo('Create_Own_Acciones')){                        
                            if($user->proceso == $entity->analisisable->proceso){
                                return true;
                            }
                        } 
                    }

                }
            }
        }

        return false;
    }

    public function update(User $user, Accion $accion): bool
    {
        if($accion->estado != "Cerrado"){      

            foreach($user->roles as $role){
                if($role->hasPermissionTo('Update_Any_Acciones') ){
                    return true;
                }elseif($role->hasPermissionTo('Update_Own_Acciones')){
                    if($accion->accionable_type == 'App\Models\Oportunidad'){
                        if($user->proceso == $accion->accionable->proceso){
                            return true;
                        }
                    }else{
                        if($user->proceso == $accion->accionable->analisisable->proceso){
                            return true;
                        }
                    }

                }

            }
        }
        return false;
    }

    public function delete(User $user, Accion $accion): bool
    {
        if($accion->estado != "Cerrado"){      

            foreach($user->roles as $role){
                if($role->hasPermissionTo('Delete_Any_Acciones') ){
                    return true;
                }elseif($role->hasPermissionTo('Delete_Own_Acciones')){
                    if($accion->accionable_type == 'App\Models\Oportunidad'){
                        if($user->proceso == $accion->accionable->proceso){
                            return true;
                        }
                    }else{
                        if($user->proceso == $accion->accionable->analisisable->proceso){
                            return true;
                        }
                    }

                }

            }
        }
        return false;
    }

    public function close(User $user, Accion $accion): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Close_Acciones')){
                return true;
            }
        }
        return false;
    }

}
