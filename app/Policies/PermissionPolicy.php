<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PermissionPolicy
{

    public function index(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Index_Permissions')){
                return true;
            }
        } 

        return false;
    }

    public function create(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Create_Permissions')){
                return true;
            }
        } 

        return false;
    }

    public function update(User $user, Permission $permission): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Update_Permissions')){
                return true;
            }
        } 

        return false;
    }

    public function delete(User $user, Permission $permission): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Delete_Permissions')){
                return true;
            }
        } 

        return false;
    }

}
