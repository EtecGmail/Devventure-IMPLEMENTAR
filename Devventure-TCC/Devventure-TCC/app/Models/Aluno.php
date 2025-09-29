<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Aluno extends Authenticatable
{
    use HasFactory;
    
    /**
     * O nome da tabela associada ao model.
     *
     * @var string
     */
    protected $table = 'aluno';

    /**
     * Os atributos que podem ser atribuídos em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'ra',
        'semestre',
        'email',
        'telefone',
        'password',
        'avatar',
        'status',
    ];

    public function turmas()
    {
        return $this->belongsToMany(Turma::class, 'aluno_turma');
    }

    
    public function aulas()
{
    
      return $this->belongsToMany(Aula::class, 'aula_aluno')
                ->withPivot('segundos_assistidos', 'status', 'concluido_em')
                ->withTimestamps();
}
    
    
    public function respostas()
    {
        return $this->hasMany(RespostaAluno::class);
    }
}