<?php
		//header('Location: home.php');   
		session_start();
		if($_SESSION['correo']!=''){
			header('Location: home.php');
		}
		require 'db.php';
		if(isset($_POST['login'])){
			$correo = $_POST['email'];
			$contrasena = $_POST['password'];
			if (!(empty($correo)) and !(empty($contrasena))) {
				$contrasena = hash('sha512', $contrasena);
				$sql_u = "SELECT * FROM USUARIO WHERE Correo='$correo' and Contraseña='$contrasena'";
				$res_u = mysqli_query($conn, $sql_u);
			
				if (mysqli_num_rows($res_u) > 0) {
					//Nombre de usuario y contraseña validos
					$_SESSION['correo'] = $correo;
				}
			}
		}

    ?>
<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
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
<div class="container">
	<?php
	if($_SESSION['correo']!=''){
		echo "<div class='d-flex justify-content-center h-100'>
				<div class='card'>
				<div class='card-header'>
					<h3>Login exitoso. Haga click en continuar.</h3>
				</div>
				<div class='card-body'>
				<form action='/home.php'>
					<div class='form-group'>
						<input type='submit' name='login' value='Continuar' class='btn float-right login_btn'>
					</div>
				</form>
				</div>
			</div>
	</div>";
	} else
	{
		echo "<div class='d-flex justify-content-center h-100'>
		<div class='card'>
			<div class='card-header'>
				<h3>Ingresar</h3>
				<div class='d-flex justify-content-end social_icon'>
					<span><i class='fab fa-facebook-square'></i></span>
					<span><i class='fab fa-google-plus-square'></i></span>
					<span><i class='fab fa-twitter-square'></i></span>
				</div>
			</div>
			<div class='card-body'>
				<form action='/login.php' method='post'>
					<div class='input-group form-group'>
						<div class='input-group-prepend'>
							<span class='input-group-text'><i class='fas fa-user'></i></span>
						</div>
						<input type='text' name='email' class='form-control' placeholder='Usuario'>
						
					</div>
					<div class='input-group form-group'>
						<div class='input-group-prepend'>
							<span class='input-group-text'><i class='fas fa-key'></i></span>
						</div>
						<input type='password' name='password' class='form-control' placeholder='Contraseña'>
					</div>
					<div class='form-group'>
						<input type='submit' name='login' value='Login' class='btn float-right login_btn'>
					</div>
				</form>
			</div>
			<div class='card-footer'>
				<div class='d-flex justify-content-center links'>
				¿No tienes cuenta?<a href='/signin.php'>Registrarse  </a>
				o <a href='/home.php'>Regresar</a>
				</div>
			</div>
		</div>
	</div>";
	};
	?>
</div>
</body>
</html>