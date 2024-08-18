<?php

$mysqli= new mysqli("localhost","root","123","reportesbd");
$mysqli->set_charset("utf8");
$consulta=$mysqli->prepare("SELECT * FROM productos");
$consulta->execute();
$resultados=$consulta->get_result();
$productos=array();
while($row=$resultados->fetch_assoc()) $productos[]=$row;
$mysqli->close();

