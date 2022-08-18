<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kreait\Firebase\Contract\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Contract\Storage;

class Usuario extends Model
{
    use HasFactory;
    private $auth;
    private $storage;

    public function __construct(Auth $auth, Storage $storage)
    {
        $this->auth = $auth;
        $this->storage = $storage;
        $this->storageClient = $storage->getStorageClient();
        $this->defaultBucket = $storage->getBucket();
    }
    public function mostrar()
    {
        $object = $this->defaultBucket->objects();
        $departamentos = [];
        foreach ($object as $obj) {
            if (isset($obj->info()['metadata']['departamento']) && isset($obj->info()['metadata']['Raizdepartamento'])) {
                if (in_array($obj->name(), $departamentos) == false) {
                    $departamentos[] = $obj->name();
                }
            }
        }
        $users = $this->auth->listUsers($defaultMaxResults = 1000, $defaultBatchSize = 1000);
        return  [
            'users' => $users,
            'departamentos' => $departamentos
        ];
    }
    public function cadastrar(Request $request)
    {
        $nome = $request->nome;
        $email = $request->email;
        $pass = $request->senha;
        $departamento = $request->get("departamento");
        $departamento = substr($departamento, 0, -1);
        $object = $this->defaultBucket->objects();
        $departamentos = [];
        foreach ($object as $obj) {
            if (isset($obj->info()['metadata']['departamento']) && isset($obj->info()['metadata']['Raizdepartamento'])) {
                if (in_array($obj->name(), $departamentos) == false) {
                    $departamentos[] = $obj->name();
                }
            }
        }
        try {
            
            $newUser = $this->auth->createUserWithEmailAndPassword($email, $pass);
            $this->auth->updateUser($newUser->uid, [
                'displayName' => $nome,
                'photoURL' => 'imagemperfil/default.png'
            ]);

            if ($request->role == 'Administrador')
                $this->auth->setCustomUserClaims($newUser->uid, [
                    'admin' => true,
                    'departamento' => $departamento
                ]);
            else {
                $this->auth->setCustomUserClaims($newUser->uid, [
                    'admin' => false,
                    'departamento' => $departamento
                ]);
            }
        } catch (\Throwable $e) {
            switch ($e->getMessage()) {
                case 'The email address is already in use by another account.':
                    return "caso1";
                    break;
                case 'A password must be a string with at least 6 characters.':
                    
                    return "caso2";
                    break;
                default:
                    dd($e->getMessage());
                    break;
            }
        }
    }
    public function logar(Request $request)
    {
        if ($request->email != null) {
            $email = $request->email;
            $pass = $request->senha;
            try {
                $signInResult = $this->auth->signInWithEmailAndPassword($email, $pass);

                Session::put('firebaseUserId', $signInResult->firebaseUserId());
                Session::put('idToken', $signInResult->idToken());
                Session::put('username', $signInResult->data()["displayName"]);
                $id = $this->auth->getUser($signInResult->firebaseUserId());
                if (!isset($id->customClaims['departamento'])) {
                    $id = $this->auth->updateUser($signInResult->firebaseUserId(), [
                        'displayName' => 'Firebase',
                        'photoURL' => 'imagemperfil/default.png'
                    ]);
                    $id = $this->auth->setCustomUserClaims($signInResult->firebaseUserId(), [
                        'admin' => false,
                        'departamento' => ""
                    ]);
                }
                Session::put('departamento', $id->customClaims['departamento']);
                Session::put('admin', $id->customClaims['admin']);
                $bucket = $this->defaultBucket;
                if ($id->photoUrl == "imagemperfil/default.png") {
                    Session::put('photoUrl', asset('files/default.png'));
                } else {
                    $object = $bucket->object($id->photoUrl);
                    $url = $object->signedUrl(
                        new \DateTime('1 hour'),
                        [
                            'version' => 'v4',
                        ]
                    );
                    Session::put('photoUrl', $url);
                }

                Session::save();
                //  $this->auth->setCustomUserClaims( $signInResult->firebaseUserId(), ['admin' => true]);
                // $user = $this->auth->getUser($signInResult->firebaseUserId());

                return redirect('/inicio');
            } catch (\Throwable $e) {
                switch ($e->getMessage()) {
                    case 'INVALID_PASSWORD':
                        return "caso1";
                        break;
                    case 'EMAIL_NOT_FOUND':
                        return 'caso2';
                        break;
                    default:
                        return $e->getMessage();
                        break;
                }
            }
        }
    }
    public function fazerlogout()
    {
        if (Session::has('firebaseUserId') && Session::has('idToken')) {
            // dd("User masih login.");
            $this->auth->revokeRefreshTokens(Session::get('firebaseUserId'));
            Session::forget('firebaseUserId');
            Session::forget('idToken');
            Session::forget('username');
            Session::forget('departamento');
            Session::forget('admin');
            Session::forget('photoUrl');
            Session::save();
        } else {
            Session::forget('firebaseUserId');
            Session::forget('idToken');
            Session::forget('username');
            Session::forget('departamento');
            Session::forget('admin');
            Session::forget('photoUrl');
            Session::save();
        }
    }
    public function editar(Request $request, $uid)
    {
        $properties = [
            'displayName' => $request->nome,
            'phoneNumber' => $request->telefone,
            'email' => $request->email,
        ];
        try {
            $user=$this->auth->getUser($uid);
            $this->auth->updateUser($uid, $properties);
            if ($request->senha != '') {
                try{$this->auth->changeUserPassword($uid, $request->senha);
                }catch(\Kreait\Firebase\Exception\InvalidArgumentException $e){
                    return $e->getMessage();
                }
            }
            if ($request->role == 'Administrador')
            $this->auth->setCustomUserClaims($uid, [
                'admin' => true,
                'departamento' => substr($request->departamento, 0, -1)]);
        else {
            $this->auth->setCustomUserClaims($uid, [
                'admin' => false,
                'departamento' => substr($request->departamento, 0, -1)]);
        }
       
        } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
            return $e->getMessage();
        }
    }
    public function deletar($uid)
    {

        $idantigo = $this->auth->getUser($uid);
        if ($idantigo->uid != $uid) {
            return '1';
        } else {
            $this->auth->deleteUser($uid);
            return '2';
        }
    }
}
