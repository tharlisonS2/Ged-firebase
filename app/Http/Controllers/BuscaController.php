<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Contract\Storage;
use App\Models\Busca;

class BuscaController extends Controller
{
    public function __construct(Auth $auth, Storage $storage)
    {
        $this->auth = $auth;
        $this->storage = $storage;
        $this->storageClient = $storage->getStorageClient();
        $this->defaultBucket = $storage->getBucket();
    }
    public function index(Request $request)
    {
        $nome = [];
        return view("busca", [
            'nome' => $nome,
        ]);
    }
    public function buscar(Request $request)
    {
        $busca=new Busca($this->auth,$this->storage);
        if ($request->tipo == "pasta") {
            $nome=$busca->buscarpasta($request->palavra);
            $setado = true;
        }else{
            $nome=$busca->buscarusuario($request->palavra);
            $setado = false;
        }
        
        return view("busca", [
            'nome' => $nome,
            'setado' => $setado,


        ]);
    }
}
