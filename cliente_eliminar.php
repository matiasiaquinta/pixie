<?php

include("conexion.php");

//Variables a ELIMINAR

$id = $_GET["id"];
$eliminar = "DELETE FROM clientes WHERE id=$id";	
$elimina = $conn->query($eliminar);
header("Location: dashboardAdmin.php");
$conn->close();

?>