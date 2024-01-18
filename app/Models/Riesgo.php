<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class Riesgo extends Model
{
    
    protected $table = 'riesgos';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['proceso_id','codigo','descripcion','fechanotificacion','fechacierre','estado', 'nivel_id'];

    protected function fechanotificacion(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => (($value) ? (new Carbon($value))->format('d-m-Y'): ''),
            set: fn ($value) => (($value) ? (new Carbon($value)) : null),
        );
    }

    protected function fechacierre(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => (($value) ? (new Carbon($value))->format('d-m-Y'): ''),
            set: fn ($value) => (($value) ? (new Carbon($value)) : null),
        );
    }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function nivel()
    {
        return $this->hasOne('App\Models\Nivel', 'id', 'nivel_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function valoracion()
    {
        return $this->hasOne('App\Models\Valoracion');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function proceso()
    {
        return $this->hasOne('App\Models\Proceso', 'id', 'proceso_id');
    }
    
    public function analisis()
    {
        return $this->morphOne('App\Models\Analisis', 'analisisable');
    }

}
