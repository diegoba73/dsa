<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Frase;
use App\User;
use GuzzleHttp\Client;


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
        $client = new Client();
        $response = $client->request('GET', 'https://type.fit/api/quotes');
        $data = json_decode($response->getBody(), true);

        // Obtener un índice aleatorio dentro del rango de las citas disponibles.
        $randomIndex = rand(0, count($data) - 1);

        $quote = $data[$randomIndex]['text'];
        $author = $data[$randomIndex]['author'];

        $translateResponse = $client->request('GET', 'https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=es&dt=t&q='.urlencode($quote));
        $translatedData = json_decode($translateResponse->getBody(), true);
        $translatedText = $translatedData[0][0][0];
    
        return view('principal', compact('quote', 'author', 'translatedText'));
    }
}
