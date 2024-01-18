<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Efectividade
 *
 * @property $id
 * @property $nombre
 * @property $created_at
 * @property $updated_at
 *
 * @property Riesgo[] $riesgos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Efectividad extends Model
{
    
    protected $table = 'efectividades';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function riesgos()
    {
        return $this->hasMany('App\Models\Riesgo', 'efectividad_id', 'id');
    }
    

}
