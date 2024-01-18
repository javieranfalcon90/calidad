<?php

namespace App\Policies;

use App\Models\Riesgo;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RiesgoPolicy
{

    public function index(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Index_Riesgos')){
                return true;
            }
        } 
        return false;
    }

    public function show(User $user, Riesgo $riesgo): bool
    {

        foreach($user->roles as $role){
            if($role->hasPermissionTo('Show_Any_Riesgos') ){
                return true;
            }elseif($role->hasPermissionTo('Show_Own_Riesgos')){
                if($user->proceso == $riesgo->proceso){
                    return true;
                }
            }
        } 
        return false;
    }

    public function create(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Create_Riesgos')){
                return true;
            }
        } 
        return false;
    }

    public function update(User $user, Riesgo $riesgo): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Update_Riesgos') ){
                if($riesgo->estado == 'Nuevo'){
                    return true;
                }
            }
        } 
        return false;
    }

    public function delete(User $user, Riesgo $riesgo): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Delete_Riesgos') ){
                if($riesgo->estado == 'Nuevo'){
                    return true;
                }
            }
        } 
        return false;
    }

    public function close(User $user, Riesgo $riesgo): bool
    {
        if($riesgo->valoracion){
            foreach($user->roles as $role){
                if($role->hasPermissionTo('Close_Riesgos')){
                    return true;
                }
            } 
        }
        return false;
    }

}
