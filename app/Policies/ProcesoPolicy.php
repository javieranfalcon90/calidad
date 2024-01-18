<?php

namespace App\Policies;

use App\Models\Proceso;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProcesoPolicy
{

    public function index(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Index_Procesos')){
                return true;
            }
        } 

        return false;
    }

    public function create(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Create_Procesos')){
                return true;
            }
        } 

        return false;
    }

    public function update(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Update_Procesos')){
                return true;
            }
        } 

        return false;
    }

    public function delete(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Delete_Procesos')){
                return true;
            }
        } 

        return false;
    }

}
