<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Frase;
use App\User;
/* use GuzzleHttp\Client; */


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
/*         $client = new Client();
        $response = $client->request('GET', 'https://api.quotable.io/quotes/random');
        $data = json_decode($response->getBody(), true);
    
        $translatedText = ''; // Valor predeterminado para la variable
    
        if (is_array($data)) {
            $randomIndex = rand(0, count($data) - 1);
            $quote = $data[$randomIndex]['content'];
            $author = $data[$randomIndex]['author'];
            
            $translateResponse = $client->request('GET', 'https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=es&dt=t&q='.urlencode($quote));
            $translatedData = json_decode($translateResponse->getBody(), true);
            $translatedText = $translatedData[0][0][0];
        } else {
            // Manejar el caso donde la API no devolvió un array válido
            return view('principal')->withErrors('No se pudieron obtener las citas. Inténtalo de nuevo más tarde.');
        }
    
        return view('principal', compact('quote', 'author', 'translatedText')); */

        $quote = '';
        $author = '';
        $translatedText = '';
    
        return view('principal', compact('quote', 'author', 'translatedText'));
    }
}
