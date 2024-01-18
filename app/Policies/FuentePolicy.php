<?php

namespace App\Policies;

use App\Models\Fuente;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FuentePolicy
{

    public function index(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Index_Fuentes')){
                return true;
            }
        } 

        return false;
    }

    public function create(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Create_Fuentes')){
                return true;
            }
        } 

        return false;
    }

    public function update(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Update_Fuentes')){
                return true;
            }
        }        

        return false;
    }

    public function delete(User $user): bool
    {
        foreach($user->roles as $role){
            if($role->hasPermissionTo('Delete_Fuentes')){
                return true;
            }
        }

        return false;
    }

}
