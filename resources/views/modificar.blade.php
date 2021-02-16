<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{asset('img/favicon.ico')}}" type="image/png" sizes="16x16">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- CSS --}}
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/modificar.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    {{-- JS --}}
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="./js/modificar.js"></script>
    <title>Actualizar restaurante | El tenedor</title>
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

    {{-- CUERPO --}}
    <div class="container-fluid d-flex">     
        <form action="{{url('actualizar/'.$restaurante->id_restaurante)}}" method="POST" enctype="multipart/form-data" class="m-auto">
            @if ($errors->any())
            <div class="alert-danger alert-dismissible errors" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @csrf
            {{method_field('PUT')}}
            <h1>{{$restaurante->nombre}}</h1>
            <div class="form-group">
                <input type="hidden" class="form-control" name="id_restaurante" value="{{$restaurante->id_restaurante}}">
            </div>
            <div class="form-group">
                <label>Nombre</label><br>
                <input type="text" class="form-control" name="nombre" value="{{$restaurante->nombre}}">
            </div>
            <div class="form-group">
                <label>Correo</label><br>
                <input type="text" class="form-control" name="correo" id="correo" value="{{$restaurante->correo}}" required>
            </div>
            <div class="form-group">
                <label>Código postal</label><br>
                <input type="text" class="form-control" name="cp" value="{{$restaurante->cp}}">    
            </div>
            <div class="form-group">
                <label>Calle</label><br>
                <input type="text" class="form-control" name="calle" value="{{$restaurante->calle}}">    
            </div>
            <div class="form-group">
                <label>Ciudad</label><br>
                <input type="text" class="form-control" name="ciudad" value="{{$restaurante->ciudad}}">    
            </div>
            <div class="form-group">
                <label>Tipo cocina</label><br>
                <select class="form-control" name="tipoCocina" id="tipoCocina">
                    @if ($restaurante->tipo_cocina == "Vegana")
                        <option value="3">Vegana</option>
                        <option value="4">Mediterranea</option>
                        <option value="1">India</option>
                        <option value="2">Mexicana</option>
                        @elseif ($restaurante->tipo_cocina == "Mediterranea")
                        <option value="4">Mediterranea</option>
                        <option value="3">Vegana</option>
                        <option value="1">India</option>
                        <option value="2">Mexicana</option>
                        @elseif ($restaurante->tipo_cocina == "India")
                        <option value="1">India</option>
                        <option value="3">Vegana</option>
                        <option value="4">Mediterranea</option>
                        <option value="2">Mexicana</option>
                        @elseif ($restaurante->tipo_cocina == "Mexicana")
                        <option value="2">Mexicana</option>
                        <option value="3">Vegana</option>
                        <option value="4">Mediterranea</option>
                        <option value="1">India</option>
                    @endif  
                </select>
            </div>
            <div class="form-group">
                <label>Precio medio</label><br>
                <input type="number" class="form-control" name="precio_medio" value="{{$restaurante->precio_medio}}">    
            </div>
            <div class="form-group">
                <label for="img">Logo<br>
                <input type="file" class="btn btn-default" id="img" name="img" accept=".gif, .png, .jpg, .jpeg" value="{{$restaurante->foto}}">
            </div>
            <div class="form-group">
                <input type="submit" class="form-control btn-success" name="Enviar" value="Enviar">
            </div>
            
        </form>
        
    </div>
    <script src="{{asset('js/app.js')}}"></script>
</body>
</html>