<?php

namespace App\Policies;

use App\Models\Noconformidad;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class NoconformidadPolicy
{

    public function index(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Index_Noconformidades')){
                return true;
            }
        } 
        return false;
    }

    public function show(User $user, Noconformidad $noconformidad): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Show_Any_Noconformidades') ){
                return true;
            }elseif($role->hasPermissionTo('Show_Own_Noconformidades')){
                if($user->proceso == $noconformidad->proceso){
                    return true;
                }
            }
        } 
        return false;
    }

    public function create(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Create_Noconformidades')){
                return true;
            }
        } 
        return false;
    }

    public function update(User $user, Noconformidad $noconformidad): bool
    {

        foreach($user->roles as $role){
            if($role->hasPermissionTo('Update_Noconformidades') ){
                if($noconformidad->estado == 'Nuevo'){
                    return true;
                }
            }
        } 
        return false;
    }

    public function delete(User $user, Noconformidad $noconformidad): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Delete_Noconformidades') ){
                if($noconformidad->estado == 'Nuevo'){
                    return true;
                }
            }
        } 
        return false;
    }

    public function close(User $user, Noconformidad $noconformidad): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Close_Noconformidades')){

                $puedeCerrar = false;
                $flag = 0;
                if($noconformidad->analisis){
                    foreach ($noconformidad->analisis->acciones as $accion) {
                        if($accion->estado != "Cerrado"){
                            $flag = 1;
                            break;
                        }
                    }
                }
        
                if($flag == 0 && $noconformidad->analisis && !$noconformidad->analisis->acciones->isEmpty()){
                    return true;
                }

            }
        } 
        return false;

    }

}
