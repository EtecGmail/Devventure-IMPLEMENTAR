<?php

namespace App\Http\Controllers\Aluno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aluno;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class PerfilController extends Controller
{
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

    
    $Aluno = new Aluno();
    $Aluno->nome = $request->nome;
    $Aluno->ra = $request->ra;
    $Aluno->semestre = $request->semestre;
    $Aluno->email = $request->email;
    $Aluno->telefone = $request->telefone;
    $Aluno->password = Hash::make($request->password);
    
   
    $Aluno->avatar = $caminhoAvatar;
    
    $Aluno->save();

    return redirect('/loginAluno')->with('cadastro_sucesso', 'Cadastro realizado com sucesso!');
}

      public function edit()
    {
        
        $aluno = Auth::guard('aluno')->user();

        
        return view('Aluno/perfil', ['aluno' => $aluno]);
    }

      public function update(Request $request)
    {
        $aluno = Auth::guard('aluno')->user();

        
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('aluno')->ignore($aluno->id), 
            ],
            'telefone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'password' => 'nullable|string|min:8|confirmed', 
        ]);

        
        if ($request->hasFile('avatar')) {
            
            $path = $request->file('avatar')->store('avatars/alunos', 'public');
            
            $validatedData['avatar'] = $path;
        }

       
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            
            unset($validatedData['password']);
        }

        
        $aluno->update($validatedData);

        
        return redirect()->route('aluno.perfil.edit')->with('sweet_success', 'Suas alterações foram salvas com sucesso!');
    }

}
