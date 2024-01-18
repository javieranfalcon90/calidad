<?php

namespace App\Policies;

use App\Models\Tipo;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TipoPolicy
{

    public function index(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Index_Tipos')){
                return true;
            }
        } 

        return false;
    }

    public function create(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Create_Tipos')){
                return true;
            }
        } 

        return false;
    }

    public function update(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Update_Tipos')){
                return true;
            }
        } 

        return false;
    }

    public function delete(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Delete_Tipos')){
                return true;
            }
        } 

        return false;
    }

}
