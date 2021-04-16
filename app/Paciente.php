<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
	use SoftDeletes;

    protected $fillable = [
        'nome', 'nomeMae', 'nascimento', 'cns', 'idade', 'cep', 'logradouro', 'bairro', 'numero', 'complemento', 'cidade', 'uf', 'cel1', 'cel2', 'unidade_id', 'ultimoMonitoramento', 'tomouVacina',  'inicioSintomas', 'monitorando', 'user_id',
    ];

    protected $dates = ['nascimento', 'ultimoMonitoramento', 'created_at', 'deleted_at'];
}
