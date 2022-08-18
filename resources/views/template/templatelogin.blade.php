<!DOCTYPE html>

<head>
   <title> @yield("titulo")</title>
   <link rel="stylesheet"href="{{asset('css/bootstrap.css')}}"/>
   <link rel="stylesheet"href="{{asset('css/custom.css')}}"/>
   <link rel="stylesheet"href="{{asset('css/all.css')}}"/>
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
<body>
    <div class= "container h-100">
    @if(Session::get("acao")=="salvo")
        <div class="alert alert-success">
            Dados Salvos! 
        </div>
    @endif
    @if(Session::get("acao")=="deletado")
        <div class="alert alert-danger">
            Dados Excluidos!
        </div>
    @endif
    @if(Session::get("acao")=="atualizado")
        <div class="alert alert-info">
            Dados Atualizados!
        </div>
    @endif
    <div class="h-100 d-flex justify-content-center align-items-center flex-column">
        @yield("login")
    </div>
    
    <div>    
        
        @yield("listagem")
    </div>
    </div>
</body>
</html>