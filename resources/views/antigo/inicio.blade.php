@extends("template.templateinterface")
@section("titulo", "Inicio")
@section('conteudo')

<nav id="menu-l">
            <ul>
              <li><a href="/inicio"><i class="fas fa-home"></i> Inicio</a></li>
              @if(Session::get('admin')==true)
              <li><a href="/usuarios"><i class="fas fa-users-cog"></i> Usuários</a></li>
              @else
              @endif
              <li><a href="/documento"><i class="far fa-file"></i> Documentos</a></li>
              <li><a href="#"><i class="fas fa-search"></i> Buscar</a></li>
            </ul>
</nav>
<div class="caixainicio">
    <div class="caixaum">
        <button class="btn-primary">Inicio</button>
        <button class="btn-primary">Inicio</button>
        <button class="btn-primary">Inicio</button>

    </div>
    <div class="caixadois"></div>
</div>
@endsection