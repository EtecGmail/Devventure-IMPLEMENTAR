<?php

namespace App\Http\Controllers\Aluno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Convite;
use Illuminate\Support\Facades\Auth;
use App\Models\Turma;
use App\Models\Aluno;

class ConviteController extends Controller
{
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
}
