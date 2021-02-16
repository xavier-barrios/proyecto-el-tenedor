<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{asset('img/favicon.ico')}}" type="image/png" sizes="16x16">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- CSS --}}
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/mostrar.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    {{-- JS --}}
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    {{-- <script src="./js/mostrar.js"></script> --}}
    <script src="./js/ajax.js"></script>
    <meta name="csrf-token" id="token" content="{{ csrf_token() }}">
    <title>Inicio | El tenedor</title>
</head>
<body>
    <div class="container-fluid d-flex topNav p-3 fixed-top">
        <a href="{{asset('home')}}"><img src="{{asset('img/banner.png')}}" class="mr-auto" width="215px" height="78px" alt="Logo ElTenedor"></a>
        
        <form id="logout" class="ml-auto" method='get' action="{{url('logout')}}">
            <button class="btn btn-danger" type='submit'><i class="fas fa-sign-out-alt"></i></button>
        </form>
        @if (Session::get('usuario')->rol == "admin")
        <form id="bajaRes" method='get' action="{{url('baja_restaurante')}}">
            <button class="btn btn-success" type='submit'>Restaurantes de baja</button>
        </form>
        @endif
    </div> 
    
    <div class="divAux"></div>

    <div class="container-fluid">
        <div class="row text-center contenidoCartas">
            
            <div class="col-sm-12 col-md-6 col-lg-6 d-flex">
                @if (Session::get('usuario'))
                <h1 class="bienv m-auto">Bienvenido {{Session::get('usuario')->nombre}}</h1>
                @else
                <h1 class="bienv m-auto">Bienvenido!</h1>
                @endif
            </div>

            <div class="col-sm-12 col-md-6 col-lg-6 d-flex">
                <input type="hidden" value="{{Session::get('usuario')->rol}}" id="rol">
                <input type="hidden" value="{{Session::get('usuario')->id_usuario}}" id="id_usuario"> 
                <div class="panel m-auto">
                    <div class="container-fluid form-group p-1">
                        <label for="searchCocina" class="m-0 ml-2">Tipo comida</label><br>
                        <input type="text" class="p-2" name="searchCocina" id="searchCocina" placeholder="Busca tu tipo de cocina" onkeyup="mostrar()">
                    </div>
                    <div class="container-fluid form-group p-1">
                        <label for="searchPrecio" class="m-0 ml-2">Precio</label><br>
                        <input type="text" class="p-2" name="searchPrecio" id="searchPrecio" placeholder="Precio medio" onkeyup="mostrar()">
                    </div>
                </div>
            </div>

        </div>
        
        <div id="restaurantes">
        
        </div>
    </div>
</div>
    

</body>
</html>