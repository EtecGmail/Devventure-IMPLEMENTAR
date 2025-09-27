<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlunoLoginController extends Controller
{
    
   public function verifyUser(Request $request)
{
   if (!Auth::guard('aluno')->attempt($request->only(['email', 'password']))) {
    return back()->withErrors(['msg' => 'Credenciais inválidas!']);
}
return redirect('/alunoDashboard');
}


    public function logoutUser(Request $request)
    {
        Auth::guard('aluno')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/loginAluno');
    }
}
