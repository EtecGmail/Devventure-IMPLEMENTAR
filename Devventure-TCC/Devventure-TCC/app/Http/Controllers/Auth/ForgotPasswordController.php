<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aluno;
use App\Models\Professor;

class ForgotPasswordController extends Controller
{
    
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email'); 
    }

    
    public function sendResetLinkEmail(Request $request)
{
    $request->validate(['email' => 'required|email']);

    $user = Aluno::where('email', $request->email)->first();
    if (!$user) {
        $user = Professor::where('email', $request->email)->first();
    }

    if ($user) {
        try {
            $code = rand(100000, 999999);
            
            $user->reset_password_code = $code;
            $user->reset_password_expires_at = now()->addMinutes(10);
            
            $user->save();

            
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\TwoFactorCodeMail($code));
            
            return redirect()->route('password.verify.form')->with('email', $user->email);

        } catch (\Exception $e) {
            
            dd($e->getMessage());
        }
    }

    return back()->with('status', 'Se um usuário com este e-mail existir, um link de redefinição foi enviado.');
}
    public function showVerifyForm()
{
    
    if (!session()->has('email')) {
        
        return redirect()->route('password.request')->withErrors(['email' => 'Sessão inválida. Por favor, solicite a redefinição novamente.']);
    }

    return view('auth.passwords.verify'); 
}


public function verifyCode(Request $request)
{
    
    $request->validate([
        'email' => 'required|email',
        'code' => 'required|numeric|digits:6',
    ]);

    
    $user = Aluno::where('email', $request->email)->first();
    if (!$user) {
        $user = Professor::where('email', $request->email)->first();
    }

    
    if ($user && $user->reset_password_code == $request->code && $user->reset_password_expires_at > now()) {
        
        
        $token = \Illuminate\Support\Facades\Password::getRepository()->create($user);

        
        $user->reset_password_code = null;
        $user->reset_password_expires_at = null;
        $user->save();
        
        
        return redirect()->route('password.reset.form', ['token' => $token, 'email' => $request->email]);
    }

    
    return back()->withErrors(['code' => 'Código inválido ou expirado. Tente novamente.']);
}
}