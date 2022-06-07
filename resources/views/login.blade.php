@extends("template.templatelogin")
@section("titulo", "Login")
@section('login')

<div class="card formlogin" >    
    <div class="formlogincabeca">
        <i class="fas fa-cloud icone"></i><h1 class="formlogintexto">FireStorage</h1>
    </div>
    <div class="card-body ">
        <form action="{{route('login')}}" method="post">
        @csrf
            </br></br>
            <div class="form-group">
                <label id="email-label">
                    <input type="email" class="form-control formlogininput" id="inputEmail" name="email" placeholder="Email"required>
                </label>
            </div>
            </br>
            <div class="form-group">
                <label id="password-label">
                    <input type="password" class="form-control formlogininput" id="inputPassword"name="senha" placeholder="Senha"required>
                </label>
            </div>
            </br></br><button type="submit" name="login"class="form-control formloginbotao">ENTRAR</button>
            @if(session('status'))
                <div class="alert alert-danger col-10 alertlogin" role="alert">
                    {{session('status')}}
                </div>
            @endif
        </form>
    
    </div>
</div>
@endsection