<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class professorModel extends Authenticatable
{
    use HasFactory;
    protected $table = 'professor';
    protected $fillable = [
        'nome',
        'cpf',
        'areaEnsino',
        'formacao',
        'telefone',
        'email',
        'password',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

     public function turmas()
    {
        return $this->hasMany(turmaModel::class, 'professor_id');
    }
}
