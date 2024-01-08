<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use App\Http\Requests\StoreNoticiaRequest;
use App\Http\Requests\UpdateNoticiaRequest;
use Illuminate\Support\Facades\Cache;

class NoticiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        //criar um dado dentro do BD Redis
        //Cache::put('site', 'google.com.br', 10); //3 parâmetros: 1º: nome da chave que vai conter um determinado valor(parecido a atribuir valores a variaveis); 2º: valor atribuído para a chave; 3º: tempo(s) que vai ser mantido em memória;

        //recuperar um dado dentro do BD Redis
        // $site = Cache::get('site');
        // echo $site;

        $noticias = [];

        // if(Cache::has('dez_primeiras_noticias')){
        //     $noticias = Cache::get('dez_primeiras_noticias');
        // } else{
        //     $noticias = Noticia::orderByDesc('created_at')->limit(10)->get();
        //     Cache::put('dez_primeiras_noticias', $noticias, '15');
        // }

        $noticias = Cache::remember('dez_primeiras_noticias', 15, function(){ //3 parâmetros: 1º: nome da chave associada ao valor armazenado no Redis; 2º: tempo(s) de expiração do valor; 3º: função de callback retornando a consulta;
            return Noticia::orderByDesc('created_at')->limit(10)->get();
        });

        return view('noticia', ['noticias' => $noticias]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNoticiaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNoticiaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Noticia  $noticia
     * @return \Illuminate\Http\Response
     */
    public function show(Noticia $noticia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Noticia  $noticia
     * @return \Illuminate\Http\Response
     */
    public function edit(Noticia $noticia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNoticiaRequest  $request
     * @param  \App\Models\Noticia  $noticia
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNoticiaRequest $request, Noticia $noticia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Noticia  $noticia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Noticia $noticia)
    {
        //
    }
}
