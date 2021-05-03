<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Monitoramento extends Model
{
protected $fillable = [
        'paciente_id', 'febre', 'diabetico', 'glicemia', 'teste', 'resultado', 'historico', 'user_id', 'saude', 'familia', 'quantas', '', 
    ];

    protected $dates = ['created_at'];
}
