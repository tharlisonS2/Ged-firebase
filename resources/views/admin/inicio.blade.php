@extends("template.tinicio")
@section("titulo", "inicio")
@section("conteudo")


<div class="d-flex w-100 alt ">

  <nav class="nav flex-column w-25 p-2 bg-dark navl">
    <a class="nav-link active text-secondary caminho-nav-select" aria-current="page" href="/inicio"><i class="fas fa-home nav-link text-secondary"></i> Inicio</a>
    @if(Session::get('admin')==true)
    <a class="nav-link active text-secondary caminho-nav" aria-current="page" href="/usuarios"><i class="fas fa-users-cog nav-link text-secondary"></i> Usuários</a>
    @else
    @endif
    <a class="nav-link text-secondary caminho-nav" href="/documento"><i class="far fa-file nav-link text-secondary"></i> Documentos</a></li>
    <a class="nav-link text-secondary caminho-nav" href="/busca"><i class="fas fa-search nav-link text-secondary"></i> Buscar</a></li>

  </nav>
  <div class="d-flex w-100  rounded flexconteudoi">
    <div class="caixacaminho2  m-2 mt-0">
      <div class="caminho">
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
          <ol class="m-0 breadcrumb">
            <li class="breadcrumb-item"><a href="inicio" class="text-decoration-none">Inicio</a></li>

          </ol>
        </nav>
      </div>
    </div>

    <div class="wid h-100 bg-light m-2 rounded">
      <div class="d-flex flex-row m-5  ">
        <div class="card border-0 shadow bgimage bg-light me-5" style="width: 18rem;">
          <div class="card-body  ">
            <div class="d-flex flex-row ">
              <div>
                </p>
                <p class=" fs-3">{{$dadosdoc[0]}} </p>
                <p class="fs-5">Objetos</p>
              </div>
              <div class="mx-3">
                </p>
                <p class=" fs-3">{{number_format($dadosdoc[1]/1024 ,1)}} </p>
                <p class="fs-5">Mb</p>
              </div>
            </div>
            <a href="/documento" class="btn btn-dark text-light w-100 caminho-nav shadow">Acessar Documentos<i class="fa-solid fa-angle-right ms-5"></i></a>
          </div>
        </div>
        <div class="card border-0 shadow bgimage2 bg-light" style="width: 18rem;">
          <div class="card-body  ">
            <div class="d-flex flex-row ">
              <div>
                </p>
                <p class=" fs-3">{{$dadosuser}} </p>
                <p class="fs-5">Usuários</p>
              </div>

            </div>
            <a href="/usuarios" class="btn btn-dark text-light w-100 caminho-nav shadow">Acessar Usuarios<i class="fa-solid fa-angle-right ms-5"></i></a>
          </div>
        </div>
      </div>

    </div>


    @endsection