<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Storage;

class Documento extends Model
{
    use HasFactory;
    private $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
        $this->storageClient = $storage->getStorageClient();
        $this->defaultBucket = $storage->getBucket();
    }

    public function armazenar(Request $request,$source)
    {
        $departamento = $request->get("departamento");
        if ($request->nomearquivo != '') {
            $request->nomearquivo = $request->nomearquivo . '.' . $request->arquivo->extension();
        } else {
            $request->nomearquivo = $request->arquivo->getClientOriginalName();
        }
        $file = fopen($source, 'r');
        $bucket = $this->defaultBucket;

        $options = ['name' => $departamento . $request->nomearquivo,];
        $object = $bucket->upload(
            $file,
            $options

        );
        $departamento = substr($departamento,  0, strpos($departamento, "/") + 1);
        $admincheck = $request->manterbloqueado;
        if ($admincheck == true) {
            $object->update([
                'metadata' => [
                    'admin' => true,
                    'raizdepartamento' => $departamento,
                    'author' => Session::get('username')
                ]
            ]);
        } else {
            $object->update([
                'metadata' => [
                    'admin' => false,
                    'raizdepartamento' => $departamento,
                    'author' => Session::get('username')
                ]
            ]);
        }
    }
    public function mostrar($objectname)
    {
        
        $objectname2='';
        $buckets2 = $this->defaultBucket->objects();
        $object = $this->defaultBucket->objects();
        foreach ($object as $obj) {
            if ($obj->info()['generation'] == $objectname) {   //generation
                $objectname = $obj->name();
                $objectname2 =$obj->info()['generation'];
                break;
            }else if($obj->name()==$objectname){
               
                $objectname=$obj->info()['generation'];
                $objectname2 = $obj->name();
                break;
            }
        } //1651249804609764
        if (Session::get('admin') != true) {
            if (isset($obj->info()['metadata']['raizdepartamento']) && $obj->info()['metadata']['raizdepartamento'] != Session::get('departamento') . '/'
                || isset($obj->info()['metadata']['departamento']) && $obj->info()['metadata']['departamento'] != Session::get('departamento')) {
                return null;
            }
        }
        $caminhopasta = [];
      
        $caminho = 'Documento/' . $objectname;
        $caminho = explode("/", $caminho);
        $directoryPrefix = $objectname;


        $bucket = $this->defaultBucket;

        $options = ['prefix' => $directoryPrefix];
        $file=[];
        foreach ($bucket->objects($options) as $object) {
            if (strlen($objectname2) < strlen($object->name())) {

                $object->name = substr($object->name(), 0, strlen($objectname2));
                $file[] = $object;
            } else {
                $file[] = $object;
            }
        }
        $buckets = $this->defaultBucket->objects();
        $object = $this->defaultBucket->objects();
        return [
            'files' => $file,
            'buckets' => $buckets,
            'buckets2' => $buckets2,
            'caminho' => $caminho,
            'caminhopasta' => $caminhopasta,
            'object' => $object
        ];
    }
    public function deletar($id)
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

        $storage =$this->storage;
        $bucket = $storage->getBucket($this->defaultBucket->name());
        $object = $bucket->object($objectname);
        $object->downloadToFile($destination);
        return $destination;
    }
    public function visualizar($objectname)
    {
        $objectname2='';
        $object = $this->defaultBucket->objects();
        foreach ($object as $obj) {
            if ($obj->info()['generation'] == $objectname) {   //generation
                $objectname = $obj->name();
                $objectname2 = $obj->name();
                break;
            }else if($obj->name()==$objectname){
                $objectname=$obj->info()['generation'];
                $objectname2 = $obj->name();
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
        $buckets = $this->defaultBucket->objects();
        $buckets2 = $this->defaultBucket->objects();
        
        $caminhopasta = [];

        $caminho = 'Documento/' . $objectname;
        $caminho = explode("/", $caminho);
        $directoryPrefix = $objectname;
        $options = ['prefix' => $directoryPrefix];
        $file=[];
        foreach ($bucket->objects($options) as $object) {
            if (strlen($objectname2) < strlen($object->name())) {

                $object->name = substr($object->name(), 0, strlen($objectname2));
                $file[] = $object;
            } else {
                $file[] = $object;
            }
        }
        $object = $this->defaultBucket->objects();
        return [
            'files' => $file,
            'buckets' => $buckets,
            'buckets2' => $buckets2,
            'caminho' => $caminho,
            'caminhopasta' => $caminhopasta,
            'object' => $object,
            'url' => $url
        ];
  
    }
    public function criardepartamento(Request $request)
    {
        $folder_name = $request->nomepasta . "/";
        $options = ['name' => $folder_name];
        $bucket = $this->defaultBucket;
        $object = $bucket->upload(
            null,
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
    }
    public function criarpasta(Request $request, $pai)
    {
        $object = $this->defaultBucket->objects();
        foreach ($object as $obj) {
            if ($obj->info()['generation'] == $pai) {
                $pai = $obj->name();
                break;
            }
        }


        $folder_name = $pai . $request->nomepasta . "/";
        $options = ['name' => $folder_name];
        $bucket = $this->defaultBucket;
        $object = $bucket->upload(
            null,
            $options

        );
        $object->update([
            'metadata' => [
                'departamento' => substr($pai,  0, strpos($pai, "/")),
                'pai' => $pai,
                'caminhopasta' => $request->nomepasta
            ]
        ]);
    }
}
