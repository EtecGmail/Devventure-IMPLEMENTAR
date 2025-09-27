<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aluno;
use App\Models\Aula;
use App\Models\Turma;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
     public function dashboard()
    {
        $professor = Auth::guard('professor')->user();

        //Buscar as turmas do professor com a contagem de alunos
        $turmas = $professor->turmas()->withCount('alunos')->latest()->take(5)->get();

        //Buscar as últimas aulas criadas pelo professor
        $aulasRecentes = Aula::whereIn('turma_id', $professor->turmas()->pluck('id'))
                            ->latest()
                            ->take(3)
                            ->get();

        //Calcular estatísticas gerais
        $totalAlunos = Aluno::whereHas('turmas', function ($query) use ($professor) {
            $query->where('professor_id', $professor->id);
        })->count();
        
        $totalAulas = Aula::whereIn('turma_id', $professor->turmas()->pluck('id'))->count();

        return view('Professor/dashboard', [
            'turmasRecentes' => $turmas,
            'aulasRecentes' => $aulasRecentes,
            'totalAlunos' => $totalAlunos,
            'totalAulas' => $totalAulas,
        ]);
    }

}
