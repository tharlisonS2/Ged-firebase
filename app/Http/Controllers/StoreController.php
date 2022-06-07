<?php

namespace App\Http\Controllers;

use Google\Cloud\Storage\StorageClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Contract\Storage;

class StoreController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $auth, $database, $storage;
    public function __construct(Storage $storage,Request $request)
    {
        $this->storage = $storage;
        $this->storageClient = $storage->getStorageClient();
        $this->defaultBucket = $storage->getBucket();
        if ($request->hasFile('arquivo')) {
            $this->source=$request->arquivo->path();
        }else{
            $this->source=public_path('index.php');
        }
        
    }
    public function index()
    {

    $bucket = $this->defaultBucket;
    $info = $bucket->info();
    if (isset($info['labels'])) {
        foreach ($info['labels'] as $labelKey => $labelValue) {
            echo($labelKey.$labelValue);
        }
    }

        $buckets = $this->defaultBucket->objects();
        $buckets2 = $this->defaultBucket->objects();
        $object = $this->defaultBucket->objects();
        $caminhopasta = [];
        foreach ($object as $obj) {
            if (isset($obj->info()['metadata']['caminhopasta'])) {
                if (in_array($obj->name(), $caminhopasta) == false) {
                    if(Session::get('admin')==true){
                        $caminhopasta[] = $obj->name();
                    }elseif(Session::get('admin')==false&&$obj->info()['metadata']['departamento']==Session::get('departamento')){
                        $caminhopasta[] = $obj->name();
                    }
                }
            }
        }
        // $parametros=array(
        //     'categoria' => '$request->categoria',
        //     'processo'=> '$request->processo',
        //     'cliente' => '$request->cliente'
        //     );
       
        $caminho = 'Documento/';
        if(Session::get('admin')==true){
            
            return view("admin.d2", [
                'buckets' => $buckets,
                'buckets2' => $buckets2,
                'caminho' => $caminho,
                'caminhopasta' => $caminhopasta
            ]);
        }elseif(Session::get('admin')==false){
            
            return view("documento", [
                'buckets' => $buckets,
                'buckets2' => $buckets2,
                'caminho' => $caminho,
                'caminhopasta' => $caminhopasta
            ]);  
        }
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
        $departamento = $request->get("departamento");
        if($request->nomearquivo!=''){
        $request->nomearquivo = $request->nomearquivo . '.' . $request->arquivo->extension();
        }else{
            $request->nomearquivo= $request->arquivo->getClientOriginalName();
        }
        $file = fopen($this->source, 'r');
        $bucket = $this->defaultBucket;

        $options = ['name' => $departamento . $request->nomearquivo,];
        $object = $bucket->upload(
            $file,
            $options

        );
        $departamento=substr($departamento,  0,strpos($departamento, "/")+1);
        $admincheck = $request->manterbloqueado;
        if ($admincheck == true) {
            $object->update([
                'metadata' => [
                    'admin' => true,
                    'raizdepartamento'=>$departamento
                ]
            ]);
        } else {
            $object->update([
                'metadata' => [
                    'admin' => false,
                    'raizdepartamento'=>$departamento
                ]
            ]);
        }
        return redirect("/documento");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($objectname)
    {
        $buckets2 = $this->defaultBucket->objects();
        $object = $this->defaultBucket->objects();
        foreach ($object as $obj) {
            if ($obj->info()['generation'] == $objectname) {   //generation
                $objectname = $obj->name();
                break;
            }
        }//1651249804609764
        if(Session::get('admin')!=true){
            if(isset($obj->info()['metadata']['raizdepartamento'])&&$obj->info()['metadata']['raizdepartamento']!=Session::get('departamento').'/'
            ||isset($obj->info()['metadata']['departamento'])&&$obj->info()['metadata']['departamento']!=Session::get('departamento')){
                return redirect('documento')->with('status', 'AcessoDocumentoNegado');
            }
        }
        $caminhopasta = [];
 
        foreach ($object as $obj) {
        
            if (isset($obj->info()['metadata']['caminhopasta'])) {
                if (in_array($obj->name(), $caminhopasta) == false) {
                    if(Session::get('admin')==true){
                        $caminhopasta[] = $obj->name();
                    }elseif(Session::get('admin')==false&&$obj->info()['metadata']['departamento']==Session::get('departamento')){
                        $caminhopasta[] = $obj->name();
                    }
                }
            }
        }
        $directoryPrefix = $objectname;

        $caminho = 'Documento/' . $objectname;
      
        $bucket = $this->defaultBucket;

        $options = ['prefix' => $directoryPrefix];
       
        foreach ($bucket->objects($options) as $object) {
            if (strlen($objectname) < strlen($object->name())) {
              
                $object->name = substr($object->name(), 0, strlen($objectname));
                $file[] = $object;
            } else {
                $file[] = $object;
            }
        }
        $buckets = $this->defaultBucket->objects();


        if(Session::get('admin')==true){

            return response()->view('admin.documento', [
                    'files' => $file,
                    'buckets' => $buckets,
                    'buckets2' => $buckets2,
                    'caminho' => $caminho,
                    'caminhopasta' => $caminhopasta
                ]);
        }elseif(Session::get('admin')==false){

            return response()->view('documento', [
                'files' => $file,
                'buckets' => $buckets,
                'buckets2' => $buckets2,
                'caminho' => $caminho,
                'caminhopasta' => $caminhopasta
            ]);
        }
        //foreach($object as $objects){
        //   if(substr_compare($objects->name(),$objectname.'/',0)==0){
        //       $file[]=$objects;
        //}
        //   if($objects->name()==$objectname.'/'){
        //       $buckets=$this->defaultBucket->objects();
        //        $object=$this->defaultBucket->objects();
        //        
        //        return view("documento",[
        //            'files' => $file,
        //           'buckets' => $buckets,
        //        ]);
        //    }else{
        //      
        //    }
        //}

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bucket = $this->defaultBucket;
        $object = $this->defaultBucket->objects();
        foreach ($object as $obj) {
            if ($obj->info()['generation'] == $id) {
                $objectname = $obj->name();
                $object = $bucket->object($objectname, [
                    'generation' => $id,
                ]);
                break;
            }
        }


        $object->delete();

        return redirect('/documento')->with('status', 'Documento');
    }
    public function download($objectname)
    {
        $object = $this->defaultBucket->objects();
        foreach ($object as $obj) {
            if ($obj->info()['generation'] == $objectname) {
                $objectname = $obj->name();
                break;
            }
        }

        $destination = substr($objectname, strrpos($objectname, "/") + 1);

        $storage = new StorageClient([
            'keyFile' => json_decode(file_get_contents(base_path() . "/teste-6b588-firebase-adminsdk-bd7zp-ad836b7587.json"), true),
        ]);
        $bucket = $storage->bucket($this->defaultBucket->name());
        $object = $bucket->object($objectname);
        $object->downloadToFile($destination);

        return response()->download($destination);
    }
    public function visualizar($objectname)
    {
        $object = $this->defaultBucket->objects();
        foreach ($object as $obj) {
            if ($obj->info()['generation'] == $objectname) {
                $objectname = $obj->name();
                break;
            }
        }

        $bucket = $this->defaultBucket;
        $object = $bucket->object($objectname);
        $url = $object->signedUrl(
            new \DateTime('5second'),
            [
                'version' => 'v4',
            ]
        );
        return redirect($url);
    }
    public function criardepartamento(Request $request)
    {
        // $request->nomepasta;
        $file = fopen($this->source, 'r');
        $folder_name = $request->nomepasta . "/";
        $options = ['name' => $folder_name];
        $bucket = $this->defaultBucket;
        $object = $bucket->upload(
            NULL,
            $options

        );
        $object = $bucket->object($request->nomepasta . "/");
        $object->update([
            'metadata' => [
                'Raizdepartamento' => True,
                'departamento' => $request->nomepasta,
                'caminhopasta' => $request->nomepasta
            ]
        ]);
        return redirect("/documento");
    }
    public function criarpasta(Request $request,$pai){
        $object = $this->defaultBucket->objects();
        foreach ($object as $obj) {
            if ($obj->info()['generation'] == $pai) {
                $pai = $obj->name();
                break;
            }
        }

        $file = fopen($this->source, 'r');
        $folder_name = $pai.$request->nomepasta . "/";
        $options = ['name' => $folder_name];
        $bucket = $this->defaultBucket;
        $object = $bucket->upload(
            NULL,
            $options

        );
        $object->update([
            'metadata' => [
                'departamento' => substr($pai,  0,strpos($pai, "/")),
                'pai'=>$pai,
                'caminhopasta' => $request->nomepasta
            ]
        ]);

        return redirect("/documento");
    }
}
