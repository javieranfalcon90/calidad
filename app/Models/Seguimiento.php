<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class Seguimiento extends Model
{
    
    public $table = 'seguimientos';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['seguimiento','fecha','evidencia','accion_id', 'user_id'];

    protected function fecha(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => (($value) ? (new Carbon($value))->format('d-m-Y'): ''),
            set: fn ($value) => (($value) ? (new Carbon($value)) : null),
        );
    }

    protected function fechaproximoseguimiento(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => (($value) ? (new Carbon($value))->format('d-m-Y'): ''),
            set: fn ($value) => (($value) ? (new Carbon($value)) : null),
        );
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function accion()
    {
        return $this->belongsTo('App\Models\Accion');
    }

}
