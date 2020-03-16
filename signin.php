<?php
		session_start();
		require 'db.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sign in Page</title>
   <!--Made with love by Mutiullah Samim -->
   
	<!--Bootsrap 4 CDN-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<!--Custom styles-->
	<link rel="stylesheet" type="text/css" href="login.css">
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<?php
		$message = '';
		if(isset($_POST['registrar'])){
			$correo = $_POST['email'];
			$nombre = $_POST['nombre'];
			$contrasena = $_POST['password'];
			$tarjeta = $_POST['tarjeta'];
		}

			if (empty($correo) or empty($nombre) or empty($contrasena) or empty($tarjeta)) {
				$_SESSION['message'] = "Ingrese todos los campos";
				$_SESSION['message_type'] = 'warning';
				$message = '1';
			}

			// $sql_u = "SELECT * FROM USUARIO WHERE Correo='$correo'";
			// $res_u = mysqli_query($conn, $sql_u);

			// if (mysqli_num_rows($res_u) > 0) {
			// 	$_SESSION['message'] = "Correo ya existente";
			// 	$_SESSION['message_type'] = 'warning';
			// 	$message = '1';
			// }
			$contrasena = hash('sha512', $contrasena);

			if($message == ''){
				$query = "INSERT INTO USUARIO (Correo, Nombre, Contraseña, Tarjeta) VALUES ('$correo','$nombre', '$contrasena','$tarjeta')";
				$result = mysqli_query($conn, $query);
				if(!$result){
					die(mysqli_error($conn));
				} 
			}
?>
<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3>Registrarse</h3>
				<div class="d-flex justify-content-end social_icon">
					<span><i class="fab fa-facebook-square"></i></span>
					<span><i class="fab fa-google-plus-square"></i></span>
					<span><i class="fab fa-twitter-square"></i></span>
				</div>
			</div>
			<?php if(!empty($message)): ?>
      				<h2> <?= $message ?></h2>
    		<?php endif; ?>
			<div class="card-body">
				<form action="signin.php" method="post">
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<div>
						</div>
						<input name="email" type="text" class="form-control" placeholder="Email">
						<input name="nombre" type="text" class="form-control" placeholder="Nombre">
						
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input name="password" type="password" class="form-control" placeholder="Contraseña">
						<input name="tarjeta" class="form-control" placeholder="Tarjeta">
					</div>
					<div class="form-group">
						<input type="submit" name="registrar" value="Registrar" class="btn float-right login_btn">
					</div>
				</form>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-center links">
					o <a href="/login.php">Ingresar</a>
					o<a href="/home.php">Regresar</a>

				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>