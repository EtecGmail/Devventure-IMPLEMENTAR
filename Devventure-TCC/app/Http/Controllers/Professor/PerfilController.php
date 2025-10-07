<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Professor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class PerfilController extends Controller
{
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

    
    $professor = new Professor();
    $professor->nome = $request->nome;
    $professor->cpf = $request->cpf;
    $professor->areaEnsino = $request->area; 
    $professor->formacao = $request->formacao;
    $professor->telefone = $request->telefone;
    $professor->email = $request->email;
    $professor->password = Hash::make($request->password);
    
   
    $professor->avatar = $caminhoAvatar;
    
    $professor->save();

    return redirect('/loginProfessor')->with('cadastro_sucesso', 'Cadastro realizado com sucesso!');
}

  public function edit()
    {
        
        $professor = Auth::guard('professor')->user();
        return view('Professor/Perfil', compact('professor'));
    }


    public function update(Request $request)
    {
        $professor = Auth::guard('professor')->user();

        $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('professor')->ignore($professor->id)],
            'cpf' => ['required', 'string', 'max:14', Rule::unique('professor')->ignore($professor->id)], 
            'areaEnsino' => ['required', 'string', 'max:255'],
            'formacao' => ['required', 'string'],
            'telefone' => ['nullable', 'string', 'max:15'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $professor->nome = $request->input('nome');
        $professor->email = $request->input('email');
        $professor->cpf = $request->input('cpf'); 
        $professor->areaEnsino = $request->input('areaEnsino');
        $professor->formacao = $request->input('formacao'); 
        $professor->telefone = $request->input('telefone');

        
        if ($request->hasFile('avatar')) {
            
            if ($professor->avatar && Storage::disk('public')->exists($professor->avatar)) {
                Storage::disk('public')->delete($professor->avatar);
            }
            $path = $request->file('avatar')->store('avatars/professores', 'public');
            $professor->avatar = $path;
        }

        
        if ($request->filled('password')) {
            $professor->password = Hash::make($request->input('password'));
        }

        $professor->save();

        
        return redirect()->route('professor.perfil.edit')->with('sweet_success', 'Seu perfil foi atualizado com sucesso!');
    }


}
