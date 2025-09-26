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
    
    $request->validate([
        'nome' => ['required', 'string', 'max:255'],
        'ra' => ['required', 'string', 'max:255', 'unique:aluno'], 
        'semestre' => ['required', 'string'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:aluno'],
        'password' => ['required', 'string', 'min:8'],
        'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], 
    ]);

    
    $caminhoAvatar = null;
    if ($request->hasFile('avatar')) {
        
        $caminhoAvatar = $request->file('avatar')->store('avatars', 'public');
    }

    
    $alunoModel = new alunoModel();
    $alunoModel->nome = $request->nome;
    $alunoModel->ra = $request->ra;
    $alunoModel->semestre = $request->semestre;
    $alunoModel->email = $request->email;
    $alunoModel->telefone = $request->telefone;
    $alunoModel->password = Hash::make($request->password);
    
   
    $alunoModel->avatar = $caminhoAvatar;
    
    $alunoModel->save();

    return redirect('/loginAluno')->with('success', 'Cadastro realizado com sucesso!');
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

        // Busca exercícios pendentes
        $exerciciosPendentes = exercicioModel::whereIn('turma_id', $turmasIds)
                                    ->whereNotNull('data_fechamento')
                                    ->where('data_fechamento', '>=', now()) 
                                    ->orderBy('data_fechamento', 'asc')
                                    ->with('turma')
                                    ->take(5)
                                    ->get();

       //Lógica para calcular o progresso do aluno
        
        // 1. Calcula o total de segundos de TODAS as aulas disponíveis para o aluno
        $totalSegundosAulas = Aula::whereIn('turma_id', $turmasIds)->sum('duracao_segundos');
        
        // 2. Calcula o total de segundos que o aluno JÁ ASSISTIU
        $segundosAssistidosPeloAluno = $aluno->aulas()
                                          ->whereIn('turma_id', $turmasIds)
                                          ->sum('segundos_assistidos');
        
        // 3. Calcula a porcentagem com segurança
        $progressoPercentual = 0; 
        if ($totalSegundosAulas > 0) { // Garante que não haverá divisão por zero
            $progressoPercentual = round(($segundosAssistidosPeloAluno / $totalSegundosAulas) * 100);
        }

        // Garante que a porcentagem não passe de 100
        if ($progressoPercentual > 100) {
            $progressoPercentual = 100;
        }

        
        // $ranking = Aluno::orderBy('pontos', 'desc')->take(5)->get();

        
        return view('alunoDashboard', [
            'convites' => $convites,
            'exerciciosPendentes' => $exerciciosPendentes,
            'progressoPercentual' => $progressoPercentual,
            // 'ranking' => $ranking // Comentado por enquanto
        ]);
    
    }
    public function aceitar(Convite $convite)
    {
        
        if ($convite->aluno_id != Auth::guard('aluno')->id()) {
            abort(403);
        }

        
        $convite->turma->alunos()->attach($convite->aluno_id);

        
        $convite->status = 'aceito';
        $convite->save();

        return back()->with('success', 'Você ingressou na turma com sucesso!');
    }

    public function recusar(Convite $convite)
    {
       
        if ($convite->aluno_id != Auth::guard('aluno')->id()) {
            abort(403);
        }

        
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
        
        $alunosDaTurma = $turma->alunos()->orderBy('nome')->get();

        
        $exerciciosDaTurma = $turma->exercicios()->orderBy('data_fechamento', 'desc')->get();

        $aulasDaTurma = $turma->aulas()->orderBy('created_at', 'asc')->get(); 

    
        return view('alunoTurmaEspecifica', [
            'turma' => $turma,
            'alunos' => $alunosDaTurma,
            'exercicios' => $exerciciosDaTurma,
            'aulas' => $aulasDaTurma 
        ]);   
 }

    public function aula(Aula $aula)
{
    // Carrega a aula com a sua turma e o professor da turma
    $aula->load('turma.professor');

    $videoId = null;

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
        'videoId' => $videoId // Passa o ID extraído
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
