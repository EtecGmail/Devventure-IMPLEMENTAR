<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exercicio;
use App\Models\Turma;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class ExercicioController extends Controller
{
    public function exercicios(Request $request) 
 { 
    
    $professorId = Auth::guard('professor')->id();
    $status = $request->input('status', 'disponiveis');
    $searchTerm = $request->input('search');
    //Pega a data e hora atual
    $agora = Carbon::now();

   
    $query = Exercicio::with('turma')
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
    
   
    $turmas = Turma::where('professor_id', $professorId)->get();
    
    
    return view('Professor/Exercicio', [
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
            'arquivo' => 'nullable|file|mimes:pdf,doc,docx,zip,jpeg,png,jpg|max:2048'
        ]);

        $path = null;
        if ($request->hasFile('arquivo')) {
            $path = $request->file('arquivo')->store('exercicios', 'public');
        }

        $exercicio = new Exercicio();
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
    

}
