<?php

include("conexion.php");
//session_start();

//if ($_SESSION['rol'] == 'Supervisor') {
//    // Supervisor
//    $id = $_POST["idEditarUsuario"];
//    $nombre = $_POST["nombreEditarUsuario"];
//    $email = $_POST["mailEditarUsuario"];
//
//    $sqlmodificar = "UPDATE usuarios SET nombre ='$nombre', email ='$email' WHERE id = '$id'";
//
//    if (mysqli_query($conn, $sqlmodificar)) {
//        header("Location: ../supervisor.php");
//    }
//}

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] === 'application/json') {
    $idUsuario = $data['idEditarUsuario'];
    $nombreUsuario = $data['nombreEditarUsuario'];
    $mailUsuario = $data['mailEditarUsuario'];


    $sqlmodificar = "UPDATE usuarios SET nombre ='$nombreUsuario', email ='$mailUsuario' WHERE id = '$idUsuario'";
    
    if (mysqli_query($conn, $sqlmodificar)) {
        // Consulta para obtener la lista actualizada de usuarios
        $queryUsuarios = "SELECT nombre FROM usuarios";
        $resultUsuarios = mysqli_query($conn, $queryUsuarios);

        $usuariosOptions = array();

        if ($resultUsuarios && mysqli_num_rows($resultUsuarios) > 0) {
            while ($rowUsuario = mysqli_fetch_assoc($resultUsuarios)) {
                $usuario = $rowUsuario['nombre'];
                $usuariosOptions[] = $usuario;
            }
        } else {
            $usuariosOptions[] = "No se encontraron resultados";
        }

        // Crear un array de respuesta que incluya las opciones actualizadas
        $response = array(
            'success' => true,
            'message' => 'Cambios guardados correctamente',
            'nuevosValores' => array(
                'nombre' => $nombreUsuario,
                'mail' => $mailUsuario
            ),
            'usuariosOptions' => $usuariosOptions
        );

        echo json_encode($response);
    } else {
        // En caso de error
        $response = array(
            'success' => false,
            'message' => 'Hubo un error al guardar los cambios'
        );

        echo json_encode($response);
    }
}
//if ($_SESSION['rol'] == 'Administrador') {
//    // Administrador
//    $id = $_POST["idEditarUsuario"];
//    $nombre = $_POST["nombreEditarUsuario"];
//    $email = $_POST["mailEditarUsuario"];
//
//    $idA = $_POST["idEditarUsuarios"];
//    $nombreA = $_POST["nombreEditarUsuarios"];
//    $emailA = $_POST["mailEditarUsuarios"];
//    $passwordA = $_POST["passwordEditarUsuarios"];
//    $rol = $_POST["selectEditarRolUsuario"];
//    $idRol;
//
//
//    if (!empty($id))  // Verificar si $idA tiene valor
//    {
//        $sqlmodificar = "UPDATE usuarios SET nombre ='$nombre', email ='$email' WHERE id = '$id'";
// 
//        if (mysqli_query($conn, $sqlmodificar)) {
//            header("Location: ../administrador.php");
//        }
//    }
//
//    if (!empty($idA))  // Verificar si $idA tiene valor
//    { 
//        
//        if ($rol == 'Administrador') {
//            $idRol = '1';
//        } elseif ($rol == 'Supervisor') {
//            $idRol = '2';
//        } elseif ($rol == 'Tecnico') {
//            $idRol = '3';
//        } elseif ($rol == 'Cliente') {
//            $idRol = '4';
//        }
//
//        $sqlmodificarADMIN = "UPDATE usuarios SET nombre = '$nombreA', email = '$emailA', password = '$passwordA', rol_id = '$idRol' WHERE id = '$idA'";
//
//        if (mysqli_query($conn, $sqlmodificarADMIN)) {
//            header("Location: ../administrador.php");
//        }
//    }
//}



?>