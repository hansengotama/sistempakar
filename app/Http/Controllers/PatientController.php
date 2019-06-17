<?php

namespace App\Http\Controllers;

use App\Diseases;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function home()
    {
        return view('patient.home');
    }

    public function consultationView()
    {
        return view('patient.consultation');
    }
}
