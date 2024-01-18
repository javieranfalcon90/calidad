<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;


class Noconformidad extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public $table = 'noconformidades';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['fuente_id','clasificacion_id','proceso_id', 'requisito_id','codigo','descripcion','fechanotificacion','fechacierre','estado'];

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
    public function clasificacion()
    {
        return $this->hasOne('App\Models\Clasificacion', 'id', 'clasificacion_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function fuente()
    {
        return $this->hasOne('App\Models\Fuente', 'id', 'fuente_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function proceso()
    {
        return $this->hasOne('App\Models\Proceso', 'id', 'proceso_id');
    }

    public function requisito()
    {
        return $this->hasOne('App\Models\Requisito', 'id', 'requisito_id');
    }

    public function analisis()
    {
        return $this->morphOne('App\Models\Analisis', 'analisisable');
    }
    
}
