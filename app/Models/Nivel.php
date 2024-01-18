<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{

    protected $table = "niveles";

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function analisis()
    {
        return $this->hasMany('App\Models\Analisis', 'nivel_id', 'id');
    }
    

}
