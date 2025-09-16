<?php

namespace App\Models;

use App\Http\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class alunoModel extends Authenticatable
{
    use HasFactory;
    protected $table = 'aluno';
    protected $fillable = ['nome', 'ra', 'semestre', 'email', 'telefone', 'password'];
}
