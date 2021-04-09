<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'name', 'description',
    ];

    /**
     * Perfis dessa permissão
     *
     * @var Role
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }
}
