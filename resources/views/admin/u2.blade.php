@extends("template.tinicio")
@section("titulo", "Usuários")
@section("conteudo")


<div class="d-flex alt ">
  <nav class="nav flex-column w-25 p-2 bg-dark navl">
    <a class="nav-link active text-secondary caminho-nav" aria-current="page" href="/inicio"><i class="fas fa-home nav-link text-secondary"></i> Inicio</a>
    <a class="nav-link text-secondary caminho-nav-select" href="/usuarios"><i class="fas fa-users-cog nav-link text-secondary"></i> Usuários</a></li>
    <a class="nav-link text-secondary caminho-nav" href="/documento"><i class="far fa-file nav-link text-secondary"></i> Documentos</a></li>
    <a class="nav-link text-secondary caminho-nav" href="/busca"><i class="fas fa-search nav-link text-secondary"></i> Buscar</a></li>

  </nav>

  <div class="w-100 d-flex flex-column">
    <div class="caixacaminho2  m-2 mt-0">
      <div class="caminho">
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
          <ol class="m-0 breadcrumb">
            <li class="breadcrumb-item"><a href="usuarios" class="text-decoration-none">Usuário</a></li>

          </ol>
        </nav>
      </div>
    </div>
    <div class="h-100 d-flex flex-column align-items-center justify-content-between">

      <table class="table responsive  table-dark table-borderless  table-hover  wid m-2 rounded shadow-lg">
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
          <tr class="text-center">
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

          <tr class="text-center">
            <td><img src="{{Session::get('photoUrl')}}" alt="" width="24" height="24" class="rounded-circle me-2">{{$user->displayName}}</td>

            <td>{{ $user->email}}</td>
            @if(isset($user->customClaims['admin'])&&$user->customClaims['admin']==true)
            <td>{{ 'Admin'}}</td>
            @else
            <td>{{ 'Comum'}}</td>
            @endif
            <td>@if(isset($user->customClaims['departamento'])){{$user->customClaims['departamento']}}@endif</td>
            @if($user->disabled==false)
            <td style=" vertical-align: center;">
              <p class="statusfalse ">Ativada</p>
            </td>
            @else
            <td style=" text-align: center; ">
              <p class="statustrue">Desativada</p>
            </td>
            @endif
            <td>{{ $user->metadata->createdAt->format('d-m-Y  H:i:s')}}</td>
            <td>
              <div class="d-flex w-100 justify-content-center">
                <div class="btn-group p-0 m-0">
                  <form action="/usuarios/{{$user->uid}}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE" />
                    <button type='submit' class="border-0 bg-dark p-0" onclick="return confirm('Deseja Excluir esse usuário?')" class="acao-icon">
                      <i for="deletar" class="far fa-trash-alt text-danger" style="font-size:20px;"></i></button>

                  </form>
                </div>

                <div class="btn-group p-0 ms-2 me-0">
                  <!-- Modal -->
                  <div class="modal fade" id="editarmodal-{{$user->uid}}" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header bg-dark">
                          <h5 class="modal-title text-light" id="editarmodalLabel">{{$user->displayName}}</h5>
                          <button type="button" class="close btn-danger" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="  d-flex flex-column justify-content-around">
                            <div class="d-flex align-items-center justify-content-center ">
                              <img src="{{Session::get('photoUrl')}}" width="150" height="150" class="rounded">
                            </div>
                            <hr class="bg-dark">
                            <form action="/usuarios/{{$user->uid}}/edit" method="get" class="col d-flex flex-row justify-content-around">
                              @csrf
                              <input type="hidden" name="id" value="{{$user->uid}}"/>
                              <div class="col-5">
                                <label class="text-dark">Nome</label>
                                <input type="text"class="form-control" name="nome"value="{{$user->displayName}}" >

                                <label class="text-dark">Email</label>
                                <input type="email"class="form-control"name="email"value="{{$user->email}}">
                              </div>
                              <div class="col-5">
                                <label class="text-dark">Uid</label>
                                <input class="form-control"value="{{$user->uid}}" disabled readonly>
                                <label class="text-dark"name="senha">Senha</label>
                                <input type="password"class="form-control"name="senha">
                                <label>Cargo</label>
                                <select name="role" class="form-control" required>
                                <option value=""selected="selected"></option>
                                  <option value="Administrador" >Administrador</option>
                                  <option value="Comum">Comum</option>
                                </select>
                                <label class="text-dark">Departamento</label>
                                <select name="departamento" class="form-control" name="departamento"required>
                                  <option value="" selected="selected"></option>
                                  @foreach($departamentos as $depar)

                                  <option value="{{$depar}}">{{$depar}}</option>
                                  @endforeach
                                </select>
                              </div>
                         

                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                          <button type="submit" class="btn btn-dark caminho-nav shadow-lg">Salvar</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <!-- Modal -->
                  <button type="button" id="edit" class="bg-dark border-0 p-0 " data-toggle="modal" data-target="#editarmodal-{{$user->uid}}"><i for="edit" class="fas fa-user-edit text-light" style="font-size:20px;"></i></button>


                </div>
              </div>
            </td>
          </tr>

          @endforeach
        </tbody>
      </table>
      <div class=" p-3 w-100 d-flex  justify-content-center">
        <button type="button" class="btn btn-dark caminho-nav shadow-lg" data-toggle="modal" data-target="#exampleModal">Cadastrar Usuários</button>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">

            <div class="modal-content">
              <div class="modal-header bg-dark">
                <h5 class="modal-title text-light" id="exampleModalLabel">Cadastro de usuários</h5>
                <button type="button" class="close btn-danger" data-dismiss="modal" aria-label="Close">
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
                <button type="submit" class="btn btn-dark caminho-nav shadow-lg">Salvar</button>
              </div>
              </form>
            </div>
          </div>
        </div>
        <!-- Modal -->
      </div>
    </div>

  </div>

  @endsection