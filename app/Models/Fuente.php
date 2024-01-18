<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Fuente extends Model implements Auditable
{
    
    use \OwenIt\Auditing\Auditable;

    public $table = 'fuentes';

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
