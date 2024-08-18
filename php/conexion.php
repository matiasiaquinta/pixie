<?php
//esto es para los usuarios // me da error
//session_start();

//Connecting to DB - from CleverCloud
$servidor = 'localhost';
$usuario = 'root';
$pass = '';
$baseDatos = 'pixie';

//Create Connection
$conn = new mysqli($servidor, $usuario, $pass, $baseDatos);

//Check Connection
if (!$conn) {
	echo "Error al conectar con la base de datos  <br><br>";
}

?>