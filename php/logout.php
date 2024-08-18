<?php

//require '../conexion.php';
//
//$_SESSION = [];
//session_unset();
//session_destroy();
//header("Location: login.php");

session_start();
if (session_destroy()){
    header("Location: login.php");
}


?>