<?php

namespace App\Http\Controllers\Aluno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aula;
use Illuminate\Support\Facades\Auth;
use App\Models\Aluno;
use App\Models\Turma;
class AulaController extends Controller
{
     public function aula(Aula $aula)
{
    // Carrega a aula com a turma e o professor relacionados
    $aula->load('turma.professor');

    $videoId = null;

    if ($aula->video_url) {
        // Nova lógica robusta para extrair o ID do vídeo de qualquer formato de URL do YouTube
        $regex = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';

        if (preg_match($regex, $aula->video_url, $match)) {
            $videoId = $match[1];
        }
    }

    // Marca a aula como assistida para o aluno autenticado, se ainda não estiver marcada
    Auth::guard('aluno')->user()->aulas()->syncWithoutDetaching($aula->id);

    return view('Aluno/verAulas', [
        'aula' => $aula,
        'videoId' => $videoId 
    ]);
}

public function salvarProgresso(Request $request)
{
    $aluno = Auth::guard('aluno')->user();

   
    $aluno->aulas()->syncWithoutDetaching([
        $request->aula_id => [
            'segundos_assistidos' => $request->segundos_assistidos
        ]
    ]);

    return response()->json(['status' => 'sucesso']);
}

}
