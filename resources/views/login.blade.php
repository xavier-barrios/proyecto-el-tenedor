<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="{{asset('img/favicon.ico')}}" type="image/png" sizes="16x16">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- CSS --}}
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
    {{-- JS --}}
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="./js/login.js"></script>
    <title>Login | El tenedor</title>
</head>
<body class="d-flex">
    <div class="container my-auto mx-auto">
        <div class="d-flex justify-content-center">
            <img src="{{asset('img/logo.png')}}" class="img-fluid m-auto" alt="Logo empresa">
        </div>
    	<div class="row d-flex justify-content-center">
			<div class="p-3 col-md-6 col-md-offset-3">
				<div class="p-3 panel panel-login">
					<div class="panel-heading p-3">
						<div class="row d-flex justify-content-around h-100">
								<a href="#" class="active" id="login-form-link">Entrar</a>
								<a href="#" id="register-form-link">Registrar</a>
						</div>
					</div>
					<div class="panel-body p-3">
						<div class="row">
							<div class="col-lg-12">
								<form id="login-form" action="{{url('recibirlogin')}}" method="GET" role="form" style="display: block;">
                                    @csrf
                                    <div class="form-group">
										<input type="email" name="email" id="email" class="form-control" placeholder="Correo" required>
									</div>
									<div class="form-group">
										<input type="password" name="password" id="password" class="form-control" placeholder="Contraseña" required>
									</div>
									<div class="form-group">
										<p id="msgLogin"></p>
									</div>
									<div class="form-group">
										<div class="row d-flex justify-content-center">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="login-submit" id="login-submit" class="form-control btn btn-success" value="Entrar">
											</div>
										</div>
									</div>
								</form>
								<form id="register-form" action="{{url('recibir')}}" onsubmit="return validarPass();" method="POST" role="form" style="display: none;">
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
                                    <div class="form-group">
										<input type="text" name="usernameRegister" id="usernameRegister" class="form-control" placeholder="Nombre" required>
									</div>
									<div class="form-group">
										<input type="email" name="emailRegister" id="emailRegister" class="form-control" placeholder="Correo" required>
									</div>
									<div class="form-group">
										<input type="password" name="passwordRegister" id="passwordRegister" class="form-control" placeholder="Contraseña" required>
									</div>
									<div class="form-group">
										<input type="password" name="confirm-password" id="confirm-password" class="form-control" placeholder="Confirma contraseña" required>
									</div>
									<div class="form-group">
										<p id="msg"></p>
									</div>
									<div class="form-group">
										<div class="row d-flex justify-content-center">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="register-submit" id="register-submit" class="form-control btn btn-success" value="Registrar">
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
    <script src="{{asset('js/app.js')}}"></script>
</body>
</html>