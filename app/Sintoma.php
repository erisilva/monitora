<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sintoma extends Model
{
    protected $fillable = [
        'descricao'
    ];

    public function monitoramentos()
    {
        return $this->belongsToMany('App\Monitoramento');
    }

}
