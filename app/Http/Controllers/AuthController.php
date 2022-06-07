<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Auth\UserMetaData;
use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Contract\Storage;

class AuthController extends Controller
{
    protected $auth, $database, $storage;
    public function __construct(Auth $auth,Storage $storage)
    {
        $this->auth = $auth;
        $this->storage = $storage;
        $this->storageClient = $storage->getStorageClient();
        $this->defaultBucket = $storage->getBucket();

    }

    public function show(){
        $object = $this->defaultBucket->objects();
        $departamentos=[];
        foreach ($object as $obj) {
            if (isset($obj->info()['metadata']['departamento'])&&isset($obj->info()['metadata']['Raizdepartamento'])){
                if (in_array($obj->name(), $departamentos)==false){
                        $departamentos[]=$obj->name();
                }

            }
        }
        $users=$this->auth->listUsers($defaultMaxResults = 1000, $defaultBatchSize = 1000);
        return view('admin.u2',[
            'users'=>$users,
            'departamentos'=>$departamentos
        ]);
    }
    public function store(Request $request)
    {
        $nome=$request->nome;
        $email = $request->email;
        $pass = $request->senha;
        $departamento=$request->get("departamento");
        $departamento= substr($departamento, 0, -1);
        $object = $this->defaultBucket->objects();
        $departamentos=[];
        foreach ($object as $obj) {
            if (isset($obj->info()['metadata']['departamento'])&&isset($obj->info()['metadata']['Raizdepartamento'])){
                if (in_array($obj->name(), $departamentos)==false){
                        $departamentos[]=$obj->name();
                }

            }
        }
        try {
            $newUser = $this->auth->createUserWithEmailAndPassword($email, $pass);
            $this->auth->updateUser($newUser->uid,[
                'displayName'=>$nome,
                'photoURL' => 'imagemperfil/default.png'  
             ]); 

            if($request->role=='Administrador')
                $this->auth->setCustomUserClaims( $newUser->uid, [
                    'admin' => true,
                    'departamento' => $departamento]);
            else{
                $this->auth->setCustomUserClaims( $newUser->uid, [
                    'admin' => false,
                    'departamento' => $departamento
                ]);
         }
           
            //$this->auth->updateUser($newUser->uid,[
             //       'cargo'=>'usuario'  
           // ]);        
                          //  $this->auth->setCustomUserClaims( $signInResult->firebaseUserId(), ['admin' => true]);
               // $user = $this->auth->getUser($signInResult->firebaseUserId());

            $users=$this->auth->listUsers();
            return view('admin.usuarios',[
                'users'=>$users,
                'departamentos'=>$departamentos
            ]);
        } catch (\Throwable $e) {
            switch ($e->getMessage()) {
                case 'The email address is already in use by another account.':
                    return redirect('/usuarios')->with('status','Email ja registrado!');
                    break;
                case 'A password must be a string with at least 6 characters.':
                    return redirect('/usuarios')->with('status','Senha deve conter ao menos 6 caracteres!');
                    break;
                default:
                    dd($e->getMessage());
                    break;
            }
        }
    }
    public function login(Request $request)
    {
        if(Session::has('firebaseUserId')){
            return redirect('inicio');
        }else if($request->email!=null){

            $email = $request->email;
            $pass = $request->senha;
           
            try {
                $signInResult = $this->auth->signInWithEmailAndPassword($email, $pass);
                // dump($signInResult->data());

                Session::put('firebaseUserId', $signInResult->firebaseUserId());
                Session::put('idToken', $signInResult->idToken());
                Session::put('username',$signInResult->data()["displayName"]);
                $id=$this->auth->getUser($signInResult->firebaseUserId());
                Session::put('departamento',$id->customClaims['departamento']);
                Session::put('admin',$id->customClaims['admin']);
                $bucket = $this->defaultBucket;
                $object = $bucket->object($id->photoUrl);
                $url = $object->signedUrl(
                    new \DateTime('1 hour'),
                    [
                        'version' => 'v4',
                    ]
                );
                Session::put('photoUrl',$url);
                Session::save();
              //  $this->auth->setCustomUserClaims( $signInResult->firebaseUserId(), ['admin' => true]);
               // $user = $this->auth->getUser($signInResult->firebaseUserId());

                return redirect('/inicio');
            } catch (\Throwable $e) {
                switch ($e->getMessage()) {
                    case 'INVALID_PASSWORD':
                        return redirect('/login')->with('status','Senha Invalida!');
                        break;
                    case 'EMAIL_NOT_FOUND':
                        return redirect('/login')->with('status','Email Inexistente!');
                        break;
                    default:
                        return $e->getMessage();
                        break;
                }
            }
        }
        return view("login");
    }
    public function logout()
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
            return view("login");
        } else {
            dd("User belum login.");
        }
    }

    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uid)
    {
     
        $idantigo = $this->auth->getUser($uid);
        if($idantigo->uid!=$uid){
            return redirect('usuarios')->with('status','Ação invalida');
        }else{
            $this->auth->deleteUser($uid);
            return redirect('/usuarios');
        }
    }
}
