<?php
//esto es para los usuarios // me da error
//session_start();

//Connecting to DB - from CleverCloud
$servidor = 'blu3ym2e15d4ekugiosj-mysql.services.clever-cloud.com';
$usuario = 'usz5mc90filjqquk';
$pass = 't0eVzL97rGp5OHV0qSTd';
$baseDatos = 'blu3ym2e15d4ekugiosj';

//Create Connection
$conn = new mysqli($servidor, $usuario, $pass, $baseDatos);

//Check Connection
if (!$conn) {
	echo "Error al conectar con la base de datos  <br><br>";
}

?>