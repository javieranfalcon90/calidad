<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Clasificacion
 *
 * @property $id
 * @property $nombre
 * @property $created_at
 * @property $updated_at
 *
 * @property Noconformidad[] $noconformidades
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Clasificacion extends Model
{
    
    public $table = 'clasificaciones';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function noconformidades()
    {
        return $this->hasMany('App\Models\Noconformidad', 'clasificacion_id', 'id');
    }
    

}
