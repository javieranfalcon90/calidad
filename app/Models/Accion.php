<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Accion extends Model
{
    
    public $table = 'acciones';

    protected $fillable = ['accion','tipo_id', 'responsable_id', 'cumplimiento', 'fechacumplimiento','fechacierre','recurso','estado', 'accionable_id','accionable_type'];

    protected function fechacumplimiento(): Attribute
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

    public function accionable() : MorphTo
    {
        return $this->morphTo();
    }

    public function tipo()
    {
        return $this->hasOne('App\Models\Tipo', 'id', 'tipo_id');
    }
    
    public function responsable()
    {
        return $this->hasOne('App\Models\Responsable', 'id', 'responsable_id');
    }

    public function seguimientos()
    {
        return $this->hasMany('App\Models\Seguimiento');
    }

}
