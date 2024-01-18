<?php

namespace App\Policies;

use App\Models\Analisis;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AnalisisPolicy
{

    public function create(User $user, $entity): bool
    {
        foreach($user->roles as $role){
            if(!$entity->analisis){
                if($role->hasPermissionTo('Create_Any_Analisis') ){
                    return true;
                }elseif($role->hasPermissionTo('Create_Own_Analisis')){
                    if($user->proceso == $entity->proceso){
                        return true;
                    }
                }
            }
        } 
        return false;
    }

    public function update(User $user, Analisis $analisis): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Update_Any_Analisis') ){
                if($analisis->analisisable->estado == 'Nuevo'){
                    return true;
                }
            }elseif($role->hasPermissionTo('Update_Own_Analisis')){
                if($user->proceso == $analisis->analisisable->proceso && $analisis->analisisable->estado == 'Nuevo'){
                    return true;
                }
            }
        } 
        return false;
    }

    public function delete(User $user, Analisis $analisis): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Delete_Any_Analisis') ){
                if($analisis->analisisable->estado == 'Nuevo'){
                    return true;
                }
            }elseif($role->hasPermissionTo('Delete_Own_Analisis')){
                if($user->proceso == $analisis->analisisable->proceso && $analisis->analisisable->estado == 'Nuevo'){
                    return true;
                }
            }
        } 
        return false;
    }

}
