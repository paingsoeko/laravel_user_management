<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::check() and Auth::user()->is_active === 1) {
            return view('dashboard');
        } else {
            $request->validate([
                'username' => 'required',
                'password' => 'required'
            ]);
            $credentials = $request->only('username', 'password');
            if (Auth::attempt($credentials)) {
                if (Auth::user()->is_active === 1) {
                    return redirect()->intended(route('home'))->with([
                        'message' => 'Hi, ' . Auth::user()->name,
                        'type' => 'default',
                        'duration' => 6000,
                        'dismissible' => true,
                    ]);
                } else {
                    return redirect(route('index'))->with('message', 'This account has been deactivated!');
                }
            }
            return redirect(route('index'))->with('message', 'Login details are not valid!');
        }
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect(route('index'));
    }


    //Route Auth
    public function home()
    {
        if (Auth::check() and Auth::user()->is_active === 1) {
            return view('dashboard');
        }
        return view('auth/login');
    }

}
