<?php
        session_start();
        require 'db.php';
        $_SESSION['compra_asiento'] = '';
        $ID_Evento = $_GET["ID_Evento"];
        $_SESSION["ID_Evento"] = $ID_Evento;
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
                    $asiento = $_POST['asiento'];
                    $query = "SELECT * FROM EVENTO WHERE ID_Evento = '$ID_Evento'";
                    $result = mysqli_query($conn, $query);
                    $row = $result->fetch_assoc();
                    $precio = $row['Precio_Boleto'];
                    //echo '<h1>' .$precio. '</h1>';
                    $query = "INSERT INTO ORDEN (Total, Correo) VALUES ('$precio','$correo')";
                    $result = mysqli_query($conn, $query);
                    if(!$result){
                        die(mysqli_error($conn));
                    } else {
                        $query = "SELECT MAX(Numero_Venta) id FROM ORDEN";
                        $result = mysqli_query($conn, $query);
                        //$row = mysql_fetch_array($result);
                        $row = $result->fetch_assoc();
                        $id = $row['id'];
                        $query = "SELECT * FROM ASIENTO WHERE ID_Evento = '$ID_Evento' and Numero_Asiento = '$asiento'";
                        $result = mysqli_query($conn, $query);
                        $row = $result->fetch_assoc();
                        $id_asiento = $row['Asiento_ID'];

                        $query = "INSERT INTO BOLETO (Numero_Venta, ID_Evento, Asiento_ID) VALUES ('$id','$ID_Evento','$id_asiento')";
                        $result = mysqli_query($conn, $query);
                        if(!$result){
                            die(mysqli_error($conn));
                        } else {
                            $query = "UPDATE ASIENTO SET Disponible = 0 WHERE Numero_Asiento = '$asiento' and ID_Evento = '$ID_Evento';";
                            $result = mysqli_query($conn, $query);
                            if($result){
                                $_SESSION['compra_asiento'] = 'Exito';
                            }
                        }
                    }
                    
                }
                ?>
                <div class="row m-5">
                    <div class="col">
                        <div class="jumbotron">
                        <h1><?php echo $row["Numero_Venta"]?> </h1>
                            <h1 class="display-4"><?php echo $row["Nombre_Evento"]?></h1>
                            <p class="lead"><?php echo $row["Dia"]?> de <?php echo $mes?> de <?php echo $row["Año"]?></p>
                            <hr class="my-4">
                            <p><?php echo $row["Descripcion"]?></p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="jumbotron">
                            <h1 class="display-4">Selecciona tu asiento</h1>
                            <form method='post' action='perfil.php'>
                                <div class='form-group card-body'>
                                    <label for=''>Asientos Disponibles</label>
                                    <select class='form-control' name='asiento'>
                                    <?php
                                    $query = "SELECT Numero_Asiento FROM ASIENTO WHERE ID_Evento = '$ID_Evento' and Disponible=1 ";
                                    $result = mysqli_query($conn, $query);
                                    if (mysqli_num_rows($result) > 0) {
                                    // output data of each row
                                    while($row = $result->fetch_assoc()) {
                                        echo "<option>".$row["Numero_Asiento"]."</option>";}}?>
                                    </select>
                                </div>
                                <div class='form-row card-body'>
                                    <div class='col-12'>
                                        <input type="submit" name="comprar" class="btn btn-primary btn-lg btn-block">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    <!-- Footer -->
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