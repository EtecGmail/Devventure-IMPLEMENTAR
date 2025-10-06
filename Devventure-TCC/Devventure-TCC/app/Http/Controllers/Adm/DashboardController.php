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

    // Paginação com 5 registros por página
    $alunosData = Aluno::paginate(5);
    $professoresData = Professor::paginate(5);

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


    public function searchAlunos(Request $request)
{
    $query = $request->input('query');

    
    
    $alunos = Aluno::where('nome', 'LIKE', "%{$query}%")
                   ->orWhere('email', 'LIKE', "%{$query}%")
                   ->orWhere('ra', 'LIKE', "%{$query}%")
                   ->get(); 

    
    return response()->json($alunos);
}


public function searchProfessores(Request $request)
{
    $query = $request->input('query');

    $professores = Professor::where('nome', 'LIKE', "%{$query}%")
                            ->orWhere('email', 'LIKE', "%{$query}%")
                            ->orWhere('cpf', 'LIKE', "%{$query}%")
                            ->get();
    
    return response()->json($professores);
}

public function blockAluno(Aluno $aluno)
{
    $aluno->update(['status' => 'bloqueado']);

    
    return redirect(url()->previous() . '#alunos')->with('success', 'Aluno bloqueado com sucesso!');
}

public function unblockAluno(Aluno $aluno)
{
    $aluno->update(['status' => 'ativo']);

    
    return redirect(url()->previous() . '#alunos')->with('success', 'Aluno desbloqueado com sucesso!');
}

public function blockProfessor(Professor $professor)
{
    $professor->update(['status' => 'bloqueado']);

    
    return redirect(url()->previous() . '#professores')->with('success', 'Professor bloqueado com sucesso!');
}

public function unblockProfessor(Professor $professor)
{
    $professor->update(['status' => 'ativo']);

    
    return redirect(url()->previous() . '#professores')->with('success', 'Professor desbloqueado com sucesso!');
}
}
