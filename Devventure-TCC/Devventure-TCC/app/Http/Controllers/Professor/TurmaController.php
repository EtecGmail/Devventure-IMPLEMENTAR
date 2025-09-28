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
   
    $request->validate([
        'ra' => 'required|exists:aluno,ra'
    ], [
        'ra.exists' => 'Nenhum aluno encontrado com este RA.' 
    ]);

    
    $aluno = Aluno::where('ra', $request->ra)->first();

    
    $jaEstaNaTurma = $turma->alunos()->where('aluno_id', $aluno->id)->exists();
    if ($jaEstaNaTurma) {
        
        return back()->with('sweet_error_convite', 'O aluno já está em outra turma.'); 
    }

    
    $convitePendente = Convite::where('turma_id', $turma->id)
                                 ->where('aluno_id', $aluno->id)
                                 ->where('status', 'pendente')
                                 ->exists();
    if ($convitePendente) {
        
        return back()->with('sweet_success_convite', 'Convite já existe e está pendente.'); 
    }

    
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
        'titulo' => ['required', 'string', 'max:255'],
        'video_url' => ['required', 'url'],
        // Validação com Regex para o formato 'minutos,segundos' ou 'minutos.segundos'
        'duracao_texto' => ['required', 'string', 'regex:/^\d+([,.]\d{1,2})?$/'],
    ]);

    

    
    $duracaoInput = $request->duracao_texto;

    // Garante que o separador seja sempre um ponto
    $duracaoInput = str_replace(',', '.', $duracaoInput);

    // Separa o valor em duas partes pelo ponto.
    $partes = explode('.', $duracaoInput);

    // A primeira parte são sempre os minutos.
    $minutos = (int) $partes[0];

    // A segunda parte (se existir) são os segundos. Se não, é 0.
    $segundos = isset($partes[1]) ? (int) $partes[1] : 0;
    
    
    if ($segundos >= 60) {
        
        return back()->withErrors(['duracao_texto' => 'Os segundos não podem ser 60 ou mais.'])->withInput();
    }

    $totalEmSegundos = ($minutos * 60) + $segundos;

   

    $aula = new Aula();
    $aula->turma_id = $turma->id;
    $aula->titulo = $request->titulo;
    $aula->video_url = $request->video_url;
    $aula->duracao_segundos = $totalEmSegundos; 
    $aula->save();

    $urlCriarFormulario = route('formularios.create', $aula);

    
    $feedback = [
        'message' => 'Aula adicionada com sucesso!',
        'next_action_url' => $urlCriarFormulario,
        'next_action_text' => 'Criar Formulário de Validação',
    ];

  

    
    return redirect()->route('turmas.especificaID', $turma->id)
                     ->with('aula_criada_feedback', $feedback);
}

}
