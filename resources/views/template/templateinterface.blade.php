<!DOCTYPE html>

<head>
    <title> @yield("titulo")</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}" />
    <link rel="stylesheet" href="{{asset('css/custom.css')}}" />
    <link rel="stylesheet" href="{{asset('css/all.css')}}" />
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


    <script type="text/javascript">
        $(document).ready(function() {
            $('.treeview').mdbTreeview();
        });
    </script>
</head>

<body>

    <nav id="menu-h">

        <ul id="esquerdo">
            <li><a href="/">Storage</a></li>
        </ul>

        <ul id="meio">
            <li>
                <form class="w-50 m-2">
                    <div class="input-group ">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-primary dropdown-toggle caixaselect" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pasta</button>
                            <div class="dropdown-menu selectcor">
                                <a class="dropdown-item" href="#">Ação</a>
                                <a class="dropdown-item" href="#">Outra ação</a>
                                <a class="dropdown-item" href="#">Algo mais aqui</a>
                                <div role="separator" class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Link isolado</a>
                            </div>
                        </div>


                        <input type="text" class="form-control inputpesquisa " required placeholder="Buscar" aria-label="Recipient's username" aria-describedby="button-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary btntest" type="submit" id="button-addon2">&#xF002;</button>
                        </div>

                </form>
            </li>
            @if(Session::has('firebaseUserId'))
            <li>
                <a href="/" id="nome"><img style="width:40px; padding:0px; margin:0px"src="{{Session::get('photoUrl')}}">{{Session::get('username')}}</a>
            </li>
            @endif
        </ul>
        <ul id="direito">
            <li><a href="/logout"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="white" width="25px" height="35px" y="269.50504">
                        <path d="M160 416H96c-17.67 0-32-14.33-32-32V128c0-17.67 14.33-32 32-32h64c17.67 0 32-14.33 32-32S177.7 32 160 32H96C42.98 32 0 74.98 0 128v256c0 53.02 42.98 96 96 96h64c17.67 0 32-14.33 32-32S177.7 416 160 416zM502.6 233.4l-128-128c-12.51-12.51-32.76-12.49-45.25 0c-12.5 12.5-12.5 32.75 0 45.25L402.8 224H192C174.3 224 160 238.3 160 256s14.31 32 32 32h210.8l-73.38 73.38c-12.5 12.5-12.5 32.75 0 45.25s32.75 12.5 45.25 0l128-128C515.1 266.1 515.1 245.9 502.6 233.4z" />
                    </svg></a></li>

        </ul>

    </nav>
    @if(Session::get("status")=="AcessoDocumentoNegado")
    <div class="alert alert-danger">
        Acesso negado!
        <button id="teste">alou</button>
        <script>
           
        </script>
        <div class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Hello, world! This is a toast message.
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif

    @if(Session::get("acao")=="salvo")
    <div class="alert alert-success">
        Dados Salvos!
    </div>
    @elseif(Session::get("acao")=="deletado")
    <div class="alert alert-danger">
        Dados Excluidos!
    </div>
    @elseif(Session::get("acao")=="atualizado")
    <div class="alert alert-info">
        Dados Atualizados!
    </div>
    @endif

    <div class="tes">
        @yield("conteudo")

    </div>



</body>

</html>