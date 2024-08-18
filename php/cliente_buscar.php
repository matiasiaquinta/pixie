<?php

include("conexion.php");

//cliente existente
$searchClient = $_POST["searchClient"];
$getClient = '%' . $searchClient . '%';
$getClientA = '%' . $searchClient . '%';

$sqlClient = "SELECT nombre, apellido FROM clientes WHERE nombre LIKE ? OR apellido LIKE ? ORDER BY nombre ASC";
$queryClient = $conn->prepare($sqlClient);
//$queryClient->execute(["%" . $searchClient . "%"]);
$queryClient->bind_param("ss", $getClient, $getClientA);
//$queryClient->bind_param("s", $getClientA);
$queryClient->execute();
$resultClient = $queryClient->get_result();

$htmlClient = "";

while ($row = $resultClient->fetch_assoc()){
    $htmlClient .= "<li>" . $row["nombre"] . " " . $row["apellido"] . "</li>";
}

echo json_encode($htmlClient, JSON_UNESCAPED_UNICODE); //para que no tenga problemas de tildes

// Leer los datos enviados desde JavaScript y decodificarlos como un objeto
$data = json_decode(file_get_contents('php://input'), true);

?>