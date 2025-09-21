<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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

          $turmasIds = $aluno->turmas()->pluck('id');

          
 $exerciciosPendentes = exercicioModel::whereIn('turma_id', $turmasIds)
                                ->whereNotNull('data_fechamento')
                                ->where('data_fechamento', '>=', now())  
                                ->orderBy('data_fechamento', 'asc')    
                                ->with('turma')
                                ->take(5)
                                ->get();
    
    
    return view('alunoDashboard', [
        'convites' => $convites,
        'exerciciosPendentes' => $exerciciosPendentes
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
        // Carrega os alunos relacionados com esta turma
        $alunosDaTurma = $turma->alunos()->orderBy('nome')->get();

        // Carrega os exercícios relacionados com esta turma
        $exerciciosDaTurma = $turma->exercicios()->orderBy('data_fechamento', 'desc')->get();

        // Retorna a nova view com os dados da turma, alunos e exercícios
        return view('alunoTurmaEspecifica', [
            'turma' => $turma,
            'alunos' => $alunosDaTurma,
            'exercicios' => $exerciciosDaTurma
        ]);
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
