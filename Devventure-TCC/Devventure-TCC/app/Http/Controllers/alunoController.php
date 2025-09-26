<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Aula;
use App\Models\exercicioModel;
use App\Models\turmaModel;
use Illuminate\Http\Request;
use App\Models\alunoModel;
use App\Models\Convite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class alunoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $alunoModel = new alunoModel();
        $alunoModel->nome = $request->nome;
        $alunoModel->ra = $request->ra;
        $alunoModel->semestre = $request->semestre;
        $alunoModel->email = $request->email;
        $alunoModel->telefone = $request->telefone;
        $alunoModel->password = Hash::make($request->password);
        $alunoModel->save();

        return redirect('/loginAluno');
     
    }

     public function alunoDashboard()    {
        return view('alunoDashboard');
    }

   public function verifyUser(Request $request)
{
   if (!Auth::guard('aluno')->attempt($request->only(['email', 'password']))) {
    return back()->withErrors(['msg' => 'Credenciais inválidas!']);
}
return redirect('/alunoDashboard');
}


    public function logoutUser(Request $request)
    {
        Auth::guard('aluno')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/loginAluno');
    }

     public function alunoConvite() 
    {
           $aluno = Auth::guard('aluno')->user();
        $convites = Convite::where('aluno_id', $aluno->id)->where('status', 'pendente')->get();

        // Pega os IDs de todas as turmas em que o aluno está matriculado
        $turmasIds = $aluno->turmas()->pluck('id');

        // Busca exercícios pendentes (lógica que você já tem)
        $exerciciosPendentes = exercicioModel::whereIn('turma_id', $turmasIds)
                                    ->whereNotNull('data_fechamento')
                                    ->where('data_fechamento', '>=', now()) 
                                    ->orderBy('data_fechamento', 'asc')
                                    ->with('turma')
                                    ->take(5)
                                    ->get();

        // =======================================================
        // ========= LÓGICA CORRIGIDA E COMPLETA DO PROGRESSO ==========
        // =======================================================
        
        // 1. Calcula o total de segundos de TODAS as aulas disponíveis para o aluno
        $totalSegundosAulas = Aula::whereIn('turma_id', $turmasIds)->sum('duracao_segundos');
        
        // 2. Calcula o total de segundos que o aluno JÁ ASSISTIU
        $segundosAssistidosPeloAluno = $aluno->aulas()
                                          ->whereIn('turma_id', $turmasIds)
                                          ->sum('segundos_assistidos');
        
        // 3. Calcula a porcentagem com segurança
        $progressoPercentual = 0; // Inicia com 0 por padrão
        if ($totalSegundosAulas > 0) { // Garante que não haverá divisão por zero
            $progressoPercentual = round(($segundosAssistidosPeloAluno / $totalSegundosAulas) * 100);
        }

        // Garante que a porcentagem não passe de 100
        if ($progressoPercentual > 100) {
            $progressoPercentual = 100;
        }

        // Deixando o ranking estático como solicitado
        // $ranking = Aluno::orderBy('pontos', 'desc')->take(5)->get();

        // 5. Envia tudo para a view
        return view('alunoDashboard', [
            'convites' => $convites,
            'exerciciosPendentes' => $exerciciosPendentes,
            'progressoPercentual' => $progressoPercentual,
            // 'ranking' => $ranking // Comentado por enquanto
        ]);
    
    }
    public function aceitar(Convite $convite)
    {
        // Garante que o aluno logado é o mesmo do convite (Segurança)
        if ($convite->aluno_id != Auth::guard('aluno')->id()) {
            abort(403);
        }

        // 1. Adiciona o aluno à turma (cria o registro na tabela aluno_turma)
        $convite->turma->alunos()->attach($convite->aluno_id);

        // 2. Atualiza o status do convite
        $convite->status = 'aceito';
        $convite->save();

        return back()->with('success', 'Você ingressou na turma com sucesso!');
    }

    public function recusar(Convite $convite)
    {
       
        if ($convite->aluno_id != Auth::guard('aluno')->id()) {
            abort(403);
        }

        // Apenas atualiza o status do convite
        $convite->status = 'recusado';
        $convite->save();

        return back()->with('success', 'Convite recusado.');
    }

    public function minhasTurmas()
    {
        
        $aluno = Auth::guard('aluno')->user();

        
        $turmas = $aluno->turmas()->get();

        
        return view('alunoTurma', ['turmas' => $turmas]);
    }

     public function mostrarTurmaEspecifica(turmaModel $turma)
    {
        // Carrega os alunos relacionados com esta turma (você já tem isso)
        $alunosDaTurma = $turma->alunos()->orderBy('nome')->get();

        // Carrega os exercícios relacionados com esta turma (você já tem isso)
        $exerciciosDaTurma = $turma->exercicios()->orderBy('data_fechamento', 'desc')->get();

        // =======================================================
        // ========= NOVA LÓGICA PARA BUSCAR AS AULAS ============
        // =======================================================
        $aulasDaTurma = $turma->aulas()->orderBy('created_at', 'asc')->get(); // Ordena da mais antiga para a mais nova
        // =======================================================

        // Retorna a view, agora também com a variável $aulas
        return view('alunoTurmaEspecifica', [
            'turma' => $turma,
            'alunos' => $alunosDaTurma,
            'exercicios' => $exerciciosDaTurma,
            'aulas' => $aulasDaTurma 
        ]);   
 }

    public function aula(Aula $aula)
{
     $videoId = null; // Inicia a variável como nula por segurança

    if ($aula->video_url) {
        // Nova lógica robusta para extrair o ID do vídeo de qualquer formato de URL do YouTube
        $regex = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';

        if (preg_match($regex, $aula->video_url, $match)) {
            $videoId = $match[1];
        }
    }

    // Associa o aluno à aula na tabela pivot se for o primeiro acesso
    Auth::guard('aluno')->user()->aulas()->syncWithoutDetaching($aula->id);

    return view('verAulas', [
        'aula' => $aula,
        'videoId' => $videoId // Passa o ID extraído (ou null se não encontrou)
    ]);
}

public function salvarProgresso(Request $request)
{
    $aluno = Auth::guard('aluno')->user();

    // syncWithoutDetaching anexa se não existir, e atualiza se já existir
    $aluno->aulas()->syncWithoutDetaching([
        $request->aula_id => [
            'segundos_assistidos' => $request->segundos_assistidos
        ]
    ]);

    return response()->json(['status' => 'sucesso']);
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
