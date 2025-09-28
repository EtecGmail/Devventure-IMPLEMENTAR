<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pergunta extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser atribuídos em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'formulario_id',
        'texto_pergunta',
        'tipo_pergunta',
        'opcoes',
    ];

    /**
     * Converte o atributo 'opcoes' de JSON para array automaticamente.
     *
     * @var array
     */
    protected $casts = [
        'opcoes' => 'array',
    ];

    
    public function formulario()
    {
        return $this->belongsTo(Formulario::class);
    }

    
    public function respostas()
    {
        return $this->hasMany(RespostaAluno::class);
    }
}