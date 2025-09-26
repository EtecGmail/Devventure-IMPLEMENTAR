<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\turmaModel;

class Aula extends Model
{
    use HasFactory;

    protected $fillable = ['turma_id', 'titulo', 'video_url', 'duracao_segundos'];

    public function turma()
    {
        return $this->belongsTo(turmaModel::class);
    }
}
