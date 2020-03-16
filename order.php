<?php
        session_start();
        require 'db.php';
        $ID_Evento = $_SESSION["ID_Evento"];        ;
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
        $tarjeta = $_SESSION['tarjeta'];   
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
    <?php
    $query = "SELECT * FROM EVENTO WHERE ID_Evento = '$ID_Evento'";
    $result = mysqli_query($conn, $query);
    $row = $result->fetch_assoc();
    ?>
            <div class='container-fluid'>
                <div class='row' style='height: 450px; overflow: hidden;'>
                    <img src=<?php echo $row["Poster_IMG"]?> class='card-img-top' >
                    <div class='col'>
                        <h1><?php echo $row["Nombre_Evento"]?> </h1>
                    </div>
                </div>
                <?php
                $query = "SELECT * FROM EVENTO WHERE ID_Evento = '$ID_Evento'";
                $result = mysqli_query($conn, $query);
                $row = $result->fetch_assoc();
                if($row['Mes']==1){
                    $mes = 'Enero';
                }elseif($row['Mes']==2){
                    $mes = 'Febrero';
                }elseif($row['Mes']==3){
                    $mes = 'Marzo';
                }elseif($row['Mes']==4){
                    $mes = 'Abril';
                }elseif($row['Mes']==5){
                    $mes = 'Mayo';
                }elseif($row['Mes']==6){
                    $mes = 'Junio';
                }elseif($row['Mes']==7){
                    $mes = 'Julio';
                }elseif($row['Mes']==8){
                    $mes = 'Agosto';
                }elseif($row['Mes']==9){
                    $mes = 'Septiembre';
                }elseif($row['Mes']==10){
                    $mes = 'Octubre';
                }elseif($row['Mes']==11){
                    $mes = 'Noviembre';
                }elseif($row['Mes']==12){
                    $mes = 'Diciembre';
                }
                if(isset($_POST['comprar'])){
                    $query = "SELECT * FROM EVENTO WHERE ID_Evento = '$ID_Evento'";
                    $result = mysqli_query($conn, $query);
                    $row = $result->fetch_assoc();
                    $precio = $row['Precio_Boleto'];
                    $query = "INSERT INTO ORDEN (Total, Correo) VALUES ('$precio','$correo')";
                    $result = mysqli_query($conn, $query);
                    if(!$result){
                        die(mysqli_error($conn));
                    }
                }
                ?>
                <div class="row m-5">
                    <div class="col">
                        <div class="jumbotron">
                        <h1><?php echo $_SESSION['asiento']?> </h1>

                            <h2 class="display-4"><?php echo $nombre?>, asistirás a <?php echo $row["Nombre_Evento"]?>!</h2>
                            <p class="lead"><?php echo $row["Dia"]?> de <?php echo $mes?> de <?php echo $row["Año"]?></p>
                            <hr class="my-4">
                            <p><?php echo $row["Descripcion"]?></p>
                            <a class="btn btn-primary btn-lg" href="#" role="button">Ver mis ordenes</a>
                        </div>
                    </div>
                </div>
            </div>
    <!-- Footer -->
    <footer class="page-footer font-small stylish-color-dark pt-4">
                <!-- Footer Links -->
                <div class="container text-center text-md-left">
      
                    <!-- Grid row -->
                    <div class="row">
      
                        <!-- Grid column -->
                        <div class="col-md-4 mx-auto">
                            <!-- Content -->
                            <h5 class="font-weight-bold text-uppercase mt-3 mb-4">Footer Content</h5>
                            <p>Here you can use rows and columns to organize your footer content. Lorem ipsum dolor sit amet,
                            consectetur adipisicing elit.</p>
                        </div>
                        <!-- Grid column -->
                        <hr class="clearfix w-100 d-md-none">
                        <!-- Grid column -->
                        <div class="col-md-2 mx-auto">
                            <!-- Links -->
                            <h5 class="font-weight-bold text-uppercase mt-3 mb-4">Links</h5>
                            <ul class="list-unstyled">
                                <li>
                                    <a href="#!">Link 1</a>
                                </li>
                                <li>
                                    <a href="#!">Link 2</a>
                                </li>
                                <li>
                                    <a href="#!">Link 3</a>
                                </li>
                                <li>
                                    <a href="#!">Link 4</a>
                                </li>
                            </ul>
                        </div>
                        <!-- Grid column -->
      
                        <hr class="clearfix w-100 d-md-none">
      
                        <!-- Grid column -->
                        <div class="col-md-2 mx-auto">
      
                            <!-- Links -->
                            <h5 class="font-weight-bold text-uppercase mt-3 mb-4">Links</h5>
      
                            <ul class="list-unstyled">
                                <li>
                                    <a href="#!">Link 1</a>
                                </li>
                                <li>
                                    <a href="#!">Link 2</a>
                                </li>
                                <li>
                                    <a href="#!">Link 3</a>
                                </li>
                                <li>
                                    <a href="#!">Link 4</a>
                                </li>
                            </ul>
      
                        </div>
                        <!-- Grid column -->
      
                        <hr class="clearfix w-100 d-md-none">
      
                        <!-- Grid column -->
                        <div class="col-md-2 mx-auto">
      
                        <!-- Links -->
                        <h5 class="font-weight-bold text-uppercase mt-3 mb-4">Links</h5>
                
                        <ul class="list-unstyled">
                            <li>
                            <a href="#!">Link 1</a>
                            </li>
                            <li>
                            <a href="#!">Link 2</a>
                            </li>
                            <li>
                            <a href="#!">Link 3</a>
                            </li>
                            <li>
                            <a href="#!">Link 4</a>
                            </li>
                        </ul>
                
                        </div>
            <!-- Grid column -->
      
                        </div>
                        <!-- Grid row -->
                    
                        </div>
                        <!-- Footer Links -->
                    
                        <hr>
                    
                        <!-- Call to action -->
                        <ul class="list-unstyled list-inline text-center py-2">
                        <li class="list-inline-item">
                            <h5 class="mb-1">Registrarse gratis</h5>
                        </li>
                        <li class="list-inline-item">
                            <a href="#!" class="btn btn-primary btn-rounded">Sign up!</a>
                        </li>
                        </ul>
                        <!-- Call to action -->
                    
                        <hr>
                    
                        <!-- Social buttons -->
                        <ul class="list-unstyled list-inline text-center">
                        <li class="list-inline-item">
                            <a class="btn-floating btn-fb mx-1">
                            <i class="fab fa-facebook-f"> </i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a class="btn-floating btn-tw mx-1">
                            <i class="fab fa-twitter"> </i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a class="btn-floating btn-gplus mx-1">
                            <i class="fab fa-google-plus-g"> </i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a class="btn-floating btn-li mx-1">
                            <i class="fab fa-linkedin-in"> </i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a class="btn-floating btn-dribbble mx-1">
                            <i class="fab fa-dribbble"> </i>
                            </a>
                        </li>
                        </ul>
                        <!-- Social buttons -->
                    
                        <!-- Copyright -->
                        <div class="footer-copyright text-center py-3">© 2019 Copyright:
                        <a href="/home.php">Pulparindo</a>
                        </div>
                        <!-- Copyright -->
                    
            </footer>
      <!-- Footer -->
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>