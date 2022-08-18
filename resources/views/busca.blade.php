@extends("template.tinicio")
@section("titulo", "Buscar")
@section("conteudo")


<div class="d-flex w-100 alt ">

  <nav class="nav flex-column w-25 p-2 bg-dark navl">
    <a class="nav-link active text-secondary caminho-nav" aria-current="page" href="/inicio"><i class="fas fa-home nav-link text-secondary"></i> Inicio</a>
    @if(Session::get('admin')==true)
    <a class="nav-link active text-secondary caminho-nav" aria-current="page" href="/usuarios"><i class="fas fa-users-cog nav-link text-secondary"></i> Usuários</a>
    @else
    @endif
    <a class="nav-link text-secondary caminho-nav" href="/documento"><i class="far fa-file nav-link text-secondary"></i> Documentos</a></li>
    <a class="nav-link text-secondary caminho-nav-select" href="/busca"><i class="fas fa-search nav-link text-secondary"></i> Buscar</a></li>

  </nav>
  <div class="d-flex w-100  rounded flexconteudoi">
    <div class="caixacaminho2  m-2 mt-0">
      <div class="caminho">
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
          <ol class="m-0 breadcrumb">
            <li class="breadcrumb-item"><a href="/busca" class="text-decoration-none">Busca</a></li>

          </ol>
        </nav>
      </div>
    </div>
    <div class="wid h-100 bg-light m-2 rounded d-flex flex-column align-items-center">
      <div class="input-group w-50 m-5">
        <form action="/buscar" class="w-100 m-2" method="post">
          @csrf
          <div class="input-group">
            <select class="btn btn-secondary dropdown-toggle p-1 btn-dark caminho-nav" name="tipo" id="inputGroupSelect01">
            @if(isset($setado)&&($setado==true))
              <option selected value="pasta">Pasta</option>
              <option value="usuario">Usuário</option>
              @elseif(isset($setado)&&($setado==false))
              <option selected value="usuario">Usuário</option>
              <option value="pasta">Pasta</option>
              @else
              <option selected value="pasta">Pasta</option>
              <option value="usuario">Usuário</option>
              @endif
            </select>
            <input type="text" name="palavra" class="form-control" placeholder="Buscar" aria-label="Text input with 2 dropdown buttons" required>
            <button type="submit" class="btn btn-secondary btn-dark caminho-nav" type="submit"><i class="fa-solid fa-magnifying-glass "></i></button>

          </div>
        </form>

      </div>

      <table class="table responsive  table-dark table-borderless  table-hover  wid m-2 rounded shadow-lg m-2 w-75">
      @if(isset($setado))
      @if($setado==true)
        <colgroup>
        <col width="20">
        <col width="20">
        <col width="20">
        <col width="20">
      
      </colgroup>
      <thead>
        <tr class="text-center">
          
          <th>ID</th>
          <th>NOME</th>
          <th>TIPO</th>
          <th>TAMANHO</th>

        </tr>
      </thead>
     
      <tbody>
      @foreach($nome as $nomes)
      @if(isset($nomes)&&$nomes->info()['contentType']!="application/octet-stream")
       <tr class="text-center">
        
          <td>{{$nomes->info()['generation']}}</td>
          <td>
            @if($nomes->info()['contentType']=="application/pdf")
            <i class="fa-solid fa-file-pdf text-danger me-1"></i>@elseif($nomes->info()['contentType']=="image/png")<i class="fa-solid fa-file-image text-info me-1"></i>
            @else<i class="fa-solid fa-file-lines text-secondary me-1"></i>@endif{{substr($nomes->name(), strpos($nomes->name(), '/'))}}
           
          </td>
          <td>{{$nomes->info()['contentType']}}</td>
       
          <td>{{number_format($nomes->info()['size']/1024,1)}} KBytes</td>

          @endif
          @endforeach
         
      </tbody>
      @elseif($setado==false)
      <colgroup>
        <col width="20">
        <col width="20">
        <col width="20">
        <col width="20">

      
      </colgroup>
      <thead>
        <tr class="text-center">
          
          <th>FOTO</th>
          <th>NOME</th>
          <th>EMAIL</th>
          <th>DEPARTAMENTO</th>

        </tr>
      </thead>
     
      <tbody>
      @foreach($nome as $nomes)
      @if(isset($nomes))

       <tr class="text-center">
          <td class="text-center">   <img src="{{Session::get('photoUrl')}}" alt="" width="24" height="24" class="rounded-circle me-2"></td>
          <td>{{$nomes->displayName}}</td>
          <td>{{$nomes->email}}</td>
          <td>@if(isset($nomes->customClaims['departamento'])){{$nomes->customClaims['departamento']}}@endif</td>


          @endif
          @endforeach
         
      </tbody>
      @endif
       @endif
      </table>
      
    </div>
  </div>

</div>


@endsection