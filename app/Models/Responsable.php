<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Responsable
 *
 * @property $id
 * @property $nombre
 * @property $created_at
 * @property $updated_at
 *
 * @property Accione[] $acciones
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Responsable extends Model
{
    
    protected $table = 'responsables';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function acciones()
    {
        return $this->hasMany('App\Models\Accion', 'responsable_id', 'id');
    }
    

}
