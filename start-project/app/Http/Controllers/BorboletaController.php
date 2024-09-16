<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borboleta; // Atualizado para Borboleta
use App\Models\Curso; // Mantido, assumindo que cursos ainda são relevantes
use Dompdf\Dompdf;

class BorboletaController extends Controller
{
    private $regras = [
        'nome' => 'required|max:20|min:3|unique:borboletas', // Atualizado para campos da Borboleta
        'descricao' => 'required|max:300|min:10',
    ];
        
    private $msgs = [
        "required" => "O preenchimento do campo [:attribute] é obrigatório!",
        "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
        "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
        "unique" => "Já existe uma borboleta cadastrada com esse [:attribute]!"
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Borboleta::with('borboleta')->get(); // Atualizado para Borboleta
        return view('borboleta.index', compact('data')); // Atualizado para borboleta
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('borboleta.create'); // Atualizado para borboleta
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->regras, $this->msgs);
       
        $borboleta = new Borboleta();
        $borboleta->users_id = $request->users_id; // Atualizado para campo users_id
        $borboleta->nome = $request->nome;
        $borboleta->habitat = $request->habitat;
        $borboleta->color = $request->color;
        $borboleta->descrição = $request->descrição;
        $borboleta->save();
        
        // if ($request->hasFile('foto')) {
        //     $ext = $request->file('foto')->getClientOriginalExtension();
        //     $nome_arq = $borboleta->id . "_" . time() . "." . $ext; 
        //     $request->file('foto')->storeAs("public/", $nome_arq);
        //     $borboleta->path = $nome_arq;
        //     $borboleta->save();
        // }

        return redirect()->route('borboleta.index'); // Atualizado para borboleta
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $borboleta = Borboleta::find($id); // Atualizado para Borboleta
    
        if (isset($borboleta)) {
            return view('borboleta.show', compact('borboleta')); // Atualizado para borboleta
        }

        return "<h1>NÃO ENCONTRADA</h1>"; // Atualizado para Borboleta
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $borboleta = Borboleta::find($id); // Atualizado para Borboleta

        if (isset($borboleta)) {
            return view('borboleta.edit', compact('borboleta')); // Atualizado para borboleta
        }

        return "<h1>NÃO ENCONTRADA</h1>"; // Atualizado para Borboleta
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
        $borboleta = Borboleta::find($id); // Atualizado para Borboleta

        if (isset($borboleta)) {
            $borboleta->nome = $request->nome; // Atualizado para campos da Borboleta
            $borboleta->descricao = $request->descricao;
            $borboleta->save();
            return redirect()->route('borboleta.index'); // Atualizado para borboleta
        }

        return "<h1>NÃO ENCONTRADA</h1>"; // Atualizado para Borboleta
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $borboleta = Borboleta::find($id); // Atualizado para Borboleta
        if (isset($borboleta)) {
            $borboleta->delete();
            return redirect()->route('borboleta.index'); // Atualizado para borboleta
        }

        return "<h1>BORBOLETA NÃO ENCONTRADA</h1>"; // Atualizado para Borboleta
    }

}