@extends("template.templateinterface")
@section("titulo", "Usuarios")
@section("conteudo")
<nav id="menu-l">
  <ul>
    <li><a href="/inicio"><i class="fas fa-home"></i> Inicio</a></li>
    <li><a href="/usuarios"><i class="fas fa-users-cog"></i> Usuários</a></li>
    <li><a href="/documento"><i class="far fa-file"></i> Documentos</a></li>
    <li><a href="#"><i class="fas fa-search"></i> Buscar</a></li>
  </ul>
</nav>


<div class="listausuario0">
  <div class="listausuario">

    <table class="table responsive table-borderless ">
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
            <div class="btn-group p-0 ml-2">
              <form action="/usuarios/{{$user->uid}}" method="POST">
                @csrf
                <input type="hidden" name="_method" value="DELETE" />
                <button type='submit' class="btn btn-danger"><i class="far fa-trash-alt rounded "></i></button>
              </form>
            </div>
            <div class="btn-group p-0 ml-2">
              <button type='submit' class="btn btn-primary"><i class="fas fa-user-edit rounded"></i></button>
            </div>
          </td>
        </tr>

        @endforeach
      </tbody>
    </table>

  </div>
  <div class="caixabotoes">

    <!-- Button trigger modal -->

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
@endsection