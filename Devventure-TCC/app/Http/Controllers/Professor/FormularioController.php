<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aula;
use App\Models\Formulario;

class FormularioController extends Controller
{
    public function create(Aula $aula)
    {
        
        return view('Professor.formValidacaoAula', compact('aula'));
    }

    public function store(Request $request, Aula $aula)
{
    
    $dadosValidados = $request->validate([
        'titulo' => 'required|string|max:255',
        'perguntas' => 'required|array|min:1',
        'perguntas.*' => 'required|string|max:1000', 
    ]);

    
    $formulario = $aula->formulario()->create([
        'titulo' => $dadosValidados['titulo'],
    ]);

    
    foreach ($dadosValidados['perguntas'] as $textoDaPergunta) {
        $formulario->perguntas()->create([
            'texto_pergunta' => $textoDaPergunta,
            'tipo_pergunta' => 'texto_curto', 
        ]);
    }

   
    return redirect()->route('turmas.especificaID', $aula->turma_id)
                     ->with('formulario_criado_success', 'Formulário de validação criado com sucesso!');
}
}
