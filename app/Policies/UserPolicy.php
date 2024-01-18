<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{

    public function index(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Index_Users')){
                return true;
            }
        } 

        return false;
    }

    public function create(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Create_Users')){
                return true;
            }
        } 

        return false;
    }

    public function update(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Update_Users')){
                return true;
            }
        } 

        return false;
    }

    public function delete(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Delete_Users')){
                return true;
            }
        } 

        return false;
    }

}
