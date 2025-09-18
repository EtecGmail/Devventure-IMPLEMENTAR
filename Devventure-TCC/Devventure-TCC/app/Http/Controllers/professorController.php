<?php

namespace App\Http\Controllers;
use App\Models\professorModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\turmaModel;

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

    $turmas = turmaModel::where('professor_id', $professorId)->get();

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
