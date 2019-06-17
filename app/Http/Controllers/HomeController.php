<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function loginPage()
    {
        return view('login-page');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }

    public function home()
    {
        return view('home');
    }
}
