<?php
        session_start();
        require 'db.php';
        $correo = $_SESSION["correo"];
        $nombre = $_SESSION['nombre'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Pulparindo</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="styles.css">
    </head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/home.php">Pulparindo</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                <a class="nav-link" href="/home.php">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="/boletos.php">Boletos</a>
                </li>
                <?php if($correo!=''){
                echo "<li class='nav-item dropdown'>
                        <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        ".$nombre."
                        </a>
                        <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
                        <a class='dropdown-item' href='/perfil.php'>Perfil</a>
                        <div class='dropdown-divider'></div>
                        <a class='dropdown-item' href='/logout.php'>Logout</a>
                        </div>
                    </li>";
                } else{
                    echo "<li class='nav-item'>
                            <a class='nav-link' href='/login.php'>Ingresar</a>
                        </li>";
                }
                ?>
            </ul>
            </div>
        </div>
    </nav>
            <div class='container-fluid'>
                <div class='row' style='height: 450px; overflow: hidden;'>
                    <img src='http://getwallpapers.com/wallpaper/full/0/1/e/1355973-vertical-music-festival-wallpaper-2048x1366.jpg' class='card-img-top' >
                    <div class='col'>
                        <h1><?php echo $row["Nombre_Evento"]?> </h1>
                    </div>
                </div>
                <div class="row m-5">
                    <div class="col">
                        <div class="jumbotron">
                        <h1>Aqui estan tus ordenes <?php echo $nombre?>! </h1>
                            <hr class="my-4">
                        </div>
                    </div>
                </div>
                <?php
                $query = "SELECT * FROM ORDEN";
                $result = mysqli_query($conn, $query);
                while($row = mysqli_fetch_assoc($result))
                {
                  echo "<div class='row m-5'>
                            <div class='col'>
                                <div class='jumbotron'>
                                    <h1 class='display-4'>".$_SESSION['correo']."</h1>
                                    <hr class='my-4'>
                                    <p>Tu total es de: $".$row["Total"]."</p>
                                    <p>Número de venta: No.".$row["Numero_Venta"]."</p>

                                </div>
                            </div>
                        </div>";
                }
                ?>
            </div>
                <!-- Footer -->
                <footer class="page-footer font-small stylish-color-dark pt-4">

<!-- Footer Links -->
<div class="container text-center text-md-left">

    <!-- Grid row -->
    <div class="row">
        <div class="col-md-4 mx-auto">
            <h5 class="font-weight-bold text-uppercase mt-3 mb-4">Sobre nosotros</h5>
            <p>Somos una pagina enfocada a darte un servicio premium para los conciertos y eventos que mas te gustan de tu ciudad,
            estamos comprometidos con nuestro cliente y sabemos que nadie espera menos de nosotros.</p>
        </div>
        <hr>
        <ul class="list-unstyled list-inline text-center py-2">
        <li class="list-inline-item">
            <h5 class="mb-1">¿No tienes cuenta?</h5>
        </li>
        <li class="list-inline-item">
            <a href="/signin.php" class="btn btn-primary btn-rounded">¡Registrate!</a>
        </li>
        </ul>
        <hr>
        <div class="footer-copyright text-center py-3">© 2019 Copyright:
        <a href="/home.php"> Pulparindo</a>
        </div>
</footer>
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>