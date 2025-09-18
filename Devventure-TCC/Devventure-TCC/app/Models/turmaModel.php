<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class turmaModel extends Model
{
    use HasFactory;
    protected $table = 'turmas';
    protected $fillable = [ 
        'nome_turma',
        'turno',
        'ano_turma',
        'data_inicio',
        'data_fim',
        'professor_id'
    ];
}
