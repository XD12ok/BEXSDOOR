<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registerProcess(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
            'checkbox' => 'required'
        ],
            [   'name.required' => "Nama dibutuhkan.",
                'email.required' => "Email dibutuhkan.",
                'password.required' => "Password dibutuhkan dan minimal 6 karakter.",
                'checkbox.required' => "Anda perlu menyetujui ketentuan dan privasi kami.",
                'password_confirmation.confirmed' => "Password tidak cocok.",]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    public function loginProces(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'checkbox' => 'required'
       ],
            ['email.required' => 'Email dibutuhkan.',
            'password.required' => 'Password dibutuhkan.',
            'checkbox.required' => 'Anda perlu menyetujui ketentuan dan privasi kami.',]);

        $infologin = [
            'email' =>$request->email,
            'password' =>$request->password,
        ];

        if(Auth::attempt($infologin)){
            if(auth()->user()->role == 'user') {
                return redirect('/home');
            } elseif (auth()->user()->role == 'admin') {
                return redirect('/admin/dashboard');
            }
        }else{
            return redirect('login')->withErrors('Username dan Password tidak cocok');
        }
    }

    function logout(){
        Auth::logout();
        return redirect('login');
    }
}
