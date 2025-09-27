<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Turma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Aluno;
use App\Models\Convite;
use App\Models\Aula;
class TurmaController extends Controller
{
   public function turma(Request $request){
        $turma = new Turma();
        $turma->nome_turma = $request->nome_turma;
        $turma->turno = $request->turno;
        $turma->ano_turma = $request->ano_turma;
        $turma->data_inicio = $request->data_inicio;
        $turma->data_fim = $request->data_fim;
        $turma->professor_id = Auth::guard('professor')->id();
        $turma->save();

        return redirect('/professorGerenciar');
    }

      public function GerenciarTurma() 
{
   $professorId = Auth::guard('professor')->id();
   
    $turmas = Turma::where('professor_id', $professorId)
                        ->withCount(['alunos', 'exercicios']) 
                        ->get();

    return view('Professor/turma', ['turmas' => $turmas]);
}

public function turmaEspecifica(Request $request)
{
    
    $professorId = Auth::guard('professor')->id();
    
  
    $searchTerm = $request->input('search');

    
    $query = Turma::where('professor_id', $professorId);

    
    if ($searchTerm) {
        $query->where('nome_turma', 'like', '%' . $searchTerm . '%');
    }

    $turmas = $query->get();

    return view('Professor/turma', ['turmas' => $turmas]);
}

public function turmaEspecificaID(Turma $turma)
    {
      $alunosNaTurma = $turma->alunos()->get();
    $exerciciosDaTurma = $turma->exercicios()->get();

    

    return view('Professor/detalheTurma', [
        'turma' => $turma,
        'alunos' => $alunosNaTurma,
        'exercicios' => $exerciciosDaTurma,
    ]);
}

public function convidarAluno(Request $request, Turma $turma)
{
    // 1. Valida se o RA foi enviado e se existe um aluno com esse RA
    $request->validate([
        'ra' => 'required|exists:aluno,ra'
    ], [
        'ra.exists' => 'Nenhum aluno encontrado com este RA.' 
    ]);

    // 2. Encontra o aluno pelo RA
    $aluno = Aluno::where('ra', $request->ra)->first();

    // 3. Verifica se o aluno já está na turma
    $jaEstaNaTurma = $turma->alunos()->where('aluno_id', $aluno->id)->exists();
    if ($jaEstaNaTurma) {
        
        return back()->with('sweet_error_convite', 'O aluno já está em outra turma.'); 
    }

    // 4. Verifica se já existe um convite pendente
    $convitePendente = Convite::where('turma_id', $turma->id)
                                 ->where('aluno_id', $aluno->id)
                                 ->where('status', 'pendente')
                                 ->exists();
    if ($convitePendente) {
        
        return back()->with('sweet_success_convite', 'Convite já existe e está pendente.'); 
    }

    // 5. Se todas as verificações passarem, cria o convite
    Convite::create([
        'turma_id' => $turma->id,
        'aluno_id' => $aluno->id,
        'professor_id' => Auth::guard('professor')->id(),
        'status' => 'pendente' 
    ]);

    
    return back()->with('sweet_success_convite', 'Convite enviado com sucesso!'); 
}


public function formsAula(Request $request, Turma $turma)
{
    $request->validate([
        'titulo' => 'required|string|max:255',
        'video_url' => 'required|url',
        'duracao_segundos' => 'required|integer|min:1',
    ]);

    $turma->aulas()->create($request->all());

    return back()->with('sweet_success_aula', 'Aula adicionada com sucesso!');
}

}
