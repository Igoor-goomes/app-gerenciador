<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class GerenciadorController extends Controller
{
    public function showLogin()
    {
        return view('signin');
    }

    public function signIn(Request $request)
    {
        $signIn = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:6']
        ]);

        if (! Auth::attempt(['email' => $signIn['email'], 'password' => $signIn['password']], false)) {
            return back()->withErrors([
                'email' => 'Verifique suas credenciais!'
            ])->onlyInput('email');
        }

        $request->session()->regenerate();
        return redirect()->intended(route('home'));

    }

    public function index()
    {
        return view('home');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('signin');
    }
}
