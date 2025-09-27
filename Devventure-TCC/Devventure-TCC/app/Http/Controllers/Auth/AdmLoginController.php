<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
class AdmLoginController extends Controller
{
     public function verifyUser(Request $request)
    {
        if (! Auth::guard('admin')->attempt($request->only(['email', 'password']))) {
            return back()->withErrors(['msg' => 'Credenciais inválidas!']);
        }

        return redirect('/admDashboard');
    }

    public function logoutUser(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/loginAdm');
    }
}
