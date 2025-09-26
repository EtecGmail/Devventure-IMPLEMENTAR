<?php

namespace App\Models;

use App\Http\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\turmaModel;

class alunoModel extends Authenticatable
{
    use HasFactory;
    protected $table = 'aluno';
    protected $fillable = ['nome', 'ra', 'semestre', 'email', 'telefone', 'password'];

   public function turmas()
{
    
    return $this->belongsToMany(TurmaModel::class, 'aluno_turma', 'aluno_id', 'turma_id');
}
public function aulas() {
    return $this->belongsToMany(Aula::class, 'aluno_aula', 'aluno_id', 'aula_id')
                ->withPivot('segundos_assistidos', 'status')
                ->withTimestamps();
}

}
