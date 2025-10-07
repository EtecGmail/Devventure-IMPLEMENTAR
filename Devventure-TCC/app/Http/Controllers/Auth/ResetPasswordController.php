<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Aluno;
use App\Models\Professor;

class ResetPasswordController extends Controller
{
    
    public function showResetForm(Request $request, $token = null)
    {
        
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    
    public function reset(Request $request)
    {
        
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        
        $user = Aluno::where('email', $request->email)->first();
        if (!$user) {
            $user = Professor::where('email', $request->email)->first();
        }

        if (!$user) {
            return back()->withInput($request->only('email'))
                         ->withErrors(['email' => 'Não encontramos um usuário com este e-mail.']);
        }

        
        $user->password = Hash::make($request->password);
        $user->setRememberToken(Str::random(60));
        $user->save();

        
        $loginRoute = ($user instanceof Aluno) ? 'login.aluno' : 'login.professor';
        
        return redirect()->route($loginRoute)->with('status', 'Sua senha foi redefinida com sucesso!');
    }
}