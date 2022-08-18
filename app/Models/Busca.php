<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Contract\Storage;

class Busca extends Model
{
    use HasFactory;
    protected $auth;
    protected $storage;
    protected $palavra;
    public function __construct(Auth $auth, Storage $storage)
    {
        $this->auth = $auth;
        $this->storage = $storage;
        $this->storageClient = $storage->getStorageClient();
        $this->defaultBucket = $storage->getBucket();
    }
    public function buscarpasta($palavra)
    {
        $object = $this->defaultBucket->objects();
        $nome = [];

        foreach ($object as $objects) {
            if (Session::get('admin') != true) {
                if (str_contains($objects->name(), $palavra) == true && isset($objects->info()['metadata']['raizdepartamento']) && $objects->info()['metadata']['raizdepartamento'] == Session::get('departamento') . '/') {
                    $nome[] = $objects;
                }
            } else {
                if (str_contains($objects->name(), $palavra) == true) {
                    $nome[] = $objects;
                }
            }
        }
        return $nome;
    }
    public function buscarusuario($palavra)
    {
        $nome = [];
        $users = $this->auth->listUsers($defaultMaxResults = 1000, $defaultBatchSize = 1000);
        foreach ($users as $objects) {
            if (str_contains($objects->displayName, $palavra) == true) {
                $nome[] = $objects;
            }
        }
        return $nome;
    }
    public function usuarioquantidade()
    {
        $quantidade = 0;
        $users = $this->auth->listUsers($defaultMaxResults = 1000, $defaultBatchSize = 1000);
        foreach ($users as $user) {
            $quantidade++;
        }
        return $quantidade;
    }
    public function documentoquantidade()
    {
        $object = $this->defaultBucket->objects();
        $tamanho = 0;
        $documentos = 0;
        foreach ($object as $objects) {
            $tamanho = $tamanho + $objects->info()['size'];
            $documentos++;
        }
        $dados[] = $documentos;
        $dados[] = $tamanho;
        return $dados;
    }
}
