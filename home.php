<?php
        session_start();
        require 'db.php';
        $correo = $_SESSION['correo'];
        $query = "SELECT * FROM USUARIO WHERE Correo = '$correo'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
        // output data of each row
          while($row = $result->fetch_assoc()) {
            $_SESSION['nombre'] = $row["Nombre"];
            $_SESSION['tarjeta'] = $row["Tarjeta"];
          }
        }
        $nombre = $_SESSION['nombre'];
    ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Pulparindo</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="./styles.css">
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
            <li class="nav-item active">
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

    <div class="bd-example top" style="max-height: 600px; width: 100%;   overflow: hidden;">
      <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
          <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="https://blogmedia.evbstatic.com/wp-content/uploads/wpmulti/sites/21/2018/07/17105523/organizar-conciertos.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h3>Pulparindo</h3>
              <p>Compra tus boletos siempre con Pulparindo - Siempre los mejores precios!</p>
            </div>
          </div>
          <?php
            $resultado_query = mysqli_query($conn, "select * from EVENTO;") ;
            while($row_asociativo = mysqli_fetch_assoc($resultado_query))
            {
              echo "<div class='carousel-item '>
                      <img src=".$row_asociativo["Poster_IMG"]." class='d-block w-100' >
                      <div class='carousel-caption d-none d-md-block'>
                        <h5>".$row_asociativo["Nombre_Evento"]."</h5>
                        <p>".$row_asociativo["Descripcion"]."</p>
                      </div>
                    </div>";
            }
          ?>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
    <?php
      if($correo!=''){
        echo "<div class='alert alert-success alert-dismissible fade show mb-0' role='alert'>
                <strong>Hola ".$nombre."!</strong> Bienvenido a Pulparindo la mejor página de venta de boletos de tus eventos favoritos.
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button>
              </div>";
      }
    ?>
    <div class="container-fluid contenedor">
      <div class="row">
        <div class="col p-4">
          <h1>Próximos Eventos</h1>
        </div>
      </div>
      <div class="row justify-content-around pb-4">
      <?php
        $resultado_query = mysqli_query($conn, "select * from EVENTO;") ;
        if($correo=='')
        {
          while($row_asociativo = mysqli_fetch_assoc($resultado_query))
          {
            echo "<div class='card carta rounded-lg' style='width: 18rem;'>
                    <img src=".$row_asociativo["Poster_IMG"]." class='rounded-top'>
                    <div class='card-body'>
                      <h5 class='card-title'>".$row_asociativo["Nombre_Evento"]."</h5>
                      <h6 class='card-subtitle mb-2 text-muted'>".$row_asociativo["Lugar"]."</h6>
                      <p class='card-text'>".$row_asociativo["Descripcion"].".</p>
                      <a href='/login.php' class='btn btn-primary'>Comprar</a>
                    </div>
                  </div>";
          }
        } else
        {
          while($row_asociativo = mysqli_fetch_assoc($resultado_query))
          {
            echo "<div class='card carta rounded-lg' style='width: 18rem;'>
                    <img src=".$row_asociativo["Poster_IMG"]." class='rounded-top'>
                    <div class='card-body'>
                      <h5 class='card-title'>".$row_asociativo["Nombre_Evento"]."</h5>
                      <h6 class='card-subtitle mb-2 text-muted'>".$row_asociativo["Lugar"]."</h6>
                      <p class='card-text'>".$row_asociativo["Descripcion"].".</p>
                      <a href='/comprar.php?ID_Evento=".$row_asociativo["ID_Evento"]."' class='btn btn-primary'>Comprar</a>
                    </div>
                  </div>";
          }
        }
      ?>
      </div>
    </div>
            <div class="container-fluid secciones p-5">
                <h1>Descubre</h1>
                <div class="row justify-content-around pt-4">
                    <div class="col">
                        <img src="https://imagenes.milenio.com/xolGguxBpyL61gdjHWN8a2zzdrQ=/958x596/smart/https://www.milenio.com/uploads/media/2019/05/26/los-nuevos-grandes-del-futbol_0_24_1200_747.jpg" alt="">
                    </div>
                    <div class="col">
                        <img src="https://img.chilango.com/2018/05/conciertos-en-mayo.jpg" alt="">
                    </div>
                    <div class="col">
                        <img src="https://imagenes.milenio.com/4dkE-h9H6aqCspBSap3bDXH2ZWs=/958x596/https://www.milenio.com/uploads/media/2019/11/19/roger-federer-vs-alexander-zverev_49_0_886_551.jpg" alt="">
                    </div>
                </div>
                <div class="row pt-5 ">
                    <div class="col">
                        <img src="http://static.nfl.com/static/content/public/photo/2019/04/15/0ap3000001026426.jpg" alt="">
                    </div>
                    <div class="col">
                        <img src="https://imagenescityexpress.scdn6.secure.raxcdn.com/sites/default/files/los-teatros-mas-emblematicos-del-df.jpg" alt="">
                    </div>
                    <div class="col">
                        <img src="https://www.infobae.com/new-resizer/lMW0Is2unZCKZPjccuU7fKFCEk8=/750x0/filters:quality(100)/s3.amazonaws.com/arc-wordpress-client-uploads/infobae-wp/wp-content/uploads/2017/10/29180150/Formula-1-en-Mexico.jpg" alt="">
                    </div>
                </div>
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
      <!-- Footer -->
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>