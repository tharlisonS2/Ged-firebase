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
   
</head>
<body>
    <div class= "container">
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
    <div class="container log">
        @yield("login")
    </div>
    
    <div>    
        
        @yield("listagem")
    </div>
    </div>
</body>
</html>