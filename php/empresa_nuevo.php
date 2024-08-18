<?php

include("conexion.php");

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] === 'application/json') {
    $nombreSeleccionado = $data['nombreSeleccionado'];
    $mailSeleccionado = $data['mailSeleccionado'];
    $ubicacionSeleccionado = $data['ubicacionSeleccionado'];
    $telefonoSeleccionado = $data['telefonoSeleccionado'];
    $paginaSeleccionado = $data['paginaSeleccionado'];


    $sqlgrabarEmpresa = "INSERT INTO empresas (nombre, email, ubicacion, telefono, pagina) VALUES ('$nombreSeleccionado', '$mailSeleccionado', '$ubicacionSeleccionado', '$telefonoSeleccionado', '$paginaSeleccionado')";


    if(mysqli_query($conn,$sqlgrabarEmpresa))
    {
        header("Location: supervisor.php");
    }

}

?>