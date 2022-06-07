@extends("template.tinicio")
@section("titulo", "inicio")
@section("conteudo")

<ul class="nav menu bg-dark">
  <li class="nav-item" id="logo">
    <a class="navbar-brand m-4" id="logo" aria-current="page" href="#">Storage</a>
  </li>
  <li>
    <form class="w-100 m-2">
      <div class="input-group">
        <button class="btn btn-secondary dropdown-toggle " type="button" data-bs-toggle="dropdown" aria-expanded="false">Pasta</button>
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
        <button class="btn btn-secondary " type="submit"><i class="fa-solid fa-magnifying-glass "></i></button>

      </div>
    </form>
  </li>

  <li class="nav-item hover-nome">
    <div class="my-container ">
      <div class="dropdown me-3 ">
        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" style="color:white;" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="{{Session::get('photoUrl')}}" alt="" width="32" height="32" class="rounded-circle me-2">
          <span class="text-light ">Carlos alberto de nobrega</span>
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
<div class="d-flex w-100 alt ">

  <nav class="nav flex-column w-25 p-2 bg-dark navl">
    <a class="nav-link active text-secondary caminho-nav-select" aria-current="page" href="/inicio"><i class="fas fa-home nav-link text-secondary"></i> Inicio</a>
    <a class="nav-link text-secondary caminho-nav" href="/usuarios"><i class="fas fa-users-cog nav-link text-secondary"></i> Usuários</a></li>
    <a class="nav-link text-secondary caminho-nav" href="/documento"><i class="far fa-file nav-link text-secondary"></i> Documentos</a></li>
    <a class="nav-link text-secondary caminho-nav" href="#"><i class="fas fa-search nav-link text-secondary"></i> Buscar</a></li>

  </nav>
  <div class="d-flex w-100  rounded flexconteudoi">
    <div class="caminho  m-3 mt-0 mb-0">
      <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="m-0 breadcrumb">
          <li class="breadcrumb-item active" aria-current="page">Inicio</li>
        </ol>
      </nav>
    </div>

    <div class="wid h-100 bg-light m-2 rounded">

    </div>
  </div>

</div>


@endsection