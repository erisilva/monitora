<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paciente extends Model
{
	use SoftDeletes;

    protected $fillable = [
        'nome', 'nomeMae', 'nascimento', 'cns', 'idade', 'cep', 'logradouro', 'bairro', 'numero', 'complemento', 'cidade', 'uf', 'cel1', 'cel2', 'email', 'unidade_id', 'ultimoMonitoramento', 'tomouVacina',  'inicioSintomas', 'monitorando', 'user_id', 'notas',
    ];

    protected $dates = ['nascimento', 'ultimoMonitoramento', 'inicioSintomas', 'created_at', 'deleted_at'];

    public function comorbidades()
    {
        return $this->belongsToMany('App\Comorbidade');
    }

    public function sintomasCadastros()
    {
        return $this->belongsToMany('App\SintomasCadastro');
    }

    public function doencasBases()
    {
        return $this->belongsToMany('App\DoencasBase');
    }

    public function unidade()
    {
        return $this->belongsTo('App\Unidade');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function monitoramento()
    {
        return $this->belongsTo('App\Monitoramento');
    }
}
