<?php

namespace App\Http\Controllers\Aluno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Turma;
use Illuminate\Support\Facades\Auth; 


class TurmaController extends Controller
{
    
      public function minhasTurmas()
    {
        
        $aluno = Auth::guard('aluno')->user();

        
        $turmas = $aluno->turmas()->get();

        
        return view('Aluno/turma', ['turmas' => $turmas]);
    }

     public function mostrarTurmaEspecifica(Turma $turma)
    {
        
        $alunosDaTurma = $turma->alunos()->orderBy('nome')->get();

        
        $exerciciosDaTurma = $turma->exercicios()->orderBy('data_fechamento', 'desc')->get();

        $aulasDaTurma = $turma->aulas()->orderBy('created_at', 'asc')->get(); 

    
        return view('Aluno/turmaEspecifica', [
            'turma' => $turma,
            'alunos' => $alunosDaTurma,
            'exercicios' => $exerciciosDaTurma,
            'aulas' => $aulasDaTurma 
        ]);   
 }
}
