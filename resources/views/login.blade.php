@extends("template.templatelogin")
@section("titulo", "Login")
@section('login')

<div class="card formlogin">
    <div class="formlogincabeca bg-dark">
        <i class="fas fa-cloud icone"></i>
        <h1 class="formlogintexto">FireStorage</h1>
    </div>
    <div class="d-flex justify-content-center  ">
        <form action="{{route('login')}}" method="get">
            @csrf
            </br></br>
            <div class="form-group">
                <label id="email-label">
                    <input type="email" class="form-control formlogininput" id="inputEmail" name="email" placeholder="Email" required>
                </label>
            </div>
            </br>
            <div class="form-group">
                <label id="password-label">
                    <input type="password" class="form-control formlogininput" id="inputPassword" name="senha" placeholder="Senha" required>
                </label>
            </div>
            </br></br><button type="submit" name="login" class="form-control formloginbotao bg-dark">ENTRAR</button>

        </form>
    </div>
    @if(session('status'))
    <div class="alert alert-danger  row-3" role="alert">
        {{session('status')}}
    </div>
    <script>
$(document).ready(function(){
    $("#myBtn").ready(function(){
        $("#myToast").toast("show");
    });
});
</script>
    @endif
</div>
@endsection