@extends("template.templateinterface")
@section("titulo", "Documentos")
@section("conteudo")
<nav id="menu-l">
  <ul>
    <li><a href="/inicio"><i class="fas fa-home"></i> Inicio</a></li>
    <li><a href="/usuarios"><i class="fas fa-users-cog"></i> Usuários</a></li>
    <li><a href="/documento"><i class="far fa-file"></i> Documentos</a></li>
    <li><a href="#"><i class="fas fa-search"></i> Buscar</a></li>
  </ul>
</nav>

<div class="listapasta0">
  <div class="listapasta1">
    <div class="treeview w-100 mw-100  treediv">

      @foreach($buckets as $object1)

      @if($object1->info()["size"]==0 )
      <div class="modal fade" id="myModal-{{$object1->info()['generation']}}" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="">Criar Pasta</h5>
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
              <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
            </form>
          </div>
        </div>
      </div>
      @endif

      @if($object1->info()["size"]==0&&isset($object1->info()['metadata']['Raizdepartamento']))

      <ul id="myUL">
        <li class=""><span class="caret px-0 text-primary fs-5" id="campopasta"><a class="text-primary fs-6 "href="/documento/{{$object1->info()['generation']}}">{{$object1->name()}}</a> <button class="btn p-0 w-0 h-0 mx-1" data-toggle="modal" data-target="#myModal-{{$object1->info()['generation']}}"><i class="fa-solid fa-folder-plus p-0 m-0 w-0 h-0" style="color:green;"></i></button></span>


          <ul class="nested">

            @foreach($buckets2 as $objectfilho)

            @if(isset($objectfilho->info()['metadata']['pai']))

            @if($object1->name()==$objectfilho->info()['metadata']['pai'])

            <li><span class="caret px-0" id="campopasta"><a href="/documento/{{$objectfilho->info()['generation']}}">{{$objectfilho->name()}}</a><button class="btn p-0 w-0 h-0 mx-1" data-toggle="modal" data-target="#myModal-{{$objectfilho->info()['generation']}}"><i class="fa-solid fa-folder-plus p-0 m-0 w-0 h-0" style="color:green;"></i></button></span>


              @elseif(isset($filho)&&$filho==$objectfilho->info()['metadata']['pai'])

              <ul class="nested">
                <li><span class="caret "><a href="/documento/{{$objectfilho->info()['generation']}}">{{$objectfilho->name()}}</a></span></li>
                <button class="btn p-0 w-0 h-0 mx-1" data-toggle="modal" data-target="#myModal-{{$objectfilho->info()['generation']}}"><i class="fa-solid fa-folder-plus p-0 m-0 w-0 h-0" style="color:green;"></i></button>
              </ul>

              @else
              <ul class="nested">
                <li><span class="caret"><a href="/documento/{{$objectfilho->info()['generation']}}">{{$objectfilho->name()}}</a></span></li>
                <button class="btn p-0 w-0 h-0 mx-1" data-toggle="modal" data-target="#myModal-{{$objectfilho->info()['generation']}}"><i class="fas fa-plus-square p-0 m-0 w-0 h-0" style="color:green;"></i></button>
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
    </div>
    <!-- Button trigger modal -->
    <div class="btn-group p-5" role="group" aria-label="Basic example">
      <button class="btn btn-primary rounded p-1 btncadastrarusuario" data-toggle="modal" data-target="#criardepartamento">+</button>
      <button type="button" class="btn btn-primary rounded p-1 btncadastrarusuario" data-toggle="modal" data-target="#exampleModal">Upload</button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Upload documento</h5>
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
              <!--<div class="form-group col-15">
                <label for="nome">Categoria: </label>
                <input type="text" id="nome" name="categoria" class="form-control" placeholder="Insira categoria" required>
              </div>
              <div class="form-group col-15">
                <label for="nome">Processo: </label>
                <input type="text" id="nome" name="processo" class="form-control" placeholder="Insira processo" required>
              </div>
              <div class="form-group col-15">
                <label for="nome">Cliente: </label>
                <input type="text" id="nome" name="cliente" class="form-control" placeholder="Insira cliente" required>
              </div>
      -->
              <div class="form-group col-15">
                <label for="nome">Caminho: </label>
                <select name="departamento" class="form-control" required>
                  <option value="" selected="selected"></option>
                  @foreach($caminhopasta as $depar)

                  <option value="{{$depar}}">{{$depar}}</option>
                  @endforeach
                </select>
                <div class="form-group row-10 mt-3">
                  <input class="form-check-input align-center" type="checkbox" value="true" name="manterbloqueado" id="flexCheckDefault">
                  <label class="form-check-label" for="flexCheckDefault">
                    Manter Bloqueado
                  </label>
                </div>
              </div></br>
              <input type="file" name="arquivo" class="form-control "></br>

          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary">Salvar</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="criardepartamento" tabindex="-1" role="dialog" aria-labelledby="criardepartamentoLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="criardepartamentoLabel">Criar Departamento</h5>
            <button type="button" class="close btn-danger" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form action="/documento/criardepartamento" enctype="multipart/form-data" method="post">
              @csrf
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Raiz/</span>
                <input type="text" class="form-control" placeholder="Nome da pasta" aria-label="nomepasta" name="nomepasta" aria-describedby="basic-addon1" onkeypress="return ApenasLetras(event,this);" pattern="[a-zA-Z]+$">
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

  <div class="listadocumento">
    <div class="caixacaminho2">
      <div class="caminho">{{$caminho}}</div>
    </div>
    <table class="table responsive table-borderless " id="table">
      <colgroup>
        <col width="20">
        <col width="20">
        <col width="20">
        <col width="20">
        <col width="0">
      </colgroup>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Tipo</th>
          <th>Tamanho</th>
          <th>Ações</th>

        </tr>
      </thead>
      <tbody>
        @if(isset($files))
        @foreach($files as $object)
        @if($object->info()['contentType']=='application/x-www-form-urlencoded;charset=UTF-8'||$object->info()["size"]<=0) @else <tr>

          <td>#{{$object->info()['generation']}}</td>
          <td>{{substr($object->name(), strpos($object->name(), '/'))}}</td>
          <td>{{$object->info()['contentType']}}</td>
          <td>{{$object->info()['size']}} Bytes</td>
          <td>
            <div class="btnicone">
              <div class="btn-group p-0 m-0">
                <form action="/documento/{{$object->info()['generation']}}" method="POST" name="delete">
                  @csrf
                  <input type="hidden" name="_method" value="DELETE" />
                  <button type='submit' class="btn btn-danger"><i class="far fa-trash-alt rounded " style="font-size:15px;"></i></button>
                </form>
              </div>
              <div class="btn-group p-0 mx-1 ">

                <form action="/visualizar/{{$object->info()['generation']}}" method="POST" name="visualizar">
                  @csrf
                  <button type='submit' class="btn btn-info"><i class="text-center fas fa-eye rounded " style="font-size:15px;"></i></button>
                </form>
              </div>
              <div class="btn-group p-0 m-0">
                <form action="/download/{{$object->info()['generation']}}" method="POST" name="download">
                  @csrf
                  <button type='submit' onclick="return confirm('Deseja fazer download?')" class="btn btn-secondary"><i class="fas fa-cloud-download-alt rounded " style="font-size:15px;"></i></button>
                </form>
              </div>
            </div>
          </td>
          </tr>
          @endif
          @endforeach
          @endif
      </tbody>
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
<script>
  /*<div class="btnicone ">
                      <div class="btn-group p-0 ml-2">
                    <form action="/documento/$object->info()['generation']" method="POST" >
                        @csrf
                            <input type="hidden" name="_method" value="DELETE"/>
                            <button type='submit'class="btn btn-danger"><i class="far fa-trash-alt rounded "></i></button>
                    </form>
                    </div>
                   
                
                            <i class="fas fa-eye rounded"></i>
                            <i class="fas fa-cloud-download-alt rounded "></i>
                          </div>
                          */
  $(function() {
    $('a[id="folder"]').click(function(event) {
      event.preventDefault();

      $.ajax({
        url: "/documento/" + 'Students/',
        type: "get",

        dataType: 'json',
        success: function(data) {
          // data is variable result from url,
          // for debug purpose, use console.log for knowing result structure
          // to generate table create variable for necessary tag
          var resulttag = "";
          console.log(data);


          $.each(data.data, function(datas) {}); //to looping result per row and show in tag td or tr using 
          //variable resulttag

          $("#table tbody").append(resulttag);
        },
        error: function(e) {
          console.log(e);
        }
      });

    });
  });
</script>
@endsection