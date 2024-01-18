<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Analisis extends Model
{
  
    public $table = 'analisis';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['causa','fecha','participantes', 'nivel_id', 'manifestacionesnegativas','analisisable_id', 'analisisable_type'];

    protected function fecha(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => (($value) ? (new Carbon($value))->format('d-m-Y'): ''),
            set: fn ($value) => (($value) ? (new Carbon($value)) : null),
        );
    }

    public function analisisable()
    {
        return $this->morphTo();
    }

    public function acciones(): MorphMany
    {
        return $this->morphMany('App\Models\Accion', 'accionable');
    }

    public function nivel()
    {
        return $this->hasOne('App\Models\Nivel', 'id', 'nivel_id');
    }
    
}
