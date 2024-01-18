<?php

namespace App\Policies;

use App\Models\Oportunidad;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OportunidadPolicy
{

    public function index(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Index_Oportunidades')){
                return true;
            }
        } 

        return false;
    }

    public function show(User $user, Oportunidad $oportunidad): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Show_Any_Oportunidades') ){
                return true;
            }elseif($role->hasPermissionTo('Show_Own_Oportunidades')){
                if($user->proceso == $oportunidad->proceso){
                    return true;
                }
            }
        } 
        return false;
    }

    public function create(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Create_Oportunidades')){
                return true;
            }
        } 
        return false;
    }

    public function update(User $user, Oportunidad $oportunidad): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Update_Oportunidades') ){
                if($oportunidad->estado == 'Nuevo'){
                    return true;
                }
            }
        } 
        return false;
    }

    public function delete(User $user, Oportunidad $oportunidad): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Delete_Oportunidades') ){
                if($oportunidad->estado == 'Nuevo'){
                    return true;
                }
            }
        } 
        return false;
    }

    public function close(User $user, Oportunidad $oportunidad): bool
    {

        foreach($user->roles as $role){
            if($role->hasPermissionTo('Close_Oportunidades')){
                $flag = 0;
                foreach($oportunidad->acciones as $accion){
                    if($accion->estado != 'Cerrado'){
                        $flag = 1;
                        break;
                    }
                }

                if($flag == 0){
                    return true;
                }
            }
        } 
        return false;
    }

}
