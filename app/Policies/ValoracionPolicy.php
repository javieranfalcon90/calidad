<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Valoracion;
use App\Models\Riesgo;
use Illuminate\Auth\Access\Response;

class ValoracionPolicy
{

    public function create(User $user, Riesgo $riesgo): bool
    {

        foreach($user->roles as $role){
            if($role->hasPermissionTo('Create_Any_Valoraciones') ){
                $flag = 0;
                if($riesgo->analisis){
                    foreach ($riesgo->analisis->acciones as $accion) {
                        if($accion->estado != "Cerrado"){
                            $flag = 1;
                        }
                    }
                }
        
                if($flag == 0 && $riesgo->estado == "En Seguimiento" && !$riesgo->analisis->acciones->isEmpty()){
                    return true;
                }
            }elseif($role->hasPermissionTo('Create_Own_Valoraciones')){
                if($user->proceso == $riesgo->proceso){
                    $flag = 0;
                    if($riesgo->analisis){
                        foreach ($riesgo->analisis->acciones as $accion) {
                            if($accion->estado != "Cerrado"){
                                $flag = 1;
                            }
                        }
                    }
            
                    if($flag == 0 && $riesgo->estado == "En Seguimiento" && !$riesgo->analisis->acciones->isEmpty()){
                        return true;
                    }
                }

            }
        }
        return false;
    }

    public function update(User $user, Valoracion $valoracion): bool
    {

        if($valoracion->riesgo->estado != "Cerrado"){
            foreach($user->roles as $role){
                if($role->hasPermissionTo('Update_Any_Valoraciones') ){
                    return true;
                }elseif($role->hasPermissionTo('Update_Own_Valoraciones')){
                    if($user->proceso == $valoracion->riesgo->proceso){
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public function delete(User $user, Valoracion $valoracion): bool
    {
        if($valoracion->riesgo->estado != "Cerrado"){
            foreach($user->roles as $role){
                if($role->hasPermissionTo('Update_Any_Valoraciones') ){
                    return true;
                }elseif($role->hasPermissionTo('Update_Own_Valoraciones')){
                    if($user->proceso == $valoracion->riesgo->proceso){
                        return true;
                    }
                }
            }
        }

        return false;
    }

}
