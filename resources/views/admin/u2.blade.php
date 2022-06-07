@extends("template.tinicio")
@section("titulo", "Documentos")
@section("conteudo")

<ul class="nav menu bg-dark">
  <li class="nav-item" id="logo">
    <a class="navbar-brand m-4" id="logo" aria-current="page" href="#">Storage</a>
  </li>
  <li>
    <form class="w-100 m-2">
      <div class="input-group">
        <button class="btn btn-outline-secondary dropdown-toggle " type="button" data-bs-toggle="dropdown" aria-expanded="false">Pasta</button>
        <ul class="dropdown-menu ">
          <li><a class="dropdown-item" href="#">Action before</a></li>
          <li><a class="dropdown-item" href="#">Another action before</a></li>
          <li><a class="dropdown-item" href="#">Something else here</a></li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li><a class="dropdown-item" href="#">Separated link</a></li>
        </ul>
        <input type="text" class="form-control" placeholder="Buscar" aria-label="Text input with 2 dropdown buttons" required>
        <button class="btn btn-outline-secondary " type="submit">&#xF002;</button>

      </div>
    </form>
  </li>

  <li class="nav-item ">
    <div class="my-container">
      <div class="dropdown me-3">
        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" style="color:white;" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
          <span class="text-secondary">Carlos alberto de nobrega</span>
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
          <li><a class="dropdown-item" href="#">Profile</a></li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li><a class="dropdown-item" href="#">Sign out</a></li>
        </ul>
      </div>
    </div>
  </li>
</ul>
<div class="d-flex alt ">
  <nav class="nav flex-column w-25 p-2 bg-dark navl">
    <a class="nav-link active text-secondary caminho-nav" aria-current="page" href="/inicio"><i class="fas fa-home nav-link text-secondary"></i> Inicio</a>
    <a class="nav-link text-secondary caminho-nav-select" href="/usuarios"><i class="fas fa-users-cog nav-link text-secondary"></i> Usuários</a></li>
    <a class="nav-link text-secondary caminho-nav" href="/documento"><i class="far fa-file nav-link text-secondary"></i> Documentos</a></li>
    <a class="nav-link text-secondary caminho-nav" href="#"><i class="fas fa-search nav-link text-secondary"></i> Buscar</a></li>

  </nav>

  <div class="w-100 d-flex flex-column">
    <div class="caixacaminho2  m-2 mt-0">
      <div class="caminho">Usuarios/</div>
    </div>
    <div class="h-100 d-flex flex-column align-items-center justify-content-between">

      <table class="table responsive table-borderless bg-light wid m-2 rounded shadow" id="table">
        <colgroup>
          <col width="50">
          <col width="50">
          <col width="50">
          <col width="50">
          <col width="50">
          <col width="50">
          <col width="0">
        </colgroup>
        <thead>
          <tr>
            <th>Nome do usuário</th>
            <th>Email de login</th>
            <th>Tipo de usuário</th>
            <th>Departamento</th>
            <th>Status</th>
            <th>Data de cadastro</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $user)
          <tr>
            <td>{{$user->displayName}}</td>

            <td>{{ $user->email}}</td>
            @if(isset($user->customClaims['admin'])&&$user->customClaims['admin']==true)
            <td>{{ 'Admin'}}</td>
            @else
            <td>{{ 'Comum'}}</td>
            @endif
            <td>@if(isset($user->customClaims['departamento'])){{$user->customClaims['departamento']}}@endif</td>
            @if($user->disabled==false)
            <td>
              <p class="statusfalse">Ativada</p>
            </td>
            @else
            <td>
              <p class="statustrue">Desativada</p>
            </td>
            @endif
            <td>{{ $user->metadata->createdAt->format('Y-m-d  H:i:s')}}</td>
            <td>
              <div class="d-flex w-100">
                <div class="btn-group p-0 m-0">
                  <form action="/usuarios/{{$user->uid}}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE" />
                    <button type='submit' id="deletar" class="d-none acao-icon"></button>
                    <label class="acao-icon h-100 " for="deletar"><i for="deletar" class="far fa-trash-alt text-danger" style="font-size:20px;"></i></label>
                  </form>
                </div>

                <div class="btn-group p-0 ms-2 me-0">
                  <form action="" method="POST" name="download">
                    @csrf
                    <button type='submit' onclick="return confirm('Deseja fazer download?')" id="download" class="d-none"></button>
                    <label class="acao-icon h-100 " for="download"><i for="download" class="fas fa-user-edit " style="font-size:20px;"></i></label>
                  </form>
                </div>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class=" p-3 w-100 d-flex  justify-content-center">
        <button type="button" class="btn btn-primary rounded p-1 btncadastrarusuario" data-toggle="modal" data-target="#exampleModal">Cadastrar Usuários</button>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">

            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cadastro de usuários</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">

                <form action="{{route('usuarios')}}" method="post" class="row">
                  @csrf
                  <div class="form group">
                    <label>Nome</label>
                    <input type="text" class="form-control" name="nome" required>
                  </div>
                  <div class="form group">
                    <label>Email</label>
                    <input type="text" class="form-control" name="email" required>
                  </div>
                  <div class="form group">
                    <label>Senha</label>
                    <input type="password" class="form-control" name="senha" required>
                  </div>
                  <div class="form group">
                    <label>Departamento</label>
                    <select name="departamento" class="form-control" required>
                      <option value="" selected="selected"></option>
                      @foreach($departamentos as $depar)

                      <option value="{{$depar}}">{{$depar}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form group">
                    <label>Cargo</label>
                    <select name="role" class="form-control" required>

                      <option value="Administrador" selected="selected">Administrador</option>
                      <option value="Comum">Comum</option>
                    </select>
                  </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  @endsection