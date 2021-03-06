<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SintomasCadastro extends Model
{
    protected $fillable = [
        'descricao'
    ];

        public function pacientes()
    {
        return $this->belongsToMany('App\Paciente');
    }
}
