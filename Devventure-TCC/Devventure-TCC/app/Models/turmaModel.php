<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\alunoModel;
use App\Models\exercicioModel;
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

     public function exercicios()
    {
        // A chave estrangeira na tabela 'exercicios' que liga a esta turma é 'turma_id'.
        return $this->hasMany(exercicioModel::class, 'turma_id');
    }

  public function alunos()
{
    
    return $this->belongsToMany(alunoModel::class, 'aluno_turma', 'turma_id', 'aluno_id');
}

public function professor() {
    return $this->belongsTo(professorModel::class);
}
}
