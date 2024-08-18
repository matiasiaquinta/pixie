<?php

include("conexion.php");

//$cliente = 'no';
//$empresa = 'no';
$nuevo = 'no';
//$existente = 'no';

// Receive the JSON data from JavaScript
// Sin esto no funciona el $clientSelected
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] === 'application/json') {
    // Obtener los valores enviados desde JavaScript
    $seleccionesUsuario = $data['seleccionesUsuario'];
    $modeloSeleccionado = $data['modeloSeleccionado'];
    $colorSeleccionado = $data['colorSeleccionado'];
    $fallaSeleccionada = $data['fallaSeleccionada'];
    $fechaSeleccionada = $data['fechaSeleccionada'];
    $imeiSeleccionado = $data['imeiSeleccionado'];
    $empresaSeleccionada = $data['empresaSeleccionada'];
    $detallesSeleccionada = $data['detallesSeleccionada'];
    $perifericosSeleccionados = $data['perifericosSeleccionados'];
    $claveSeleccionada = $data['claveSeleccionada'];
    $precioSeleccionado = $data['precioSeleccionado'];

    //CLIENTE EXISTENTE
    $clientSelected = $data['clientSelected'];
    //CLIENTE NUEVO
    $clienteNombre = $data['clienteNombre'];
    $clienteApellido = $data['clienteApellido'];
    $clienteTelefono = $data['clienteTelefono'];

        if (in_array("cliente", $data['seleccionesUsuario'])) {

            //$cliente = 'si';

            if ($clientSelected != ''){
                //$existente = 'si';
                $nuevo = 'no';
                $empresaSeleccionada = 'CLIENTE (' . $clientSelected . ')';
            } else {
                //$existente = 'no';
                $nuevo = 'si';
                $empresaSeleccionada = 'CLIENTE (' . $clienteNombre . ' ' . $clienteApellido . ')';
            }
 
        }
        if (in_array("empresa", $data['seleccionesUsuario'])) {
            $empresa = 'si';
        }

        // Convertir la fecha al formato "dd/mm/yyyy" antes de insertar
        $fecha_formateada = date('d/m/Y', strtotime($fechaSeleccionada));

        // Guardar EMPRESA
        $sqlgrabarEmpresa = "INSERT INTO equipos (fecha, equipo, imei, empresa, falla, detalles, perifericos, color, clave, precio, terminado, paraEntregar) VALUES ('$fecha_formateada', '$modeloSeleccionado','$imeiSeleccionado','$empresaSeleccionada','$fallaSeleccionada','$detallesSeleccionada','$perifericosSeleccionados','$colorSeleccionado','$claveSeleccionada','$precioSeleccionado', 'no', 'no')";
        $sqlgrabarCliente = "INSERT INTO clientes (nombre, apellido, telefono) VALUES ('$clienteNombre','$clienteApellido','$clienteTelefono')";

        if ($nuevo == 'si') {
            if (mysqli_query($conn, $sqlgrabarEmpresa) && mysqli_query($conn, $sqlgrabarCliente))
	        {
		        header("Location: supervisor.php");
	        }
        } else {
            if(mysqli_query($conn,$sqlgrabarEmpresa))
	        {
		        header("Location: supervisor.php");
	        }
        }
        
        
        // Resto del código para ejecutar la consulta y manejar la respuesta
        // ...
    } else {
        // Si no se envió una solicitud POST con datos JSON, enviar una respuesta de error al cliente
        $response = array('status' => 'error', 'message' => 'Solicitud no válida.');
        echo json_encode($response);
    
    
    
    
    
    
    
}  
    //saque el if del empty... porque eso lo manejo del JS
    
//    if (
//        isset($data['seleccionesUsuario']) && !empty($data['seleccionesUsuario']) &&
//        isset($data['modeloSeleccionado']) && !empty($data['modeloSeleccionado']) &&
//        isset($data['colorSeleccionado']) && !empty($data['colorSeleccionado']) &&
//        isset($data['fallaSeleccionada']) && !empty($data['fallaSeleccionada']) &&
//        isset($data['fechaSeleccionada']) && !empty($data['fechaSeleccionada']) &&
//        isset($data['imeiSeleccionado']) && !empty($data['imeiSeleccionado']) &&
//        isset($data['empresaSeleccionada']) && !empty($data['empresaSeleccionada']) &&
//        isset($data['detallesSeleccionada']) && !empty($data['detallesSeleccionada']) &&
//        isset($data['claveSeleccionada']) && !empty($data['claveSeleccionada']) &&
//        isset($data['clienteExistenteSeleccionado']) && !empty($data['clienteExistenteSeleccionado']) &&
//        isset($data['clienteNombre']) && !empty($data['clienteNombre']) &&
//        isset($data['clienteApellido']) && !empty($data['clienteApellido']) &&
//        isset($data['clienteTelefono']) && !empty($data['clienteTelefono'])
//        
//    ) {
//        // Obtener los valores enviados desde JavaScript
//        $seleccionesUsuario = $data['seleccionesUsuario'];
//        $modeloSeleccionado = $data['modeloSeleccionado'];
//        $colorSeleccionado = $data['colorSeleccionado'];
//        $fallaSeleccionada = $data['fallaSeleccionada'];
//        $fechaSeleccionada = $data['fechaSeleccionada'];
//        $imeiSeleccionado = $data['imeiSeleccionado'];
//        $empresaSeleccionada = $data['empresaSeleccionada'];
//        $detallesSeleccionada = $data['detallesSeleccionada'];
//        $claveSeleccionada = $data['claveSeleccionada'];
//        $clienteExistenteSeleccionado = $data['clienteExistenteSeleccionado'];
//
//        //CLIENTE
//        $clienteNombre = $data['clienteNombre'];
//        $clienteApellido = $data['clienteApellido'];
//        $clienteTelefono = $data['clienteTelefono'];
//
//        if (in_array("cliente", $data['seleccionesUsuario'])) {
//            $empresaSeleccionada = 'CLIENTE (' . $clienteExistenteSeleccionado . ')';
//            $clienteEmpresa = 'si';
//        }
//        // Guardar EMPRESA
//        $sqlgrabarEmpresa = "INSERT INTO equipos (fecha, equipo, imei, empresa, falla, detalles, color, clave) VALUES ('$fechaSeleccionada','$modeloSeleccionado','$imeiSeleccionado','$empresaSeleccionada','$fallaSeleccionada','$detallesSeleccionada','$colorSeleccionado','$claveSeleccionada')";
//        $sqlgrabarCliente = "INSERT INTO clientes (nombre, apellido, telefono) VALUES ('$clienteNombre','$clienteApellido','$clienteTelefono')";
//
//        if ($clienteEmpresa == 'si') {
//            if(mysqli_query($conn,$sqlgrabarEmpresa,$sqlgrabarCliente))
//	        {
//		        header("Location: supervisor.php");
//	        }
//        } else {
//            if(mysqli_query($conn,$sqlgrabarEmpresa))
//	        {
//		        header("Location: supervisor.php");
//	        }
//        }
//        // Resto del código para ejecutar la consulta y manejar la respuesta
//        // ...
//    } else {
//        // Si la variable no está presente o está vacía, enviar una respuesta de error al cliente
//        $response = array('status' => 'error', 'message' => 'Variable no válida.');
//        echo json_encode($response);
//    }
//} else {
//    // Si no se envió una solicitud POST con datos JSON, enviar una respuesta de error al cliente
//    $response = array('status' => 'error', 'message' => 'Solicitud no válida.');
//    echo json_encode($response);
//}

?>