<?php

namespace App\Http\Controllers\Aluno;

use App\Http\Controllers\Controller;
use App\Models\Aula;
use App\Models\Convite;
use App\Models\Exercicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Exibe a dashboard do aluno.
     */
    public function __invoke(Request $request)
    {
        
        $aluno = Auth::guard('aluno')->user();
        $convites = Convite::where('aluno_id', $aluno->id)->where('status', 'pendente')->get();

        $turmasIds = $aluno->turmas()->pluck('id');

        $exerciciosPendentes = Exercicio::whereIn('turma_id', $turmasIds)
                                        ->whereNotNull('data_fechamento')
                                        ->where('data_fechamento', '>=', now())
                                        ->orderBy('data_fechamento', 'asc')
                                        ->with('turma')
                                        ->take(5)
                                        ->get();

        $totalSegundosAulas = Aula::whereIn('turma_id', $turmasIds)->sum('duracao_segundos');
        $segundosAssistidosPeloAluno = $aluno->aulas()
                                            ->whereIn('turma_id', $turmasIds)
                                            ->sum('segundos_assistidos');

        $progressoPercentual = 0;
        if ($totalSegundosAulas > 0) {
            $progressoPercentual = round(($segundosAssistidosPeloAluno / $totalSegundosAulas) * 100);
        }

        if ($progressoPercentual > 100) {
            $progressoPercentual = 100;
        }

        
        return view('Aluno.dashboard', [
            'convites' => $convites,
            'exerciciosPendentes' => $exerciciosPendentes,
            'progressoPercentual' => $progressoPercentual,
        ]);
    }
}