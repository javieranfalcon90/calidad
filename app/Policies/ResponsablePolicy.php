<?php

namespace App\Policies;

use App\Models\Responsable;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ResponsablePolicy
{

    public function index(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Index_Responsables')){
                return true;
            }
        } 

        return false;
    }

    public function create(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Create_Responsables')){
                return true;
            }
        } 

        return false;
    }

    public function update(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Update_Responsables')){
                return true;
            }
        } 

        return false;
    }

    public function delete(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Delete_Responsables')){
                return true;
            }
        } 

        return false;
    }

}
