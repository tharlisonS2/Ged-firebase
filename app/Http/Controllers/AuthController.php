<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Contract\Storage;
use Illuminate\Support\Facades\Session;
use App\Models\Usuario;

class AuthController extends Controller
{
    public function __construct(Auth $auth, Storage $storage)
    {
        $this->auth = $auth;
        $this->storage = $storage;
        $this->storageClient = $storage->getStorageClient();
        $this->defaultBucket = $storage->getBucket();
    }

    public function show()
    {
        $usuario = new Usuario($this->auth, $this->storage);
        $vars[] = $usuario->mostrar();
        return view('admin.u2', [
            'users' => $vars[0]['users'],
            'departamentos' =>  $vars[0]['departamentos']
        ]);
    }
    public function store(Request $request)
    {
        $usuario = new Usuario($this->auth, $this->storage);

        if ($usuario->cadastrar($request) == "caso1") {
            return redirect('/usuarios')->with('status', 'Este email ja está em uso!');
        } elseif ($usuario->cadastrar($request) == "caso2") {
            return redirect('/usuarios')->with('status', 'A senha deve ter no minimo 6 caracteres!');
        } elseif ($usuario->cadastrar($request)) {
            return redirect('/usuarios')->with('status', 'Cadastro processado!');
        }
    }
    public function login(Request $request)
    {
        if (Session::has('firebaseUserId')) {
            return redirect('inicio');
        } else {
            $usuario = new Usuario($this->auth, $this->storage);
            if ($usuario->logar($request) == "caso1") {
                return redirect('/login')->with('status', 'Senha Invalida!');
            } elseif ($usuario->logar($request) == "caso2") {
                return redirect('/login')->with('status', 'Esse email não existe!');
            } elseif ($usuario->logar($request)) {
                return redirect('/inicio')->with('status', 'Sucesso');
            }
            return view("login");
        }
    }
    public function logout()
    {
        $usuario = new Usuario($this->auth, $this->storage);
        $usuario->fazerlogout();
        return view("login");
    }
    public function update(Request $request, $id)
    {
    }
    public function edit(Request $request, $uid)
    {
        $usuario = new Usuario($this->auth, $this->storage);
        if($usuario->editar($request, $uid)){
            return redirect('/usuarios')->with('status', 'Senha deve conter 6 caracteres!');

        }
        return redirect('/usuarios')->with('status', 'Usuário atualizado!');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uid)
    {
        $usuario = new Usuario($this->auth, $this->storage);
        $escolha = $usuario->deletar($uid);
        if ($escolha == '1') {
            return redirect('usuarios')->with('status', 'Ação invalida');
        } elseif ($escolha == '2') {
            return redirect('/usuarios')->with('status', 'Usuário deletado');;
        }
    }
}
