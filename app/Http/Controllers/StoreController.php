<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Contract\Storage;
use App\Models\Documento;

class StoreController extends Controller

{

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
        $this->storageClient = $storage->getStorageClient();
        $this->defaultBucket = $storage->getBucket();

    }
    public function index()
    {
        $buckets = $this->defaultBucket->objects();
        $buckets2 = $this->defaultBucket->objects();
        $object = $this->defaultBucket->objects();
        $caminhopasta = [];

        $caminho = 'Documento/';
        if (Session::get('admin') == true) {
            return view("admin.d2",[
                'buckets' => $buckets,
                'buckets2' => $buckets2,
                'caminho' => $caminho,
                'caminhopasta' => $caminhopasta,
                'object' => $object
            ]);
        } elseif (Session::get('admin') == false) {
            return view("documento",[
                'buckets' => $buckets,
                'buckets2' => $buckets2,
                'caminho' => $caminho,
                'caminhopasta' => $caminhopasta,
                'object' => $object
            ]);
        }
    }
    public function store(Request $request)
    {

        $documento = new Documento($this->storage, $request);
        if ($request->hasFile('arquivo')) {
            $this->source = $request->arquivo->path();
        } else {
            $this->source = public_path('index.php');
        }
        $documento->armazenar($request,$this->source);
        return redirect("/documento")->with('status', 'Upload Concluido!');
    }
    public function show($objectname)
    {

        $documento = new Documento($this->storage);
        $vars[] = $documento->mostrar($objectname);
        if($vars[0]==null){
            return redirect('/documento')->with('status' ,'Acesso documento negado!');
        }elseif (Session::get('admin') == true) {

            return view('admin.d2', [
                'files' => $vars[0]['files'],
                'buckets' => $vars[0]['buckets'],
                'buckets2' => $vars[0]['buckets2'],
                'caminho' => $vars[0]['caminho'],
                'caminhopasta' => $vars[0]['caminhopasta'],
                'object' => $vars[0]['object']
            ]);
        } elseif (Session::get('admin') == false) {

            return view('documento', [
                'files' => $vars[0]['files'],
                'buckets' => $vars[0]['buckets'],
                'buckets2' => $vars[0]['buckets2'],
                'caminho' => $vars[0]['caminho'],
                'caminhopasta' => $vars[0]['caminhopasta'],
                'object' => $vars[0]['object']
            ]);
        }
    }
    public function edit($id)
    {
    }
    public function update(Request $request, $id)
    {
    }
    public function destroy($id)
    {

        $documento = new Documento($this->storage);
        $documento->deletar($id);
        return redirect('/documento')->with('status', 'Documento excluido!');
    }
    public function download($objectname)
    {
        $documento = new Documento($this->storage);
        return response()->download($documento->download($objectname));
    }
    public function visualizar($objectname)
    {
        $documento = new Documento($this->storage);
        $vars[]=$documento->visualizar($objectname);
        return view('verdocumento', [
            'files' => $vars[0]['files'],
            'buckets' => $vars[0]['buckets'],
            'buckets2' => $vars[0]['buckets2'],
            'caminho' => $vars[0]['caminho'],
            'caminhopasta' => $vars[0]['caminhopasta'],
            'object' => $vars[0]['object'],
            'url' => $vars[0]['url']
        ]);

    
        return redirect($documento->visualizar($objectname));
    }
    public function criardepartamento(Request $request)
    {
        $documento = new Documento($this->storage, $request);
        $documento->criardepartamento($request);
        return redirect("/documento")->with('status', 'Novo departamento criado!');
    }
    public function criarpasta(Request $request, $pai)
    {
        $documento = new Documento($this->storage, $request);
        $documento->criarpasta($request, $pai);
        return redirect("/documento")->with('status', 'Nova pasta criada!');
    }
}
