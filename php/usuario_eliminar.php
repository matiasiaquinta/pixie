<?php

include("conexion.php");
session_start();

$id = $_POST["id"];

$sqlEliminar = "DELETE FROM usuarios WHERE id=$id";	

	if ($_SESSION['rol'] == 'Supervisor'){
	    if(mysqli_query($conn,$sqlEliminar))
		{
		    header("Location: ../supervisor.php");
		}
	}

	if ($_SESSION['rol'] == 'Administrador'){
	    if(mysqli_query($conn,$sqlEliminar))
		{
		    header("Location: ../administrador.php");
		}
	}

?>