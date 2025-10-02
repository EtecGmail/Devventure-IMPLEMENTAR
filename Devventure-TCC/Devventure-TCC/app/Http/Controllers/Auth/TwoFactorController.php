<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Professor; // Importe seus modelos
use App\Models\Aluno;

class TwoFactorController extends Controller
{
    /**
     * Mostra o formulário para inserir o código de 6 dígitos.
     */
    public function showVerifyForm()
    {
        // Se o usuário chegar aqui sem ter passado pelo login, redireciona de volta.
        if (!session('user_to_verify')) {
            return redirect('/loginProfessor'); // Pode ser qualquer rota de login padrão
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

        // Se a sessão de verificação expirou, manda o usuário fazer login de novo.
        if (!$verificationData) {
            return redirect('/loginProfessor')->withErrors(['msg' => 'Sua sessão de verificação expirou. Por favor, faça o login novamente.']);
        }

        // Determina qual modelo de usuário (Professor ou Aluno) estamos verificando
        $model = $verificationData['guard'] === 'professor' ? Professor::class : Aluno::class;
        $user = $model::find($verificationData['id']);

        // Verifica se o código está correto e não expirou
        if (!$user || $user->two_factor_code !== $request->code || $user->two_factor_expires_at < now()) {
            return back()->withErrors(['msg' => 'Código inválido ou expirado.']);
        }

        // Limpa os dados do código no banco de dados
        $user->two_factor_code = null;
        $user->two_factor_expires_at = null;
        $user->save();

        // Faz o login definitivo do usuário
        Auth::guard($verificationData['guard'])->login($user);
        $request->session()->forget('user_to_verify');

        // Redireciona para o dashboard correto
        $redirectPath = $verificationData['guard'] === 'professor' ? '/professorDashboard' : '/alunoDashboard';
        
        return redirect($redirectPath);
    }
}