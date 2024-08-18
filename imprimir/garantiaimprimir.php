<?php

function getPlantilla($garantia){
    $contenido='
<body>
    <div id="uno">
        <img src="../static/img/appletime.jpg"  width= "100" height="100">
    </div>
    <div id="dos">
        <h2>APPLETIME - GARANTÍA</h2>
    </div>
    <div id="tres">
        <img src="https://cdn.pixabay.com/photo/2021/07/25/08/07/address-6491205_960_720.png"  width= "15" height="20" style="margin-top:2px;margin-left:2px;"><br><br>
        <img src="https://image.similarpng.com/very-thumbnail/2021/01/Whatsapp-icon-with-black-color-on-transparent-background-PNG.png"  width= "20" height="20" style="margin-top:2px;"><br><br>
        <img src="https://cdn.icon-icons.com/icons2/3261/PNG/512/instagram_logo_icon_206739.png"  width= "20" height="20">
    </div>
    <div id="tres2">
        <p><b>Dirección:</b> Sarmiento 983 - 13° A</p>
        <p><b>Whatsapp:</b> 1132592029</p>
        <p><b>Instagram:</b> @APPLETIMEOK</p>
    </div>';

    $fecha = $_POST["fecha"];
    $iphone = $_POST["iphone"];
    $numeroOrden = $_POST["numeroOrden"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $telefono = $_POST["telefono"];
    $color = $_POST["color"];
    $fallaEquipo = $_POST["fallaEquipo"];
    $detalles = $_POST["detalles"];
    $clave = $_POST["clave"];
    $precio = $_POST["precio"];

    $contenido.='

    <table>
    <tr>
        <th align="center" colspan="4" style="background-color:white;border:0;"></th>
        <th class="fecha">Fecha</th>
        <td class="fecha"> ' .$fecha. '</td>
    </tr>
    <tr>
        <th>Número de Orden:</th>
        <td class="orden">' .$numeroOrden. '</td>
        
        
    </tr>
    <tr>
        <th>Nombre:</th>
        <td>' .$nombre. '</td>
        <th>Apellido:</th>
        <td>' .$apellido. '</td>
        <th >Télefono:</th>
        <td>' .$telefono. '</td>
    </tr>
    <tr>
        <th>Iphone:</th>
        <td>' .$iphone. '</td>
        <th>Color:</th>
        <td>' .$color. '</td>
        <th>Clave:</th>
        <td>' .$clave. '</td>
    </tr>
    <tr>
        <th>Falla del Equipo:</th>
        <td colspan="2">' .$fallaEquipo. '</td>
        <th>Observaciones:</th>
        <td colspan="2">' .$detalles. '</td>
    </tr>
    <tr>
        <th>Precio:</th>
        <td colspan="5" class="precio">' .$precio. '</td>
    </tr>
    <tr>
        <th colspan="6" style="background-color:white;border:0;"></th>
    </tr>
    <tr>
        <th colspan="6" style="background-color:white;border:0;"></th>
    </tr>
    <tr>
        <th colspan="4" style="background-color:white;border:0;"></th>
        <td colspan="2" class="barra"></td>
    </tr>
    <tr>
        <th colspan="4" style="background-color:white;border:0;"></th>
        <td colspan="2" class="firma">Firma Cliente</td>
    </tr>
    <tr>
        <th colspan="2" style="font-size:15px;">Condiciones:</th>
        <th colspan="4" style="background-color:white;border:0;"></th>
    </tr>       
</table>

<div id="siete"> 
    <ul>
        <li>TODAS LAS REPARACIONES CUENTAN CON GARANTIA DE 90 DIAS.</li>
        <li>LAS GARANTIA ES VALIDA UNICAMENTE PARA LA MISMA FALLA POR LA CUAL INGRESO EL EQUIPO.</li>
        <li>LOS EQUIPOS QUE INGRESEN "MUERTOS" NO POSEEN GARANTIA POR FALLA DE ALGUN PERIFERICO (CAMARAS,ALTAVOZ,BOTON HOME, FACE ID, TOUCH ID, ETC) DEBIDO A QUE NO ES POSIBLE SU REVISACION AL MOMENTO DE SER INGRESADO.</li>
        <li>LAS REPARACIONES DE PLACA CUENTAN CON 30 DIAS DE GARANTIA.</li>
        <li>TELEFONOS QUE INGRESEN POR HABERSE MOJADO, NO TIENEN GARANTIA.</li>
        <li>EQUIPO QUE NO INGRESE CON SU CLAVE PARA LA REVISACION DEL MISMO, APPLETIME NO SE HACE CARGO POR FALLAS POSTERIORES AL ARREGLO.</li>
        <li>EL ESTABLECIMIENTO NO SE RESPONSABILIZA PASADOS LOS 60 DIAS DE LA REPARACION SI ELEQUIPO NO FUE RETIRADO.</li>
    </ul>
</div>


</body>';

return $contenido;

}

?>