<!DOCTYPE html>

<head>
  <title> @yield("titulo")</title>
  <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}" />
  <link rel="stylesheet" href="{{asset('css/newcustom.css')}}" />
  <link rel="stylesheet" href="{{asset('css/all.css')}}" />
  <link rel="stylesheet" href="{{asset('css/allantigo.css')}}" />
  <link rel="stylesheet" href="{{asset('css/notify.min.js')}}" />
  <script src="https://use.fontawesome.com/62e43a72a9.js"></script>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


</head>

<body class="min-vh-100 ">
  <ul class="nav menu bg-dark">
    <li class="nav-item" id="logo">
      <a class="navbar-brand m-4" id="logo" aria-current="page" href="#">FireStorage</a>
    </li>
    <li>
    <form action="/buscar" class="w-100 m-2" method="post">
          @csrf
          <div class="input-group">
            <select class="btn btn-dark dropdown-toggle p-1  caminho-nav" name="tipo" id="inputGroupSelect01">
              <option selected value="pasta">Pasta</option>
              <option value="usuario">Usuário</option>
            </select>
            <input type="text" name="palavra" class="form-control" placeholder="Buscar" aria-label="Text input with 2 dropdown buttons" required>
            <button type="submit" class="btn btn-dark  caminho-nav" type="submit"><i class="fa-solid fa-magnifying-glass "></i></button>

          </div>
        </form>
    </li>

    <li class="nav-item hover-nome">
      <div class="my-container ">
        <div class="dropdown me-3 ">
          <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" style="color:white;" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{Session::get('photoUrl')}}" alt="" width="32" height="32" class="rounded-circle me-2">
            <span class="text-light ">{{Session::get('username')}}</span>
          </a>
          <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
            <li><a class="dropdown-item" href="{{route('logout')}}">Logout</a></li>
          </ul>
        </div>
      </div>
    </li>
  </ul>

  @if(session('status')=='Acesso documento negado!')
      <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="myToast" class="toast align-items-center text-bg-primary bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
            <div class="toast-body text-light">
              {{session('status')}}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      </div>
      <script>
        $(document).ready(function() {
          $("#myBtn").ready(function() {
            $("#myToast").toast("show");
          });
        });
      </script>
      @endif
  @if(session('status')=='Upload Concluido!')
      <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="myToast" class="toast align-items-center text-bg-primary bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
            <div class="toast-body text-light">
              {{session('status')}}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      </div>
      <script>
        $(document).ready(function() {
          $("#myBtn").ready(function() {
            $("#myToast").toast("show");
          });
        });
      </script>
      @endif
      @if(session('status')=='Documento excluido!')
      <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="myToast" class="toast align-items-center text-bg-primary bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
            <div class="toast-body text-light">
              {{session('status')}}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      </div>
      <script>
        $(document).ready(function() {
          $("#myBtn").ready(function() {
            $("#myToast").toast("show");
          });
        });
      </script>
      @endif
      @if(session('status')=='Novo departamento criado!')
      <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="myToast" class="toast align-items-center text-bg-primary bg-info border-0" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
            <div class="toast-body text-light">
              {{session('status')}}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      </div>
      <script>
        $(document).ready(function() {
          $("#myBtn").ready(function() {
            $("#myToast").toast("show");
          });
        });
      </script>
      @endif
      @if(session('status')=='Nova pasta criada!')
      <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="myToast" class="toast align-items-center text-bg-primary bg-info border-0" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
            <div class="toast-body text-light">
              {{session('status')}}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      </div>
      <script>
        $(document).ready(function() {
          $("#myBtn").ready(function() {
            $("#myToast").toast("show");
          });
        });
      </script>
      @endif
      @if(session('status')=='Download executado!')
      <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="myToast" class="toast align-items-center text-bg-primary bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
            <div class="toast-body text-light">
              {{session('status')}}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      </div>
      <script>
        $(document).ready(function() {
          $("#myBtn").ready(function() {
            $("#myToast").toast("show");
          });
        });
      </script>
      @endif
      @if(session('status')=='Cadastro processado!')
      <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="myToast" class="toast align-items-center text-bg-primary bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
            <div class="toast-body text-light">
              {{session('status')}}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      </div>
      <script>
        $(document).ready(function() {
          $("#myBtn").ready(function() {
            $("#myToast").toast("show");
          });
        });
      </script>
      @endif
      @if(session('status')=='Este e-mail ja está em uso!')
      <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="myToast" class="toast align-items-center text-bg-primary bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
            <div class="toast-body text-light">
              {{session('status')}}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      </div>
      <script>
        $(document).ready(function() {
          $("#myBtn").ready(function() {
            $("#myToast").toast("show");
          });
        });
      </script>
      @endif
      @if(session('status')=='A senha deve ter no minimo 6 caracteres!')
      <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="myToast" class="toast align-items-center text-bg-primary bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
            <div class="toast-body text-light">
              {{session('status')}}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      </div>
      <script>
        $(document).ready(function() {
          $("#myBtn").ready(function() {
            $("#myToast").toast("show");
          });
        });
      </script>
      @endif
      @if(session('status')=='Esse email não existe!')
      <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="myToast" class="toast align-items-center text-bg-primary bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
            <div class="toast-body text-light">
              {{session('status')}}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      </div>
      <script>
        $(document).ready(function() {
          $("#myBtn").ready(function() {
            $("#myToast").toast("show");
          });
        });
      </script>
      @endif
      @if(session('status')=='Sucesso')
      <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="myToast" class="toast align-items-center text-bg-primary bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
            <div class="toast-body text-light">
              {{session('status')}}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      </div>
      <script>
        $(document).ready(function() {
          $("#myBtn").ready(function() {
            $("#myToast").toast("show");
          });
        });
      </script>
      @endif
      @if(session('status')== 'Senha Invalida!')
      <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="myToast" class="toast align-items-center text-bg-primary bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
            <div class="toast-body text-light">
              {{session('status')}}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      </div>
      <script>
        $(document).ready(function() {
          $("#myBtn").ready(function() {
            $("#myToast").toast("show");
          });
        });
      </script>
      @endif
      @if(session('status')== 'Ação invalida')
      <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="myToast" class="toast align-items-center text-bg-primary bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
            <div class="toast-body text-light">
              {{session('status')}}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      </div>
      <script>
        $(document).ready(function() {
          $("#myBtn").ready(function() {
            $("#myToast").toast("show");
          });
        });
      </script>
      @endif
      @if(session('status')== 'Usuário deletado')
      <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="myToast" class="toast align-items-center text-bg-primary bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
            <div class="toast-body text-light">
              {{session('status')}}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      </div>
      <script>
        $(document).ready(function() {
          $("#myBtn").ready(function() {
            $("#myToast").toast("show");
          });
        });
      </script>
      @endif
      @if(session('status')== 'Senha deve conter 6 caracteres!')
      <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="myToast" class="toast align-items-center text-bg-primary bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
            <div class="toast-body text-light">
              {{session('status')}}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      </div>
      <script>
        $(document).ready(function() {
          $("#myBtn").ready(function() {
            $("#myToast").toast("show");
          });
        });
      </script>
      @endif
      
      @if(session('status')== 'Este email ja está em uso!')
      <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="myToast" class="toast align-items-center text-bg-primary bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
            <div class="toast-body text-light">
              {{session('status')}}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      </div>
      <script>
        $(document).ready(function() {
          $("#myBtn").ready(function() {
            $("#myToast").toast("show");
          });
        });
      </script>
      @endif
  @yield("conteudo")




</body>

</html>