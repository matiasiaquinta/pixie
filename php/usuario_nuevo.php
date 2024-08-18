<?php

include("conexion.php");
session_start();

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreSeleccionado = $data['nombreSeleccionado'];
    $mailSeleccionado = $data['mailSeleccionado'];
    $passwordSeleccionado = $data['passwordSeleccionado'];
    $rolSeleccionado = $data['rolSeleccionado'];

    // Obtener la fecha actual en el formato deseado (día/mes/año)
    $fechaCreacion = date('d/m/Y'); // Formato: Día/Mes/Año

    $esCliente = $data['esCliente'];

    $sqlgrabarUsuario = "INSERT INTO usuarios (nombre, email, fechaCreacion, password, rol_id) VALUES ('$nombreSeleccionado', '$mailSeleccionado', '$fechaCreacion', '$passwordSeleccionado', '4')";
    $sqlgrabarUsuarioADMIN = "INSERT INTO usuarios (nombre, email, fechaCreacion, password, rol_id) VALUES ('$nombreSeleccionado', '$mailSeleccionado', '$fechaCreacion', '$passwordSeleccionado', '$rolSeleccionado')";

    //SUPERVISOR
    if ($_SESSION['rol'] == 'Supervisor' && $esCliente == 'si') {
        if(mysqli_query($conn,$sqlgrabarUsuario))
	    {
		    header("Location: ../supervisor.php");
	    }
    }
    //ADMINISTRADOR
    if ($_SESSION['rol'] == 'Administrador' && $esCliente == 'si') {
        if(mysqli_query($conn,$sqlgrabarUsuario))
	    {
		    header("Location: ../administrador.php");
	    }
    }
    if ($_SESSION['rol'] == 'Administrador' && $esCliente == 'no') {
        if(mysqli_query($conn,$sqlgrabarUsuarioADMIN))
	    {
		    header("Location: ../administrador.php");
	    }
    }
    
}
?>
