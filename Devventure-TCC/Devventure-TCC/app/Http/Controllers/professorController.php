<?php

namespace App\Http\Controllers;
use App\Models\alunoModel;
use App\Models\Convite;
use App\Models\professorModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\turmaModel;
use App\Models\exercicioModel;
use Carbon\Carbon;
class professorController extends Controller
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

    public function turma(Request $request){
        $turma = new turmaModel();
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
   
    $turmas = turmaModel::where('professor_id', $professorId)
                        ->withCount(['alunos', 'exercicios']) 
                        ->get();

    return view('turmaProfessor', ['turmas' => $turmas]);
}

public function turmaEspecifica(Request $request)
{
    
    $professorId = Auth::guard('professor')->id();
    
  
    $searchTerm = $request->input('search');

    
    $query = turmaModel::where('professor_id', $professorId);

    
    if ($searchTerm) {
        $query->where('nome_turma', 'like', '%' . $searchTerm . '%');
    }

    $turmas = $query->get();

    return view('turmaProfessor', ['turmas' => $turmas]);
}

public function turmaEspecificaID(turmaModel $turma)
    {
      $alunosNaTurma = $turma->alunos()->get();
    $exerciciosDaTurma = $turma->exercicios()->get();

    

    return view('detalheTurma', [
        'turma' => $turma,
        'alunos' => $alunosNaTurma,
        'exercicios' => $exerciciosDaTurma,
    ]);
}


public function convidarAluno(Request $request, turmaModel $turma)
{
    // 1. Valida se o RA foi enviado e se existe um aluno com esse RA
    $request->validate([
        'ra' => 'required|exists:aluno,ra'
    ], [
        'ra.exists' => 'Nenhum aluno encontrado com este RA.' 
    ]);

    // 2. Encontra o aluno pelo RA
    $aluno = alunoModel::where('ra', $request->ra)->first();

    // 3. Verifica se o aluno já está na turma
    $jaEstaNaTurma = $turma->alunos()->where('aluno_id', $aluno->id)->exists();
    if ($jaEstaNaTurma) {
        return back()->with('error', 'Este aluno já está na turma.');
    }

    // 4. Verifica se já existe um convite pendente
    $convitePendente = Convite::where('turma_id', $turma->id)
                                ->where('aluno_id', $aluno->id)
                                ->where('status', 'pendente')
                                ->exists();
    if ($convitePendente) {
        return back()->with('error', 'Já existe um convite pendente para este aluno.');
    }

    // 5. Se todas as verificações passarem, cria o convite
    Convite::create([
        'turma_id' => $turma->id,
        'aluno_id' => $aluno->id,
        'professor_id' => Auth::guard('professor')->id(),
        'status' => 'pendente' // Status inicial
    ]);

    return back()->with('success', 'Convite enviado com sucesso!');
}


public function exercicios(Request $request) 
 { 
    
    $professorId = Auth::guard('professor')->id();
    $status = $request->input('status', 'disponiveis');
    $searchTerm = $request->input('search');
    //Pega a data e hora atual
    $agora = Carbon::now();

   
    $query = exercicioModel::with('turma')
                      ->where('professor_id', $professorId);

    if ($status == 'disponiveis') {
        $query->where('data_fechamento', '>', $agora);
    } else {
        $query->where('data_fechamento', '<=', $agora);
    }

    if ($searchTerm) {
        $query->where('nome', 'like', '%' . $searchTerm . '%');
    }

    $exercicios = $query->get();
    
   
    $turmas = turmaModel::where('professor_id', $professorId)->get();
    
    
    return view('exercicioProfessor', [
        'exercicios' => $exercicios,
        'status' => $status,
        'turmas' => $turmas 
    ]);
}

public function CriarExercicios(Request $request)
{
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'turma_id' => 'required|exists:turmas,id', 
            'data_publicacao' => 'required|date',
            'data_fechamento' => 'required|date|after_or_equal:data_publicacao',
            'arquivo' => 'nullable|file|mimes:pdf,doc,docx,zip|max:2048'
        ]);

        $path = null;
        if ($request->hasFile('arquivo')) {
            $path = $request->file('arquivo')->store('exercicios', 'public');
        }

        $exercicio = new exercicioModel();
        $exercicio->nome = $request->nome;
        $exercicio->descricao = $request->descricao;
        $exercicio->data_publicacao = $request->data_publicacao;
        $exercicio->data_fechamento = $request->data_fechamento;
        $exercicio->arquivo_path = $path;
        $exercicio->turma_id = $request->turma_id;
        $exercicio->professor_id = Auth::guard('professor')->id();
        $exercicio->save();

        return redirect()->back()->with('success', 'Exercício criado com sucesso!');
    }
    


public function formsAula(Request $request)
{
    $request->validate([
        'aula_id' => 'required|integer|exists:aulas,id',
        'segundos_assistidos' => 'required|integer|min:0',
    ]);

    $aluno = Auth::guard('aluno')->user();
    
    // Pega o progresso que já existe no banco
    $progressoExistente = $aluno->aulas()->where('aula_id', $request->aula_id)->first();
    $segundosJaSalvos = $progressoExistente ? $progressoExistente->pivot->segundos_assistidos : 0;

    // SÓ ATUALIZA SE O NOVO TEMPO FOR MAIOR QUE O TEMPO JÁ SALVO
    if ($request->segundos_assistidos > $segundosJaSalvos) {
        // Atualiza o progresso na tabela pivot
        $aluno->aulas()->syncWithoutDetaching([
            $request->aula_id => [
                'segundos_assistidos' => $request->segundos_assistidos
            ]
        ]);
        return response()->json(['status' => 'progresso atualizado']);
    }

    return response()->json(['status' => 'progresso não precisou ser atualizado']);
}
        

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $professor = new professorModel();
         $professor->nome = $request->nome;
         $professor->cpf = $request->cpf;
         $professor->areaEnsino = $request->area;
         $professor->formacao = $request->formacao;
         $professor->telefone = $request->telefone;
        $professor->email = $request->email;
        $professor->password = Hash::make($request->password);
        $professor->save();

        return redirect('/loginProfessor');

    }

    public function professorDashboard()    {
        return view('professorDashboard');
    }

   public function verifyUser(Request $request)
{
   if (!Auth::guard('professor')->attempt($request->only(['email', 'password']))) {
    return back()->withErrors(['msg' => 'Credenciais inválidas!']);
}
return redirect('/professorDashboard');
}


    public function logoutUser(Request $request)
    {
        Auth::guard('professor')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/loginProfessor');
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
