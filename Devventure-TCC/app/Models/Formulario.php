<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Aula;
use App\Models\Pergunta;

class Formulario extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser atribuídos em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'aula_id',
        'titulo',
    ];

    
    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }

    
    public function perguntas()
    {
        return $this->hasMany(Pergunta::class);
    }
}