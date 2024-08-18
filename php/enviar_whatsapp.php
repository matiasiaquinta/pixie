<?php
//TOKEN QUE NOS DA FACEBOOK
$token = 'EAAMEG8sztwYBO3ZBOD7lgyvKnZC2hktE7wVuitaYbkCZCysepz5fi8ssoI3t3Tb9h0lqPfNey96AousDZBbEYeb2jOcN8cIPbCDZAJFMPCJAIsNWdfhunDYI7TG6IEaoMV87LuOgJFWQzsoxkJbNdRw7iu9nVdRmpo5OZBI3hFIiew5YPSnxg92MRqiZA7PYCxNw8aFLG5FKqd9X6pj';
//NUESTRO TELEFONO
$telefono = '541162829588';
//URL A DONDE SE MANDARA EL MENSAJE
$url = 'https://graph.facebook.com/v17.0/119899181200545/messages';

//CONFIGURACION DEL MENSAJE
//Crear una plantilla y reemplazar el nombre hello_world por mi plantilla.
$mensaje = ''
        . '{'
        . '"messaging_product": "whatsapp", '
        . '"to": "'.$telefono.'", '
        . '"type": "template", '
        . '"template": '
        . '{'
        . '     "name": "hello_world",'
        . '     "language":{ "code": "en_US" } '
        . '} '
        . '}';
//DECLARAMOS LAS CABECERAS
$header = array("Authorization: Bearer " . $token, "Content-Type: application/json",);
//INICIAMOS EL CURL, para enviarle los datos por wsp
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POSTFIELDS, $mensaje);
curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//OBTENEMOS LA RESPUESTA DEL ENVIO DE INFORMACION
$response = json_decode(curl_exec($curl), true);
//IMPRIMIMOS LA RESPUESTA 
print_r($response);
//OBTENEMOS EL CODIGO DE LA RESPUESTA
$status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
//CERRAMOS EL CURL
curl_close($curl);


header("Location: supervisor.php");

?>