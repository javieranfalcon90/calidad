<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class Valoracion extends Model
{
    
    protected $table = 'valoraciones';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['descripcion', 'conclusion', 'fecha', 'riesgo_id','efectividad_id'];

    protected function fecha(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => (($value) ? (new Carbon($value))->format('d-m-Y'): ''),
            set: fn ($value) => (($value) ? (new Carbon($value)) : null),
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function efectividad()
    {
        return $this->hasOne('App\Models\Efectividad', 'id', 'efectividad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function riesgo()
    {
        return $this->belongsTo('App\Models\Riesgo');
    }
    

}
