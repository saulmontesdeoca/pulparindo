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
                      <a class='dropdown-item' href='#'>Logout</a>
                    </div>
                  </li>";
            } else{
                echo "<li class='nav-item'>
                        <a class='nav-link' href='/login.php'>Ingresar</a>
                      </li>";
            }
             ?>
          </ul>
          <form class="form-inline my-2 my-lg-0" action="boletos.php" method="get">
            <input class="form-control mr-sm-2" name="query" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar evento</button>
          </form>
        </div>
      </div>
    </nav>
    <div class="container-fluid p-5 contenedor">
                          <div class="row">
                            <div class="col m-4 pt-3">
                                <h1>Todos los eventos</h1>
                            </div>
                          </div>
                          <div class="row justify-content-around m-1">
                                    <?php
                                            $query = '';
                                            $query = $_GET['query']; 
                                            $min_length = 1;
                                            if(strlen($query) >= $min_length){ // if query length is more or equal minimum length then
                                             
                                                $query = htmlspecialchars($query); 
                                                // changes characters used in html to their equivalents, for example: < to &gt;
                                                 
                                                // $query = mysql_real_escape_string($query);
                                                // // makes sure nobody uses SQL injection
                                                 
                                                $row_asociativo = mysqli_query($conn,"SELECT * FROM EVENTOS
                                                    WHERE (`Nombre_Evento` LIKE '%".$query."%' OR (`Tipo_Evento` LIKE '%".$query."%')") or die(mysql_error());
                                                 
                                                // '%$query%' is what we're looking for, % means anything, for example if $query is Hello
                                                // it will match "hello", "Hello man", "gogohello", if you want exact match use `title`='$query'
                                                // or if you want to match just full word so "gogohello" is out use '% $query %' ...OR ... '$query %' ... OR ... '% $query'
                                                 
                                                if(mysql_num_rows($row_asociativo) > 0){ // if one or more rows are returned do following
                                                     
                                                    while($results = mysql_fetch_array($row_asociativo)){
                                                    // $results = mysql_fetch_array($raw_results) puts data from database into array, while it's valid it does the loop
                                                     
                                                    echo "<div class='card carta' style='width: 18rem;'>
                                                                <img src=".$row_asociativo["Poster_IMG"].">
                                                                <div class='card-body'>
                                                                    <h5 class='card-title'>".$row_asociativo["Nombre_Evento"]."</h5>
                                                                    <p class='card-text'>".$row_asociativo["Descripcion"].".</p>
                                                                    <a href='/comprar.php?ID_Evento=".$row_asociativo["ID_Evento"]."' class='btn btn-primary'>Comprar</a>
                                                                </div>
                                                            </div>";
                                                        // posts results gotten from database(title and text) you can also show id ($results['id'])
                                                    }
                                                     
                                                }
                                                else{ // if there is no matching rows do following
                                                    echo "<h1>No results</h1>";
                                                }
                                                 
                                            }
                                            else{ // if query length is less than minimum
                                                $resultado_query = mysqli_query($conn, "select * from EVENTO;") ;
                                                if($correo==''){
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
                                                  } else{
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
                                                }
                                    
                                    
                                    ?>
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
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>