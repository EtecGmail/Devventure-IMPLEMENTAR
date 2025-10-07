<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Professor; // Importe seus modelos
use App\Models\Aluno;
use Illuminate\Support\Facades\Mail;
 

class TwoFactorController extends Controller
{
    /**
     * Mostra o formulário para inserir o código de 6 dígitos.
     */
    public function showVerifyForm()
    {
        
        if (!session('user_to_verify')) {
            return redirect('/loginProfessor'); 
        }
        return view('auth.2fa_verify');
    }

    /**
     * Valida o código de 6 dígitos enviado pelo usuário.
     */
    public function verifyCode(Request $request)
    {
        $request->validate(['code' => 'required|numeric']);

        $verificationData = $request->session()->get('user_to_verify');

        
        if (!$verificationData) {
            return redirect('/loginProfessor')->withErrors(['msg' => 'Sua sessão de verificação expirou. Por favor, faça o login novamente.']);
        }

        
        $model = $verificationData['guard'] === 'professor' ? Professor::class : Aluno::class;
        $user = $model::find($verificationData['id']);

        
        if (!$user || $user->two_factor_code !== $request->code || $user->two_factor_expires_at < now()) {
            return back()->withErrors(['msg' => 'Código inválido ou expirado.']);
        }

        
        $user->two_factor_code = null;
        $user->two_factor_expires_at = null;
        $user->save();

        
        Auth::guard($verificationData['guard'])->login($user);
        $request->session()->forget('user_to_verify');

        
        $redirectPath = $verificationData['guard'] === 'professor' ? '/professorDashboard' : '/alunoDashboard';
        
        return redirect($redirectPath);
    }

     


}