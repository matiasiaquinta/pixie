<?php
include("conexion.php");

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] === 'application/json') {
    $idEmpresa = $data['idEditarEmpresa'];
    $nombreEmpresa = $data['nombreEditarEmpresa'];
    $ubicacionEmpresa = $data['ubicacionEditarEmpresa'];
    $telefonoEmpresa = $data['telefonoEditarEmpresa'];
    $paginaEmpresa = $data['paginaEditarEmpresa'];

    $sqlmodificar = "UPDATE empresas SET nombre ='$nombreEmpresa', ubicacion = '$ubicacionEmpresa', telefono = '$telefonoEmpresa', pagina = '$paginaEmpresa' WHERE id = '$idEmpresa'";

    if (mysqli_query($conn, $sqlmodificar)) {
        // Consulta para obtener la lista actualizada de empresas
        $queryEmpresas = "SELECT nombre FROM empresas";
        $resultEmpresas = mysqli_query($conn, $queryEmpresas);

        $empresasOptions = array();

        if ($resultEmpresas && mysqli_num_rows($resultEmpresas) > 0) {
            while ($rowEmpresa = mysqli_fetch_assoc($resultEmpresas)) {
                $empresa = $rowEmpresa['nombre'];
                $empresasOptions[] = $empresa;
            }
        } else {
            $empresasOptions[] = "No se encontraron resultados";
        }

        // Crear un array de respuesta que incluya las opciones actualizadas
        $response = array(
            'success' => true,
            'message' => 'Cambios guardados correctamente',
            'nuevosValores' => array(
                'nombre' => $nombreEmpresa,
                'ubicacion' => $ubicacionEmpresa,
                'telefono' => $telefonoEmpresa,
                'pagina' => $paginaEmpresa
            ),
            'empresasOptions' => $empresasOptions
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
?>
