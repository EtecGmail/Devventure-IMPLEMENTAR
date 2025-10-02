<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfessorLoginController extends Controller
{
    public function verifyUser(Request $request)
    {
        
        Auth::guard('aluno')->logout();

        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        

        if (!Auth::guard('professor')->attempt($request->only(['email', 'password']))) {
            return back()->withErrors(['msg' => 'Credenciais inválidas!']);
        }

        
        $request->session()->regenerate();

        return redirect('/professorDashboard');
    }

    public function logoutUser(Request $request)
    {
        Auth::guard('professor')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/loginProfessor');
    }
}