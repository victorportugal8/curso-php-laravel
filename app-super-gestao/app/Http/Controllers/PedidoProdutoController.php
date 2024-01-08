<?php

namespace App\Http\Controllers;

use App\Pedido;
use App\PedidoProduto;
use App\Produto;
use Illuminate\Http\Request;

class PedidoProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Pedido $pedido)
    {
        $produtos = Produto::all();
        // $pedido->produtos; -> como estamos trabalhando com objeto instanciado, podemos implementas o eager loading dessa forma
        return view('app.pedido_produto.create', ['pedido' => $pedido, 'produtos' => $produtos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Pedido $pedido)
    {
        $regras = [
            'produto_id' => 'exists:produtos,id',
            'quantidade' => 'required'
        ];

        $feedback = [
            'produto_id.exists' => 'O produto informado não existe.',
            'required' => 'O campo :attribute deve ser preenchido.'
        ];

        $request->validate($regras, $feedback);

        // $pedidoProduto = new PedidoProduto();
        // $pedidoProduto->pedido_id = $pedido->id;
        // $pedidoProduto->produto_id = $request->get('produto_id');
        // $pedidoProduto->quantidade = $request->get('quantidade'); -> funcionaria, porém a quantidade será adicionada pelo relacionamento implementado nos modelos(belongsToMany)
        // $pedidoProduto->save();

        // $pedido->produtos 
        //quando chamamos um método em formato de atributo, o retorno é o registro do relacionamento
        
        // $pedido->produtos()->attach($request->get('produto_id'), ['quantidade' => $request->get('quantidade')]);
        //quando chamamos normalmente, obtemos um objeto que mapeia o relacionamento;
        //attach-> permite add as infos que devem ser inseridas na tabela auxiliar;

        //caso seja necessário incluir mais de um registro de uma vez(vários produtos no pedido de uma única vez, por exemplo) a sintaxe é a seguinte
        $pedido->produtos()->attach([
            //id da tabela do relacionamento => campos e valores que serão inseridos na tabela de relacionamento
            $request->get('produto_id') => ['quantidade' => $request->get('quantidade')]
        ]);

        return redirect()->route('pedido-produto.create', ['pedido' => $pedido->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  PedidoProduto $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy(Pedido $pedido, Produto $produto)
    public function destroy(PedidoProduto $pedidoProduto, $pedido_id)
    {
        //forma convencional
        // PedidoProduto::where([
        //     'pedido_id' => $pedido->id,
        //     'produto_id' => $produto->id
        // ])->delete();

        //método detach() -> permite realizar o delete pelo relacionamento implementado no model(belongsToMany)
        $pedidoProduto->delete();

        return redirect()->route('pedido-produto.create', ['pedido' => $pedido_id]);
    }
}
