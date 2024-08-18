<?php

require 'conexion.php';
session_start();

//if(isset($_GET['cerrar_sesion'])){
//    session_unset();
//    session_destroy();
//}
    
//if(!empty($_SESSION["id"])){
//    header("Location: ../login.php");
//}

if(isset($_POST["submit"]))
{
    $email = $_POST['email'];
    $password = $_POST['password'];
    // Extraer el nombre de usuario
    $username = substr($email, 0, strpos($email, '@'));


    //$conexion = mysqli_connect("localhost", "root", "", "appletime");
    $consulta = "SELECT * FROM usuarios WHERE email = '$email' AND password = '$password'";
    $resultado = mysqli_query($conn, $consulta);

    $filas = mysqli_fetch_array($resultado);

    if (mysqli_num_rows($resultado) === 1){

        if ($filas['email'] === $email && $filas['password'] === $password && $filas['rol_id'] == 1){
            //Administrador
            //$_SESSION['varsesion'] = "admin";
            header ("Location: ../administrador.php");
            $_SESSION['username'] = $username;
            $_SESSION['rol'] = "Administrador";
        } else if ($filas['email'] === $email && $filas['password'] === $password && $filas['rol_id'] == 2){
            //Supervisor
            //$_SESSION['varsesion'] = 'supervisor';
            header ("Location: ../supervisor.php");
            $_SESSION['username'] = $username;
            $_SESSION['rol'] = "Supervisor";
        } //else if ($filas['email'] === $email && $filas['password'] === $password && $filas['rol_id'] == 3){
        //    //Tecnico
        //    $_SESSION['varsesion'] = 'tecnico';
        //    header ("Location: ../dashboardTecnico.php");
        //} else if ($filas['email'] === $email && $filas['password'] === $password && $filas['rol_id'] == 4){
        //    //Clientes
        //    header ("Location: ../dashboardCliente.php");
        //} else {
        //    header ("Location: login.php?error=<span style='color:red;font-weight:bold;'>Error:</span> email o contraseña incorrecta");
        //    exit();
        //}
    } else {
        header ("Location: login.php?error=<span style='color:red;font-weight:bold;'>Error:</span> email o contraseña incorrecta");
        exit();
    }
    mysqli_free_result($resultado);
    //mysqli_close($conexion);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PIXIE</title>
    <link rel="shortcut icon" href="../static/img/favicon-32x32.png">

    <!-- EYE PASSWORD -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- STYLE -->
    <link rel="stylesheet" href="../static/css/login.css">

<style>

</style>
</head>

<body>   
<div id="container">
    <section class="side">  
        <img class="login100-pic js-tilt" data-tilt src="../static/img/appletime.png" alt="">   
    </section>

    <section class="main">
        <div class="login-container">
            <p class="title">Bienvenido</p>
            <div class="separator"></div>
            <p class="welcome-message">Escribí el mail y la contraseña</p>

            <form class="login-form" method="POST" action="" autocomplete="off" >
                <div class="form-control">
                    <input type="email" class="input" id="email" name="email" placeholder="Email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" required >
                    <i class="fas fa-user"></i>
                </div>
                <div class="form-control">
                    <input type="password" class="input" name="password" id="password-input" placeholder="Contraseña" required >
                    <i class="fas fa-lock"></i>
                    <i id="icono-mayus" class="fas fa-arrow-up oculto"></i>
                    <i class="eye fa-solid fa-eye" id="eye-input"></i>       
                </div>
                <div id="mensaje">
                    <?php if (isset($_GET['error'])) { ?>
                        <p style="color:red;text-align:center;"><?php echo $_GET['error']; ?></p>
                    <?php } ?>
                </div>

                <button type="submit" name="submit" class="submit">Ingresar</button>
            </form>
        </div>
    </section>
</div>

    <!-- Img Hover 3D -->	
    <script src="../static/vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="../static/vendor/tilt/tilt.jquery.min.js"></script>

    <script type="text/javascript">

    //mostrar mayuscula activada
    var campo = document.getElementById("password-input");
    var iconoMayus = document.getElementById("icono-mayus");
                        
    campo.addEventListener("keydown", function(event) {
      if (event.getModifierState("CapsLock")) {
        iconoMayus.classList.remove("oculto");
      } else {
        iconoMayus.classList.add("oculto");
      }
    });
		
    //efecto OJO
    const passwordInputs = document.querySelectorAll("#password-input");
    const eyeIcons = document.querySelectorAll(".eye");

    eyeIcons.forEach(function(eye, index) {
    eye.addEventListener("click", function() {
        const passwordInput = passwordInputs[index];
        this.classList.toggle("fa-eye-slash");
        const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
        passwordInput.setAttribute("type", type);
        });
    });

    //efecto 3D
    $('.js-tilt').tilt({
	scale: 1.4
	})
	</script>
</body>
</html>