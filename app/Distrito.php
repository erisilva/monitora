<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    protected $fillable = [
        'nome', 
    ];

    public function unidades()
    {
        return $this->belongsToMany('App\Unidade');
    }
}
