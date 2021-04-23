<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    protected $fillable = [
        'descricao', 'distrito_id'
    ];

    public function distrito()
    {
        return $this->belongsTo('App\Distrito');
    }


    public function pacientes()
    {
        return $this->belongsToMany('App\Paciente');
    }
}
