<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Professor extends Authenticatable
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
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

     public function turmas()
    {
        return $this->hasMany(Turma::class, 'professor_id');
    }
}
