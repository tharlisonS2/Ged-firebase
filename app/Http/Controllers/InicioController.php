<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Contract\Storage;
use Illuminate\Support\Facades\Session;
use App\Models\Busca;
class InicioController extends Controller
{
    public function __construct(Auth $auth, Storage $storage)
    {
        $this->auth = $auth;
        $this->storage = $storage;
        $this->storageClient = $storage->getStorageClient();
        $this->defaultBucket = $storage->getBucket();
    }
    public function index(){
        $buscardados=new Busca($this->auth,$this->storage);
        $dadosuser=$buscardados->usuarioquantidade();
        $dadosdoc=$buscardados->documentoquantidade();
        if (Session::get('admin') == true){
        return view('admin.inicio', [
            'dadosuser' => $dadosuser,
            'dadosdoc' =>  $dadosdoc
        ]);
        }else{
            return view('inicio');
        }
    }
}
