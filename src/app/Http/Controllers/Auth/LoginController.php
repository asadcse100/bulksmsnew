<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLogin()
    {
        $title = "user Login";
        return view('user.auth.login', compact('title'));
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('user.dashboard');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    { 
        $lang =  Session::get('lang');
        $flag =  Session::get('flag');
        Auth::guard('user')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken(); 
        return $this->loggedOut($request, $lang, $flag) ?: redirect('/user');
    }

    protected function loggedOut(Request $request, $lang, $flag)
    {
        Session::put('lang',$lang);
        Session::put('flag',$flag);
    }
}
