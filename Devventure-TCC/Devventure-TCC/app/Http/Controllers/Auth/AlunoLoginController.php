<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorCodeMail; 

class AlunoLoginController extends Controller
{
    
    public function verifyUser(Request $request)
    {
        
        if (Auth::guard('professor')->check()) {
            Auth::guard('professor')->logout();
        }

        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        
       
        if (!Auth::guard('aluno')->attempt($request->only('email', 'password'))) {
            return back()->withErrors(['msg' => 'E-mail ou senha inválidos']);
        }

        
        $user = Auth::guard('aluno')->user();

        
        $code = rand(100000, 999999);
        $user->two_factor_code = $code;
        $user->two_factor_expires_at = now()->addMinutes(10);
        $user->save();
        
        
        try {
            Mail::to($user->email)->send(new TwoFactorCodeMail($code));
        } catch (\Exception $e) {
            
        }

        
        Auth::guard('aluno')->logout();

        
        $request->session()->put('user_to_verify', [
            'id' => $user->id,
            'guard' => 'aluno'
        ]);

        // 7. Redireciona para a tela onde o usuário vai inserir o código
        return redirect()->route('2fa.verify.form');
    }

    
    public function logoutUser(Request $request)
    {
        Auth::guard('aluno')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/loginAluno');
    }
}
