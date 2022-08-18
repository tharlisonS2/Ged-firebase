@extends("template.tinicio")
@section("titulo", "inicio")
@section("conteudo")


<div class="d-flex w-100 alt ">

  <nav class="nav flex-column w-25 p-2 bg-dark navl">
    <a class="nav-link active text-secondary caminho-nav" aria-current="page" href="/inicio"><i class="fas fa-home nav-link text-secondary"></i> Inicio</a>
    <a class="nav-link text-secondary caminho-nav" href="/usuarios"><i class="fas fa-users-cog nav-link text-secondary"></i> Usuários</a></li>
    <a class="nav-link text-secondary caminho-nav" href="/documento"><i class="far fa-file nav-link text-secondary"></i> Documentos</a></li>
    <a class="nav-link text-secondary caminho-nav-select" href="/busca"><i class="fas fa-search nav-link text-secondary"></i> Buscar</a></li>

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
    <div class="wid h-100 bg-light m-2 rounded d-flex flex-column align-items-center">
      <div class="input-group w-50 m-5">
        <form action="/busca"class="w-100 m-2" method="post">
          <div class="input-group">
            <select class="btn btn-secondary dropdown-toggle p-1" id="inputGroupSelect01">
              <option selected value="pasta">Pasta</option>
              <option value="usuario">Usuário</option>
            </select>
            <input type="text" class="form-control" placeholder="Buscar" aria-label="Text input with 2 dropdown buttons" required>
            <button type="submit" class="btn btn-secondary " type="submit"><i class="fa-solid fa-magnifying-glass "></i></button>

          </div>
        </form>

      </div>
      <table class="table-responsive table-borderless bg-light  m-2 rounded shadow">
        <colgroup>
          <col width="50">

        </colgroup>
        <thead>
          <tr>
            <th>Nome</th>
          </tr>
        </thead>
        <tbody>

          <tr>

            <td>
            </td>
          </tr>

        </tbody>
      </table>
    </div>
  </div>

</div>


@endsection