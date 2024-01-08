<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Repositories\MarcaRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MarcaController extends Controller
{
    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $marcaRepository = new MarcaRepository($this->marca);
        
        if($request->has('atributos_modelos')){
            $atributos_modelos = 'modelos:id,'.$request->atributos_modelos;
            $marcaRepository->selectAtributosRegistrosRelacionados($atributos_modelos);
        } else{
            $marcaRepository->selectAtributosRegistrosRelacionados('modelos');
        }

        if($request->has('filtro')){
            $marcaRepository->filtro($request->filtro);
        }

        if($request->has('atributos')){
            $marcaRepository->selectAtributos($request->atributos);
        }

        return response()->json($marcaRepository->getResultadoPaginado(3), 200);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $marca = Marca::create($request->all()); método estático 

        $request->validate($this->marca->rules(), $this->marca->feedback());
        //stateless: cada requisição deve ser única
        
        // dd($request->nome);
        // dd($request->get('nome'));
        // dd($request->input('nome'));
        // dd($request->imagem);
        // dd($request->file('imagem'));
        
        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('img/logos', 'public'); //1º parâmetro: é o caminho onde o arquivo será armazenado; 2º parâmetro: é o disco onde será armazenado(config/filesystems.php)
        
        $marca = $this->marca->create(['nome' => $request->nome, 'imagem' => $imagem_urn]);
        
        // $marca->nome = $request->nome;
        // $marca->imagem = $imagem_urn;
        // $marca->save();

        return response()->json($marca, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marca = $this->marca->with('modelos')->find($id);
        if($marca === null) return response()->json(['erro' => 'Recurso pesquisado não existe!'], 404);
        return response()->json($marca, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function edit(Marca $marca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // print_r($request->all()); //Dados atualizados
        // echo '<hr>';
        // print_r($marca->getAttributes()); //Dados antigos

        // $marca->update($request->all());
        $marca = $this->marca->find($id);
        
        if($marca === null) return response()->json(['erro' => 'Recurso pesquisado não existe!'], 404);
        
        if($request->method() === 'PATCH'){
            $regrasDinamicas = array();
            //percorrendo todas as regras definidas no Model
            foreach($marca->rules() as $input => $regra){
                //coletando as regras aplicáveis aos parâmetros parciais da requisição PATCH
                if(array_key_exists($input, $request->all())){
                    $regrasDinamicas[$input] = $regra;
                }
            }
            $request->validate($regrasDinamicas, $marca->feedback());
        } else{
            $request->validate($marca->rules(), $marca->feedback());
        }

        //preenchendo o objeto marca com todos os dados do request
        $marca->fill($request->all());

        //persistindo o novo arquivo de imagem(caso seja enviado na requisição)
        if($request->file('imagem')){
            //remove o arquivo antigo
            Storage::disk('public')->delete($marca->imagem);

            $imagem = $request->file('imagem');
            $imagem_urn = $imagem->store('img', 'public');
            
            $marca->imagem = $imagem_urn;

        }
        $marca->save();
        
        return response()->json($marca, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $marca = $this->marca->find($id);
        if($marca === null) return response()->json(['erro' => 'Recurso pesquisado não existe!'], 404);
        //remove o arquivo antigo
        Storage::disk('public')->delete($marca->imagem);
        $marca->delete();
        return response()->json(['msg' => 'A marca foi removida com sucesso!'], 200);
    }
}
