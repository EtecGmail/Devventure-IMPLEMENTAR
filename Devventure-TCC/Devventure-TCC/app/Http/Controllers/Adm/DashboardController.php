<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aluno;
use App\Models\Professor;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function admDashboard()
    {
        $alunosCount = Aluno::count();
        $professoresCount = Professor::count();
        $alunosData = Aluno::all();
        $professoresData = Professor::all();

        return view('Adm/dashboard', compact('alunosCount', 'professoresCount', 'alunosData', 'professoresData'));
    }

   

    public function countUsers()
    {
        $professores = Professor::where('role', 'professor')->count();
        $alunos = Aluno::where('role', 'aluno')->count();

        return response()->json([
            'professores' => $professores,
            'alunos' => $alunos,
        ]);
    }
}
