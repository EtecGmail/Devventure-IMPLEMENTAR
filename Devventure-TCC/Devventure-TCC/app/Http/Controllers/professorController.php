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
use App\Models\Aula;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
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

    public function dashboard()
    {
        $professor = Auth::guard('professor')->user();

        // 1. Buscar as turmas do professor com a contagem de alunos
        $turmas = $professor->turmas()->withCount('alunos')->latest()->take(5)->get();

        // 2. Buscar as últimas aulas criadas pelo professor
        $aulasRecentes = Aula::whereIn('turma_id', $professor->turmas()->pluck('id'))
                            ->latest()
                            ->take(3)
                            ->get();

        // 3. Calcular estatísticas gerais
        $totalAlunos = alunoModel::whereHas('turmas', function ($query) use ($professor) {
            $query->where('professor_id', $professor->id);
        })->count();
        
        $totalAulas = Aula::whereIn('turma_id', $professor->turmas()->pluck('id'))->count();

        return view('professorDashboard', [
            'turmasRecentes' => $turmas,
            'aulasRecentes' => $aulasRecentes,
            'totalAlunos' => $totalAlunos,
            'totalAulas' => $totalAulas,
        ]);
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
        'status' => 'pendente' 
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
    


public function formsAula(Request $request, turmaModel $turma)
{
    $request->validate([
        'titulo' => 'required|string|max:255',
        'video_url' => 'required|url',
        'duracao_segundos' => 'required|integer|min:1',
    ]);

    $turma->aulas()->create($request->all());

    return back()->with('success', 'Aula adicionada com sucesso!');
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
        'cpf' => ['required', 'string', 'max:14', 'unique:professor'], 
        'area' => ['required', 'string', 'max:255'],
        'formacao' => ['required', 'string'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:professor'],
        'password' => ['required', 'string', 'min:8'],
        'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], 
    ]);

    
    $caminhoAvatar = null;
    if ($request->hasFile('avatar')) {
        
        $caminhoAvatar = $request->file('avatar')->store('avatars', 'public');
    }

    
    $professor = new professorModel();
    $professor->nome = $request->nome;
    $professor->cpf = $request->cpf;
    $professor->areaEnsino = $request->area; 
    $professor->formacao = $request->formacao;
    $professor->telefone = $request->telefone;
    $professor->email = $request->email;
    $professor->password = Hash::make($request->password);
    
   
    $professor->avatar = $caminhoAvatar;
    
    $professor->save();

    return redirect('/loginProfessor')->with('success', 'Cadastro realizado com sucesso!');
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
