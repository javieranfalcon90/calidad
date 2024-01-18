<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Requisito extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $table = 'requisitos';

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
        return $this->hasMany('App\Models\Noconformidad', 'fuente_id', 'id');
    }
}
