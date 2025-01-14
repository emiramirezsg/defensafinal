<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html>
<head>
	<title>Registro</title>
   <!--Made with love by Mutiullah Samim -->
   <meta charset="utf/8">
	<!--Bootsrap 4 CDN-->
	<<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<!--Custom styles-->
	<link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">
</head>
	<body>
		<div class="container">
			<div class="d-flex justify-content-center h-100">
				<div class="card">
					<div class="card-header">
						<h3>REGISTRARSE</h3>
					</div>
					<div class="card-body">
						@if($errors->any())
							<div class="alert alert-danger">
								<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif
						<form method="post" action="{{route('validar_registro')}}">
							@csrf
							<div class="input-group form-group">
								<input type="text" class="form-control" name="name" placeholder="nombre de usuario">
								@error('name')
        							<span class="text-danger">{{ $message }}</span>
    							@enderror
							</div>
							<div class="input-group form-group">
								<input type="email" class="form-control" name="email" placeholder="email">
							</div>
							<div class="input-group form-group">
								<input type="password" class="form-control" name="password" placeholder="contraseña">
							</div>
							<div class="input-group form-group">
                            <input type="password" class="form-control" name="password_confirmation" placeholder="confirmar contraseña">
                        	</div>
							<div class="form-group">
								<input type="submit" value="Iniciar" class="btn float-right login_btn">
							</div>
						</form>
					</div>
					<div class="card-footer">
						<div class="d-flex justify-content-center links">
							<p>¿Ya tienes una cuenta?<a href="{{route('login')}}">Iniciar sesion</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>