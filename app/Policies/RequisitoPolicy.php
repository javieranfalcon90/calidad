<?php

namespace App\Policies;

use App\Models\Requisito;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RequisitoPolicy
{

    public function index(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Index_Requisitos')){
                return true;
            }
        } 

        return false;
    }

    public function create(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Create_Requisitos')){
                return true;
            }
        } 

        return false;
    }

    public function update(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Update_Requisitos')){
                return true;
            }
        } 

        return false;
    }

    public function delete(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Delete_Requisitos')){
                return true;
            }
        } 

        return false;
    }

}
