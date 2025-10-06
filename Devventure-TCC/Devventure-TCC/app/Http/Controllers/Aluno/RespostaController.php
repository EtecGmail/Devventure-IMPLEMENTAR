<?php

namespace App\Http\Controllers\Aluno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aula;
use App\Models\Formulario;
use App\Models\Resposta;
use Illuminate\Support\Facades\DB;

class RespostaController extends Controller
{
 public function store(Request $request, Aula $aula)
{
    $request->validate([
        'respostas' => 'required|array',
        'respostas.*' => 'required|string',
    ]);

    $aluno = auth('aluno')->user();

    DB::transaction(function () use ($request, $aluno, $aula) {

        
        foreach ($request->respostas as $perguntaId => $textoResposta) {
            Resposta::create([
                'aluno_id' => $aluno->id,
                'pergunta_id' => $perguntaId,
                'texto_resposta' => $textoResposta,
            ]);
        }

        
        $aula->alunos()->syncWithoutDetaching([
            $aluno->id => [
                'status' => 'concluido',
                'segundos_assistidos' => $aula->duracao_segundos ?? 0,
                'concluido_em' => now(),
            ]
        ]);

    });

    return redirect()
        ->route('turmas.especifica', $aula->turma_id)
        ->with('sweet_success', 'Aula concluída e validada com sucesso!');
}

}