<?php

//include("conexion.php");


require_once ('../static/vendor/autoload.php');
require_once ('../imprimir/garantiaimprimir.php');
$fechaActual = date('d/m/Y');

// Verifica si la solicitud es de tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtén los datos enviados desde JavaScript
    $iphone = $_POST["iphone"];
    $color = $_POST["color"];
    $fallaEquipo = $_POST["fallaEquipo"];
    $fecha = $_POST["fecha"];
    $imei = $_POST["imei"];
    $detalles = $_POST["detalles"];
    $clave = $_POST["clave"];
    $precio = $_POST["precio"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $telefono = $_POST["telefono"];

    // Ahora puedes hacer lo que necesites con estos datos, como generar un PDF

    // Por ejemplo, puedes imprimirlos para verificar que los has recibido correctamente
   //echo "iPhone: " . $iphone . "<br>";
   //echo "Color: " . $color . "<br>";
   //echo "Falla del Equipo: " . $fallaEquipo . "<br>";
   //echo "Fecha: " . $fecha . "<br>";
   //echo "IMEI: " . $imei . "<br>";
   //echo "Detalles: " . $detalles . "<br>";
   //echo "Clave: " . $clave . "<br>";
   //echo "Precio: " . $precio . "<br>";
   //echo "Nombre: " . $nombre . "<br>";
   //echo "Apellido: " . $apellido . "<br>";
   //echo "Teléfono: " . $telefono . "<br>";

    		//IMPRIMIR
		$mpdf=new \Mpdf\Mpdf();
		$css=file_get_contents("../imprimir/stylegarantia.css");

		$plantilla=getPlantilla($garantia);
		$mpdf->writeHTML($css,\Mpdf\HTMLParserMode::HEADER_CSS);
		$mpdf->writeHTML($plantilla,\Mpdf\HTMLParserMode::HTML_BODY);

		//D -> descarga / I -> muestra en la web
		$mpdf->output("Garantia-".$fechaActual ,"I");
}
		//IMPRIMIR
	//	$mpdf=new \Mpdf\Mpdf();
	//	$css=file_get_contents("imprimir/stylegarantia.css");
//
	//	$plantilla=getPlantilla($garantia);
	//	$mpdf->writeHTML($css,\Mpdf\HTMLParserMode::HEADER_CSS);
	//	$mpdf->writeHTML($plantilla,\Mpdf\HTMLParserMode::HTML_BODY);
//
	//	//D -> descarga / I -> muestra en la web
	//	$mpdf->output("Garantia-".$fechaActual ,"I");

		//header("Location: dashboardSupervisor.php");


?>