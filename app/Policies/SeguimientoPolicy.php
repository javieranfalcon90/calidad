<?php

namespace App\Policies;

use App\Models\Seguimiento;
use App\Models\Accion;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SeguimientoPolicy
{

    public function create(User $user, Accion $accion): bool
    {

        if($accion->estado != "Cerrado"){
            foreach($user->roles as $role){
                if($role->hasPermissionTo('Create_Any_Seguimientos') ){
                    return true;
                }elseif($role->hasPermissionTo('Create_Own_Seguimientos')){
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

    public function update(User $user, Seguimiento $seguimiento): bool
    {
        if($seguimiento->accion->estado != "Cerrado"){
            foreach($user->roles as $role){
                if($role->hasPermissionTo('Update_Any_Seguimientos') ){
                    return true;
                }elseif($role->hasPermissionTo('Update_Own_Seguimientos')  ){  
                    if($user->id == $seguimiento->user->id){
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public function delete(User $user, Seguimiento $seguimiento): bool
    {
        if($seguimiento->accion->estado != "Cerrado"){
            foreach($user->roles as $role){
                if($role->hasPermissionTo('Delete_Any_Seguimientos') ){
                    return true;
                }elseif($role->hasPermissionTo('Delete_Own_Seguimientos')  ){  
                    if($user->id == $seguimiento->user->id){
                        return true;
                    }
                }
            }
        }
        
        return false;
    }

}
