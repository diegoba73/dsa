<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Frase;
use App\User;

class PrincipalController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $frases = Frase::all()->random(1);
        return view('principal')->with(compact('frases'));
    }
}
