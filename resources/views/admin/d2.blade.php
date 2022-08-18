@extends("template.tinicio")
@section("titulo", "Documentos")
@section("conteudo")

<div class="d-flex alt ">
  <nav class="nav flex-column w-25 p-2 bg-dark navl">
    <a class="nav-link active text-secondary caminho-nav" aria-current="page" href="/inicio"><i class="fas fa-home nav-link text-secondary"></i> Inicio</a>
    <a class="nav-link text-secondary caminho-nav" href="/usuarios"><i class="fas fa-users-cog nav-link text-secondary"></i> Usuários</a></li>
    <a class="nav-link text-secondary caminho-nav-select" href="/documento"><i class="far fa-file nav-link text-secondary"></i> Documentos</a></li>
    <a class="nav-link text-secondary caminho-nav" href="/busca"><i class="fas fa-search nav-link text-secondary"></i> Buscar</a></li>

  </nav>
  <div class=" navl bg-light upload shadow-lg ">
    <div class="w-100 ">
      @foreach($buckets as $object1)

      @if($object1->info()["size"]==0 )
      <div class="modal fade" id="myModal-{{$object1->info()['generation']}}" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-dark">
              <h5 class="modal-title text-light" id="">Criar Pasta</h5>
              <button type="button" class="close btn-danger" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">

              <form action="/documento/criarpasta/{{$object1->info()['generation']}}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="input-group mb-3">
                  <span class="input-group-text" id="basic-addon1">{{$object1->name()}}</span>
                  <input type="text" class="form-control" placeholder="Nome da pasta" aria-label="nomepasta" name="nomepasta" aria-describedby="basic-addon1" onkeypress="return ApenasLetras(event,this);" pattern="[a-zA-Z]+$" required>
                </div>

            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-dark caminho-n">Salvar</button>
            </div>
            </form>
          </div>
        </div>
      </div>
      @endif

      @if($object1->info()["size"]==0&&isset($object1->info()['metadata']['Raizdepartamento']))

      <ul id="myUL">
        <li class=""><span class="caret px-0 ms-2 text-primary fs-5" id="campopasta"><a class="text-primary fs-6 " href="/documento/{{$object1->info()['generation']}}">{{$object1->name()}}</a> <button class="btn p-0 w-0 h-0 mx-0" data-toggle="modal" data-target="#myModal-{{$object1->info()['generation']}}"><i class="fa-solid fa-folder-plus p-0 m-0 w-0 h-0" style="color:green;"></i></button></span>


          <ul class="nested">

            @foreach($buckets2 as $objectfilho)

            @if(isset($objectfilho->info()['metadata']['pai']))

            @if($object1->name()==$objectfilho->info()['metadata']['pai'])

            <li><span id="txt-ellipses" class="caret px-0"><a href="/documento/{{$objectfilho->info()['generation']}}">{{substr(substr($objectfilho->name(), 0,strrpos($objectfilho->name(), "/")), strrpos(substr($objectfilho->name(),  0,strrpos($objectfilho->name(), "/")), "/") )}}</a><button class="btn p-0 w-0 h-0 mx-0" data-toggle="modal" data-target="#myModal-{{$objectfilho->info()['generation']}}"><i class="fa-solid fa-folder-plus p-0 m-0 w-0 h-0" style="color:green;"></i></button></span>


              @elseif(isset($filho)&&$filho==$objectfilho->info()['metadata']['pai'])

              <ul class="nested">
                <li><span id="txt-ellipses" class="caret "><a href="/documento/{{$objectfilho->info()['generation']}}">{{substr(substr($objectfilho->name(), 0,strrpos($objectfilho->name(), "/")), strrpos(substr($objectfilho->name(),  0,strrpos($objectfilho->name(), "/")), "/") )}}</a></span></li>
              </ul>

              @endif
              @endif

              @php
              if(isset($objectfilho->info()['metadata']['pai']))
              if($objectfilho->info()['metadata']['pai']==$object1->name())
              $filho=$objectfilho->name()
              @endphp
              @endforeach

          </ul>
        </li>
      </ul>

      @endif
      @endforeach
      </li>
      </ul>
    </div>
    <script>
      var toggler = document.getElementsByClassName("caret");
      var i;

      for (i = 0; i < toggler.length; i++) {
        toggler[i].addEventListener("click", function() {
          this.parentElement.querySelector(".nested").classList.toggle("active");
          this.classList.toggle("caret-down");
        });
      }
    </script>
    <div class="btn-group m-5" role="group" aria-label="Basic example">
      <button type="button" class="btn btn-dark caminho-nav  shadow-lg" data-toggle="modal" data-target="#criardepartamento">+</button>
      <button type="button" class="btn btn-dark caminho-nav shadow-lg " data-toggle="modal" data-target="#exampleModal">Upload</button>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-dark">
            <h5 class="modal-title text-light" id="exampleModalLabel">Upload documento</h5>
            <button type="button" class="close btn-danger" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form action="{{route('documento')}}" enctype="multipart/form-data" method="post">
              @csrf
              <div class="form-group col-15">
                <label for="nome">Nome arquivo: </label>
                <input type="text" id="nome" name="nomearquivo" class="form-control" placeholder="Insira nome" onkeypress="return ApenasLetras(event,this);" pattern="[a-zA-Z]+$">
              </div>
              <div class="form-group col-15">
                <label for="nome">Caminho: </label>
                <select name="departamento" class="form-control" required>
                  <option value="" selected="selected"></option>
                  @foreach($object as $obj) {
                  @if(isset($obj->info()['metadata']['caminhopasta'])) {
                  @if(in_array($obj->name(), $caminhopasta) == false) {
                  @if(Session::get('admin') == true) {
                  {{$caminhopasta[] = $obj->name();}}

                  @elseif(Session::get('admin') == false && $obj->info()['metadata']['departamento'] == Session::get('departamento')) {
                  {{$caminhopasta[] = $obj->name();}}
                  @endif
                  @else


                  @endif
                  @endif
                  @endforeach
                  @foreach($caminhopasta as $depar)

                  <option value="{{$depar}}">{{$depar}}</option>
                  @endforeach
                </select>

              </div></br>
              <input type="file" name="arquivo" class="form-control "></br>

          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-dark caminho-nav shadow-lg ">Salvar</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <!-- Modal -->
    <div class="modal fade" id="visual" tabindex="-1" role="dialog" aria-labelledby="visualLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-dark">
            <h5 class="modal-title text-light" id="visualLabel">Criar Departamento</h5>
            <button type="button" class="close btn-danger" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            @if(isset($url))
            <iframe src="{{$url}}" height="200" width="300" title="description"></iframe>
            @endif
            <form action="/documento/criardepartamento" enctype="multipart/form-data" method="post">
              @csrf
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Raiz/</span>
                <input type="text" class="form-control" placeholder="Nome da pasta" aria-label="nomepasta" name="nomepasta" aria-describedby="basic-addon1" onkeypress="return ApenasLetras(event,this);" pattern="[a-zA-Z]+$">
              </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-dark caminho-nav shadow-lg ">Salvar</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <!-- Modal -->
    <div class="modal fade" id="criardepartamento" tabindex="-1" role="dialog" aria-labelledby="criardepartamentoLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-dark">
            <h5 class="modal-title text-light" id="criardepartamentoLabel">Criar Departamento</h5>
            <button type="button" class="close btn-danger" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form action="/documento/criardepartamento" enctype="multipart/form-data" method="post">
              @csrf
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Raiz/</span>
                <input required type="text" class="form-control" placeholder="Nome da pasta" aria-label="nomepasta" name="nomepasta" aria-describedby="basic-addon1" onkeypress="return ApenasLetras(event,this);" pattern="[a-zA-Z]+$">
              </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-dark caminho-nav shadow-lg " onclick="return confirm('Deseja criar uma nova raiz?')">Salvar</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Modal -->
  </div>
  <div class="w-100">
    <div class="caixacaminho2  m-2 mt-0">
      <div class="caminho">
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
          <ol class="m-0 breadcrumb">
            @if(is_array($caminho))
            @foreach($caminho as $camin)
            <li class="breadcrumb-item"><span href="{{$camin}}" class="text-decoration-none">{{$camin}}</span></li>
            @endforeach
            @else
            <li class="breadcrumb-item"><span href="/documento" class="text-decoration-none">Documento</span></li>
            @endif
          </ol>
        </nav>
      </div>
    </div>
    <table class="table responsive  table-dark table-borderless  table-hover  wid m-2 rounded shadow-lg" id="table">
      <colgroup>
        <col width="20">
        <col width="20">
        <col width="20">
        <col width="20">
        <col width="20">
        <col width="0">
      </colgroup>
      <thead>
        <tr class="text-center">
          <th>ID</th>
          <th>NOME</th>
          <th>TIPO</th>
          <th>TAMANHO</th>
          <th>USUARIO</th>
          <th>AÇOES</th>

        </tr>
      </thead>
      <tbody class="text-center">
        @if(isset($files))
        @foreach($files as $object)
        @if($object->info()['contentType']=='application/x-www-form-urlencoded;charset=UTF-8'||$object->info()["size"]<=0) @else <tr>

          <td>#{{$object->info()['generation']}}</td>
          <td>
            @if($object->info()['contentType']=="application/pdf")
            <i class="fa-solid fa-file-pdf text-danger me-1"></i>@elseif($object->info()['contentType']=="image/png")<i class="fa-solid fa-file-image text-info me-1"></i>
            @else<i class="fa-solid fa-file-lines text-secondary me-1"></i>@endif{{substr($object->name(), strpos($object->name(), '/'))}}

          </td>
          <td>{{$object->info()['contentType']}}</td>

          <td>{{number_format($object->info()['size']/1024,1)}} KBytes</td>
          <td>@if(isset($object->info()['metadata']['author']))
            {{$object->info()['metadata']['author']}}
            @else
            Nenhum
            @endif
          </td>
          <td class="text-center">
            <div class="d-flex justify-content-center">
              <div class="btn-group p-0 m-0">
                <form action="/documento/{{$object->info()['generation']}}" method="POST" name="delete">
                  @csrf
                  <input type="hidden" name="_method" value="DELETE" />
                  <button type='submit' id="deletar" class="bg-dark border-0 p-0 acao-icon" onclick="return confirm('Deseja deletar o arquivo?')">
                    <i for="deletar" class="far fa-trash-alt text-danger" style="font-size:20px;"></i></button>
                </form>
              </div>
              <div class="btn-group p-0 mx-3 ">

                <form action="/visualizar/{{$object->info()['generation']}}" method="POST" name="visualizar">
                  @csrf
                  <button type='submit' class="bg-dark border-0 p-0" id="visualizar" data-toggle="" data-target="#">
                    <i for="visualizar" class="text-center fas fa-eye text-info" style="font-size:20px;"></i></button>
                </form>
              </div>
              <div class="btn-group p-0 m-0">
                <form action="/download/{{$object->info()['generation']}}" method="POST" name="download">
                  @csrf
                  <button type='submit' class="bg-dark border-0 p-0 acao-icon" id="download" onclick="return confirm('Deseja Fazer download do arquivo?')">
                    <i for="download" class="fas fa-cloud-download-alt  text-primary" style="font-size:20px;"></i></button>


                </form>
              </div>
            </div>
          </td>
          @endif
          @endforeach
          @endif
      </tbody>
  </div>
</div>


</div>
<script>
  function ApenasLetras(e, t) {
    try {
      if (window.event) {
        var charCode = window.event.keyCode;
      } else if (e) {
        var charCode = e.which;
      } else {
        return true;
      }
      if (
        (charCode > 64 && charCode < 91) ||
        (charCode > 96 && charCode < 123) ||
        (charCode > 191 && charCode <= 255) // letras com acentos
      ) {
        return true;
      } else {
        return false;
      }
    } catch (err) {
      alert(err.Description);
    }
  }
</script>
<script>
  $('a.btn').on('click', function(e) {
    e.preventDefault();
    var url = $(this).attr('href');
    $(".modal-body").html('<iframe width="500px" height="500px" frameborder="0" scrolling="yes" allowtransparency="true" src="' + url + '"></iframe>');
  });
</script>
@endsection