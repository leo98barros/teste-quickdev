<?php

namespace App\Http\Controllers;

use Arr;
use Http;
use Str;
use Validator;

use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * return movies
     * 
     * @param \Illuminate\Http\Request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request) : \Illuminate\Http\JsonResponse
    {
        // validando query strings
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:191',
            'genre' => 'nullable',
        ]);

        if ($validator->fails()) {
            return responder()->error('form_validation', 'Por favor, cheque seus dados e tente novamente')->data(['fields' => $validator->errors()->toArray()])->respond();
        };
        
        // Parâmetros padrão com chave e linguagem dos dados
        $arrayParam = [
            'api_key' => '4ec327e462149c3710d63be84b81cf4f',
            'language' => 'pt-BR',
        ];

        // filtro por gênero
        if ($request->filled('genre')) {
            $arrayParam = Arr::prepend($arrayParam, $request->genre, 'with_genres');
        }

        // montando query string
        $params = $this->mapped_implode('&', $arrayParam, '=');

        $response = Http::get('https://api.themoviedb.org/3/discover/movie?'.$params);

        return responder()->success($response->json()['results'])->respond();
    }

    /**
     * return movie details
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $movie
     */
    public function show(int $movie, Request $request) 
    {   
        $response = Http::get('https://api.themoviedb.org/3/movie/'.$movie.'?api_key=4ec327e462149c3710d63be84b81cf4f&language=pt-BR');

        if ($response->failed()) {
            return responder()->error()->data(['message' => $response->json()['status_message']])->respond();
        }

        return view('movie', ['movie' => $response->json()]);
    } // https://api.themoviedb.org/3/movie/635302/xPpXYnCWfjkt3zzE0dpCNME1pXF.jpg 

    /**
     * return genres
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $movie
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function genres() : \Illuminate\Http\JsonResponse
    {   
        $response = Http::get('https://api.themoviedb.org/3/genre/movie/list?api_key=4ec327e462149c3710d63be84b81cf4f&language=pt-BR');

        return responder()->success($response->json()['genres'])->respond();
    }

    /**
     * Make a string with key and value from array
     * 
     * @param string $glue
     * @param array $array
     * @param string $symbol
     * 
     * @return string
     */
    protected function mapped_implode($glue, $array, $symbol)
    {
        return implode($glue, 
            array_map(
                function($key, $value) use($symbol) {
                    return $key . $symbol . $value;
                },
                array_keys($array),
                array_values($array)
            )
        );
    }
}
