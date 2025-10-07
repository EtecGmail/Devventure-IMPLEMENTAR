<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Turma;
use App\Models\Aluno;


class Convite extends Model
{
    use HasFactory;

    // Permite a criação em massa dos convites
    protected $fillable = [
        'turma_id',
        'aluno_id',
        'professor_id',
        'status',
    ];

    // Relação: Um convite pertence a uma Turma
    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    // Relação: Um convite pertence a um Aluno
    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }
}