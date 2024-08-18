<?php
    include("conexion.php");
    session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Variables a EDITAR
    $id = $_POST["idEditar"];
    
    $fecha = $_POST["fechaEditar"];
    $equipo = $_POST["equipoEditar"];
    $imei = $_POST["imeiEditar"];
    $empresa = $_POST["empresaEditar"];
    $cliente = $_POST["clienteEditar"];
    $falla = $_POST["fallaEditar"];
    $detalles = $_POST["detallesEditar"];
    $perifericosSeleccionados = $_POST["perifericos"];
    $color = $_POST["colorEditar"];
    $solucion = $_POST["solucionEditar"];
    $repuestoUtilizado = $_POST["repuestoUtilizadoEditar"];
    $clave = $_POST["claveEditar"];
    // Eliminar el símbolo de $ y cualquier carácter que no sea un dígito del precio
    //$precio = preg_replace("/[^\d]/", "", $_POST["precioEditar"]);
    $precio = $_POST["precioEditar"];
    $terminado = $_POST["terminadoEditar"];
    $paraEntregar = $_POST["paraEntregarEditar"];

    //para saber si es cliente o empresa
    $select_seleccionado = $_POST["select_seleccionado"];
    $empresacliente;

    if ($select_seleccionado === "cliente") {
        $empresacliente = "CLIENTE (" . $cliente . ")";
    } elseif ($select_seleccionado === "empresa") {
        $empresacliente = $empresa;
    }

    //para ver que perifericos hay
    $perifericos;

    if (!empty($perifericosSeleccionados)) {
        $perifericos = implode(", ", $perifericosSeleccionados);
    } else {
        $perifericos = "OK";
    }

    //editar
    //echo "$id, $fecha, $equipo, $imei, $empresa, $falla, $detalles, $color, $solucion, $repuestoUtilizado, $clave, $precio, $terminado, $paraEntregar";
    $sqlmodificar = "UPDATE equipos SET fecha = '$fecha', equipo = '$equipo', imei = '$imei', empresa = '$empresacliente', falla = '$falla', detalles = '$detalles', perifericos = '$perifericos', color = '$color', solucion = '$solucion', repuestoUtilizado = '$repuestoUtilizado', clave = '$clave', precio = '$precio', terminado = '$terminado', paraEntregar = '$paraEntregar' WHERE id = $id";

    if(mysqli_query($conn,$sqlmodificar))
    {

        if ($_SESSION['rol'] == 'Supervisor') {
            header("Location: ../supervisor.php");
        } else if ($_SESSION['rol'] == 'Administrador') {
            header("Location: ../administrador.php");
        }

    } else {
    echo "Error en la consulta: " . mysqli_error($conn);
    }
    
}
    
    
?>