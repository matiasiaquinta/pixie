<?php

include("conexion.php");
session_start();

$id = $_POST["id"];

$sqlEliminar = "DELETE FROM equipos WHERE id=$id";	

	if ($_SESSION['rol'] == 'Administrador'){
	    if(mysqli_query($conn,$sqlEliminar))
		{
		    header("Location: ../administrador.php");
		}
	}

?>