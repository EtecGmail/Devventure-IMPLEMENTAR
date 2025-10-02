<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorCodeMail; // Importa a classe de e-mail que vamos criar

class AlunoLoginController extends Controller
{
    /**
     * Processa a tentativa de login e envia o código 2FA.
     */
    public function verifyUser(Request $request)
    {
        // 1. Tenta autenticar as credenciais (e-mail e senha)
        if (!Auth::guard('aluno')->attempt($request->only('email', 'password'))) {
            return back()->withErrors(['msg' => 'Credenciais inválidas!']);
        }

        // 2. Se as credenciais estiverem corretas, pega o usuário
        $user = Auth::guard('aluno')->user();

        // 3. Gera e salva o código e a data de expiração no banco
        $code = rand(100000, 999999);
        $user->two_factor_code = $code;
        $user->two_factor_expires_at = now()->addMinutes(10);
        $user->save();
        
        // 4. Envia o e-mail com o código
        try {
            Mail::to($user->email)->send(new TwoFactorCodeMail($code));
        } catch (\Exception $e) {
            // Se o envio falhar, idealmente você registraria o erro em um log.
        }

        // 5. Desloga o usuário temporariamente (MUITO IMPORTANTE!)
        Auth::guard('aluno')->logout();

        // 6. Guarda na sessão qual usuário está tentando verificar para a próxima etapa
        $request->session()->put('user_to_verify', [
            'id' => $user->id,
            'guard' => 'aluno'
        ]);

        // 7. Redireciona para a tela onde o usuário vai inserir o código
        return redirect()->route('2fa.verify.form');
    }

    /**
     * Processa o logout do usuário.
     */
    public function logoutUser(Request $request)
    {
        Auth::guard('aluno')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/loginAluno');
    }
}