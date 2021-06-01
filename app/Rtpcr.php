<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rtpcr extends Model
{
    protected $fillable = [
        'descricao'
    ];

    public function pacientes()
    {
        return $this->belongsToMany('App\Paciente');
    }

    public function monitoramentos()
    {
        return $this->belongsToMany('App\Monitoramento');
    }   
}
