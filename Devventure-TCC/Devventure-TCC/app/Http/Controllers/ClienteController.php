<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cliente;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $cliente = Cliente::all();

        foreach($cliente as $c){
            echo "$c->idCli";
            echo "$c->nomeCLi";
            echo "$c->cpfCli";
            echo "$c->emailCli";
            echo "<br />";
        }
    }

    public function indexapi()
    {        
        $cliente = Cliente::all();
        return $cliente;
        
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
        //
    }

    public function storeapi(Request $request)
    {
        $cliente = new Cliente();

        $cliente->nomeCli = $request->nome;
        $cliente->cpfCli = $request->cpf;
        $cliente->emailCli = $request->email;
        
        $cliente->save();
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
    public function updateApi(Request $request, $id)
    {
        Cliente::where('idcli',$id)->update([
            'nomeCli' => $request->nome,
            'cpfCli' => $request->cpf,
            'emailCli'=> $request->email            
        ]);
        
        return response()->json([
            'message'=> 'Dados alterados com sucesso',
            'code'=>200]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyapi($id)
    {     

        Cliente::where('idcli','=',$id)->delete();        

        return response()->json([
            'message'=> 'Dados excluídos com sucesso',
            'code'=>200]
        );        
    }
}
