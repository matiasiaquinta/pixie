<?php
include("php/conexion.php");

    //Si no se ingreso o no corresponde el usuario... tirar error.
    session_start();
    //error_reporting(0); si lo dejo comentado.. no veo ningun error php. Ponerlo una vez finalizado el proyecto. 

    if ($_SESSION['rol'] == null || $_SESSION['rol'] == '' || $_SESSION['rol'] == 'Supervisor'){
        return header ("Location: php/login.php");
        //echo "Usted no tiene autorización";
        //die();
        //deberia crear un error_usuario.php que diga esto y que tenga un boton para volver a iniciar sesion
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>ADMIN - Appletime</title>

   <!-- CND Material Icons Google -->
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

   <!-- SELECT2 
   <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />-->

   <!-- BOOSTRAP MODAL
   <link rel="stylesheet" href="static/css/bootstrap.min.css">

   <!-- CSS General -->
   <link rel="stylesheet" href="static/css/style.css">

</head>
<body>

<!-- ========== CONTAINER ALL ========== -->
<div class="container">

   <!-- ========== SIDEBAR ========== -->
   <aside>
      <div class="top">
         <div class="logo">
            <img src="static/img/logo.png">
            <h2>PI<span class="danger">X</span>IE</h2>
         </div>
         <div class="close" id="close-btn">
            <span class="material-symbols-sharp">close</span>
         </div>
      </div>

      <!-- Sidebar -->
      <div class="sidebar">
         <a class="active" onclick="sidebar_function('div1')">
            <span class="material-symbols-sharp">dashboard</span>
            <h3>Panel de Control</h3>
         </a>
         <a onclick="sidebar_function('div2')">
            <span class="material-symbols-sharp">phone_iphone</span>
            <h3>Equipos</h3>
         </a>
         <a onclick="sidebar_function('div3')">
            <span class="material-symbols-sharp">home</span>
            <h3>Empresas</h3>
         </a>
         <a onclick="sidebar_function('div4')">
            <span class="material-symbols-sharp">group</span>
            <h3>Usuarios</h3>
         </a>
         
         <a onclick="sidebar_function('div5')">
            <span class="material-symbols-sharp">inventory_2</span>
            <h3>Repuestos</h3>
         </a>
         
         <a onclick="sidebar_function('div6')">
            <span class="material-symbols-sharp">settings</span>
            <h3>Configuración</h3>
         </a>
         <a href="php/logout.php">
            <span class="material-symbols-sharp">logout</span>
            <h3>Cerrar Sesión</h3>
         </a>
      </div>
      <div class="version_info">
         <small class="text-muted">Versión: 1.0</small>
      </div>
   </aside>
   <!-- ========== END OF SIDEBAR ========== -->

   <!-- ====== ====== ====== ====== ====== ====== -->
   <!-- ============== #1 ============== -->
   <!-- ====== ====== ====== ====== ====== ====== -->

   <!-- ========== DASHBOARD ========== -->
   <main id="div1" class="sidebar_function saveLocalDiv"> 
      
      <!-- PHP GENERAL -->
      <?php
         //Consulta para contar registros con valor "si" y "no"
         $query_si = "SELECT COUNT(*) AS para_entregar FROM equipos WHERE paraEntregar = 'si'";
         $query_no = "SELECT COUNT(*) AS equipos_pendientes FROM equipos WHERE terminado = 'no'";
         $query_total = "SELECT COUNT(*) AS total_empresas FROM empresas";
         $resultado_si = mysqli_query($conn, $query_si);
         $resultado_no = mysqli_query($conn, $query_no);
         $resultado_total = mysqli_query($conn, $query_total);
         
         //Obtener los resultados de la consulta
         $fila_si = mysqli_fetch_assoc($resultado_si);
         $fila_no = mysqli_fetch_assoc($resultado_no);
         $fila_total = mysqli_fetch_assoc($resultado_total);
      ?>
      
      <div class="left-top">
         <h1>Panel de Control</h1>

         <div class="agregarEquipo">
            <button id="btnAgregarEquipo" onclick="agregarEquipo_function('agregarEquipo')"><span class="material-symbols-sharp">add</span></button>
            <span class="textAgregarEquipo">Agregar Nuevo Equipo</span>
         </div>
      </div>

      <!-- usuario -->
      <div class="right">
         <div class="top">
            <button id="menu-btn">
               <span class="material-symbols-sharp">menu</span>
            </button>
            <div class="theme-toggler">
               <span class="material-symbols-sharp active">light_mode</span>
               <span class="material-symbols-sharp" style="font-variation-settings:'FILL' 1,'wght' 300,'GRAD' 0,'opsz' 48">dark_mode</span>
            </div>
            <div class="profile">
               <div class="info">
                  <p>Hola, <b style="text-transform: uppercase;"><?php echo $_SESSION['username']; ?></b></p>
                  <small class="text-muted"><?php echo $_SESSION['rol']; ?></small>
               </div>
              <!-- <div class="profile-img">
                  <img src="static/img/profile-1.jpg">
               </div>
    -->
            </div>
         </div>
         <!-- fecha y hora -->
         <div class="date-time">
            <div class="date">
               <b>Fecha:</b> <span class="current-date"></span>
            </div>
            <div class="hour">
               <b>Hora:</b> <span class="current-time"></span>
            </div>

            <button id="recargar_sistema">Recargar Sistema</button>
         </div>
      </div>

      <!----- CARDS ----->
      <div class="cards_info">
         <div class="cards_one">
            <span class="material-symbols-sharp">travel_explore</span>
            <div class="middle">
               <div class="left">
                  <h3>Equipos Pendientes</h3>
                  <h1><?php echo $fila_no['equipos_pendientes'];?></h1>
               </div>
            </div>
            <small class="text-muted"></small>
         </div>
         <!----- FIN EQUIPOS PENDIENTES ----->
         <div class="cards_two">
            <span class="material-symbols-sharp">check</span>
            <div class="middle">
               <div class="left">
                  <h3>Equipos para Entregar</h3>
                  <h1><?php echo $fila_si['para_entregar'];?></h1>
               </div>
               <!--
               <div class="progress">
                  <svg>
                     <circle cx="38" cy="38" r="36"></circle>
                  </svg>
                  <div class="number">
                     <p>81%</p>
                  </div>
               </div>
               -->
            </div>
            <small class="text-muted"></small>
         </div>
         <!----- FIN EQUIPOS FINALIZADOS ----->
         <div class="cards_three">
            <span class="material-symbols-sharp">format_list_numbered</span>
            <div class="middle">
               <div class="left">
                  <h3>Cantidad Empresas</h3>
                  <h1><?php echo $fila_total['total_empresas'];?></h1>
               </div>
               <!--
               <div class="progress">
                  <svg>
                     <circle cx="38" cy="38" r="36"></circle>
                  </svg>
                  <div class="number">
                     <p>81%</p>
                  </div>
               </div>
               -->
            </div>
            <small class="text-muted"></small>
         </div>
         <!----- FIN CANTIDAD EMPRESAS ----->
      </div>
      <!----- FIN CARDS ----->   

      <!-- Modal Agregar Equipo Button -->

      <!-- PHP -->
      <?php
               $opcionSeleccionada = '';
                  if ($_SERVER["REQUEST_METHOD"] === "POST") {
                      // Verificar si se ha enviado un formulario
                      if (isset($_POST['item1'])) {
                          $opcionSeleccionada = $_POST['item1'];
                          // Puedes hacer algo con la opción recibida, como guardarla en una base de datos o en una variable PHP para usarla más adelante
                          echo "Opción seleccionada: " . $opcionSeleccionada;
                      }
                  }
               ?>

      <div id="agregarEquipo">
         <div class="agregarEquipo_content">
            <button id="closeAgregarEquipo" class="btnClose">&times;</button>
            <div class="agregarItems">
               <button id="btn1">#1</button>
               <button id="btn2">#2</button>
               <button id="btn3">#3</button>
               <button id="btn4">#4</button>
               <button id="btn5">#5</button>
            </div>
            <div class="agregarContent">

            <!-- ------------------------------------------- -->
               <!-- ITEM 1 -->
               <div id="item1" class="agregarEquipo_function_noscroll">

                  <!-- scrollbar -->
                  <h2>El equipo a ingresar es de:</h2>

                  <div class="buttonsGeneral">
                     <div class="btnItem">
                        <button id="btnCliente" onclick="agregarEquipo_function('cliente')"><span class="material-symbols-sharp">person</span></button>
                        <span>Cliente</span>
                     </div>
                     <div class="btnItem">
                        <button id="btnEmpresa" onclick="agregarEquipo_function('empresa')"><span class="material-symbols-sharp">group</span></button>
                        <span>Empresa</span>
                     </div>
                  </div>
               </div>
               

               <!-- ------------------------------------------- -->
               <!-- ITEM 1_CLIENTE -->
               <div id="item1_cliente" class="agregarEquipo_function_noscroll">

                  <!-- POPUP CLIENTES BTN -->
                  <div id="popupBtnClientes">
                     <h2>Buscar Cliente:</h2>
                        <div id="clienteExistente">
                              <input class="inputSearch" value="" type="text" name="searchClient" id="searchClient" placeholder="Buscar cliente..." autocomplete="off">
                              <span class="material-symbols-sharp searchIcon">search</span>
                        </div>
                        <ul id="listaClient"></ul>

                        <div id="selectedClientContainer">
                           <span id="selectedClient"></span>
                           <button id="clearSelection" class="material-symbols-sharp">close</button>
                        </div>
                        
                        <!-- msg error -->
                        <p class="error clienteExistente_error"></p>
                        
                        <div class="btnItem">
                           <button onclick="agregarEquipo_function('cliente_existente')"><span class="material-symbols-sharp">arrow_forward_ios</span></button>
                           <span>Siguiente</span>
                        </div>

                        <h3>Si no esta creado el cliente, crea un cliente nuevo:</h3>
                        <div class="btnItem">
                           <button id="btnClienteNuevo" onclick="agregarEquipo_function('clienteNuevo')"><span class="material-symbols-sharp">person_add</span></button>
                           <span>Nuevo</span>
                        </div>             
                  </div>
                  
                  <!-- POPUP CLIENTE EXISTENTE BORRAR html css y js -->
                  <div id="popupClienteExistente">
                     <h2>Elegi un Cliente Existente: </h2>
                     <div id="clienteExistente" class="selectItem3">
                        <select name="selectClienteExistente" id="selectClienteExistente">
                           <option value="" selected disabled>Selecciona un cliente...</option>
                           <?php

                           $queryCliente = "SELECT nombre, apellido FROM clientes";
                           $resultCliente = mysqli_query($conn, $queryCliente);

                           if (mysqli_num_rows($resultCliente) > 0){

                              foreach($resultCliente as $row){
                                 ?>
                                    <option value="<?php echo $row['nombre'] . ' ' . $row['apellido']; ?>"><?php echo $row['nombre'] . ' ' . $row['apellido']; ?></option>
                                 <?php
                              }

                           } else {
                              ?>
                                 <option value="">No se encontraron resultados</option>
                              <?php
                           }
                              ?>

                        </select>
                     </div>

                     <div class="btnItem">
                        <button onclick="agregarEquipo_function('cliente_existente')"><span class="material-symbols-sharp">arrow_forward_ios</span></button>
                     </div>
                  </div>

                  <!-- POPUP CLIENTE NUEVO -->
                  <div id="popupClienteNuevo">
                     <h2>Crea un Nuevo Cliente: </h2> 
                     <div class="cliente_info">
                        <div class="valoresInput">
                           <label class="valoresLabel">Nombre</label>
                           <input class="inputShake" id="inputNombre" type="text" name="nombre" placeholder="Escriba el nombre del cliente..." required >
                           <!-- msg error -->
                           <p class="error nuevoNombre_error"></p>
                        </div>
                        

                        <div class="valoresInput">
                           <label class="valoresLabel">Apellido</label>
                           <input class="inputShake" id="inputApellido" type="text" name="apellido" placeholder="Escriba el apellido del cliente..." required >
                           <!-- msg error -->
                           <p class="error nuevoApellido_error"></p>
                        </div>

                        <div class="valoresInput">
                           <label class="valoresLabel">Telefono de Contacto</label>
                           <input class="inputShake" id="inputTelefono" type="text" name="telefono" placeholder="Escriba el telefono del cliente..." required >
                           <!-- msg error -->
                           <p class="error nuevoTelefono_error"></p>
                        </div>
                     </div>

                     <div class="btnItem">
                        <button onclick="agregarEquipo_function('cliente_nuevo')"><span class="material-symbols-sharp">arrow_forward_ios</span></button>
                     </div>
                  </div>
               </div>

               <!-- ------------------------------------------- -->
               <!-- ITEM 2 -->
               <div id="item2" class="agregarEquipo_function_noscroll">
                  <h2>El equipo corresponde a:</h2>
                  <div class="buttonsGeneral">
                     <div class="btnItem">
                        <button id="btnTelefono" onclick="agregarEquipo_function('telefono')"><span class="material-symbols-sharp">phone_iphone</span></button>
                        <span>iPhone</span>
                     </div>
                     <div class="btnItem">
                        <button id="btnTablet" onclick="agregarEquipo_function('tablet')"><span class="material-symbols-sharp">tablet_mac</span></button>
                        <span>iPad</span>
                     </div>
                     <div class="btnItem">
                        <button id="btnNotebook" onclick="agregarEquipo_function('notebook')"><span class="material-symbols-sharp">computer</span></button>
                        <span>Macbook</span>
                     </div>
                     <div class="btnItem">
                        <button id="btnReloj" onclick="agregarEquipo_function('reloj')"><span class="material-symbols-sharp">watch</span></button>
                        <span>iWatch</span>
                     </div>
                  </div>
               </div>

               <!-- ------------------------------------------- -->
               <!-- ITEM 3 -->
               <div id="item3" class="agregarEquipo_function_noscroll">              
                  <div class="datosEquipo">
                     <h2>Elegir Modelo del Equipo</h2>

                           <!-- modelo telefono -->
                           <div id="modeloEquipoTelefono" class="selectItem3">

                              <select name="selectModeloTelefono" id="selectModeloTelefono">
                                 <option value="" selected disabled>Selecciona un modelo...</option>
                                 <?php

                                 $queryModel = "SELECT modelo FROM modelos_iphone";
                                 $resultModel = mysqli_query($conn, $queryModel);

                                 if (mysqli_num_rows($resultModel) > 0){
                                    foreach($resultModel as $row){
                                       ?>
                                          <option value="<?php echo $row['modelo'];?>"><?=$row['modelo'];?></option>
                                       <?php
                                    }
                                 } else {
                                    ?>
                                       <option value="">No se encontraron resultados</option>
                                    <?php
                                 }
                                 ?>

                              </select>
                           </div>

                     <!-- modelo tablet -->
                     <div id="modeloEquipoTablet" class="selectItem3">
                        <select name="selectModeloTablet" id="selectModeloTablet">
                           <option value="" selected disabled>Selecciona un modelo...</option>
                           <?php

                           $queryModel = "SELECT modelo FROM modelos_tablet";
                           $resultModel = mysqli_query($conn, $queryModel);

                           if (mysqli_num_rows($resultModel) > 0){

                              foreach($resultModel as $row){
                                 ?>
                                    <option value="<?php echo $row['modelo'];?>"><?=$row['modelo'];?></option>
                                 <?php
                              }

                           } else {
                              ?>
                                 <option value="">No se encontraron resultados</option>
                              <?php
                           }
                           ?>

                        </select>
                     </div>

                     <!-- modelo notebook -->
                     <div id="modeloEquipoNotebook" class="selectItem3">
                        <select name="selectModeloNotebook" id="selectModeloNotebook">
                           <option value="" selected disabled>Selecciona un modelo...</option>
                           <?php

                           $queryModel = "SELECT modelo FROM modelos_notebook";
                           $resultModel = mysqli_query($conn, $queryModel);

                           if (mysqli_num_rows($resultModel) > 0){

                              foreach($resultModel as $row){
                                 ?>
                                    <option value="<?php echo $row['modelo'];?>"><?=$row['modelo'];?></option>
                                 <?php
                              }

                           } else {
                              ?>
                                 <option value="">No se encontraron resultados</option>
                              <?php
                           }
                           ?>

                        </select>
                     </div>
                     
                     <!-- modelo reloj -->
                     <div id="modeloEquipoReloj" class="selectItem3">
                        <select name="selectModeloReloj" id="selectModeloReloj">
                           <option value="" selected disabled>Selecciona un modelo...</option>
                           <?php

                           $queryModel = "SELECT modelo FROM modelos_reloj";
                           $resultModel = mysqli_query($conn, $queryModel);

                           if (mysqli_num_rows($resultModel) > 0){

                              foreach($resultModel as $row){
                                 ?>
                                    <option value="<?php echo $row['modelo'];?>"><?=$row['modelo'];?></option>
                                 <?php
                              }

                           } else {
                              ?>
                                 <option value="">No se encontraron resultados</option>
                              <?php
                           }
                           ?>

                        </select>                        

                     </div> 

                  
                  </div> <!-- fin modelos equipos -->
                  
                  <!-- msg error -->                
                  <p class="error modeloEquipo_error"></p>


                  <div class="datosEquipo">
                     <h2>Elegir Color del Equipo</h2>
                     
                     <!-- color telefono -->
                     <div id="colorEquipoTelefono" class="selectItem3">
                        <select name="selectColorTelefono" id="selectColorTelefono">
                           <option value="" selected disabled>Selecciona un color...</option>
                           <?php

                           $queryColor = "SELECT color FROM colores_iphone";
                           $resultColor = mysqli_query($conn, $queryColor);

                           if (mysqli_num_rows($resultColor) > 0){

                              foreach($resultColor as $row){
                                 ?>
                                    <option value="<?php echo $row['color'];?>"><?=$row['color'];?></option>
                                 <?php
                              }

                           } else {
                              ?>
                                 <option value="">No se encontraron resultados</option>
                              <?php
                           }
                           ?>

                        </select>
                     </div>

                     <!-- color tablet -->
                     <div id="colorEquipoTablet" class="selectItem3">
                        <select name="selectColorTablet" id="selectColorTablet" required>
                           <option value="" selected disabled>Selecciona un color...</option>
                           <?php

                           $queryColor = "SELECT color FROM colores_tablet";
                           $resultColor = mysqli_query($conn, $queryColor);

                           if (mysqli_num_rows($resultColor) > 0){

                              foreach($resultColor as $row){
                                 ?>
                                    <option value="<?php echo $row['color'];?>"><?=$row['color'];?></option>
                                 <?php
                              }

                           } else {
                              ?>
                                 <option value="">No se encontraron resultados</option>
                              <?php
                           }
                           ?>

                        </select>
                     </div>

                     <!-- color notebook -->
                     <div id="colorEquipoNotebook" class="selectItem3">
                        <select name="selectColorNotebook" id="selectColorNotebook">
                           <option value="" selected disabled>Selecciona un color...</option>
                           <?php

                           $queryColor = "SELECT color FROM colores_notebook";
                           $resultColor = mysqli_query($conn, $queryColor);

                           if (mysqli_num_rows($resultColor) > 0){

                              foreach($resultColor as $row){
                                 ?>
                                    <option value="<?php echo $row['color'];?>"><?=$row['color'];?></option>
                                 <?php
                              }

                           } else {
                              ?>
                                 <option value="">No se encontraron resultados</option>
                              <?php
                           }
                           ?>

                        </select>
                     </div>

                     <!-- color reloj -->
                     <div id="colorEquipoReloj" class="selectItem3">
                        <select name="selectColorReloj" id="selectColorReloj">
                           <option value="" selected disabled>Selecciona un color...</option>
                           <?php

                           $queryColor = "SELECT color FROM colores_reloj";
                           $resultColor = mysqli_query($conn, $queryColor);

                           if (mysqli_num_rows($resultColor) > 0){

                              foreach($resultColor as $row){
                                 ?>
                                    <option value="<?php echo $row['color'];?>"><?=$row['color'];?></option>
                                 <?php
                              }

                           } else {
                              ?>
                                 <option value="">No se encontraron resultados</option>
                              <?php
                           }
                           ?>

                        </select>
                     </div>

                  </div> <!-- fin colores equipos -->

                     <!-- msg error  -->
                     <p class="error modeloColor_error"></p>

                  <div class="btnItem">
                     <button id="btnModeloColor" onclick="agregarEquipo_function('nextTo4')"><span class="material-symbols-sharp">arrow_forward_ios</span></button>
                  </div>   
               </div>

               <!-- ------------------------------------------- -->
               <!-- ITEM 4 -->
               <div id="item4" class="agregarEquipo_function">
                  <h2>Información Adicional:</h2>
                  <!--<div class="clienteInformacion">
                     <form action="">
                        <label for=""></label>
                        <input type="text">
                     </form>
                  </div>-->
                  <div class="empresaInformacion">
                       <div class="valoresInput">
                           <label class="valoresLabel">Fecha</label>
                           <input class="inputNoshake" type="date" name="fecha" id="fechaAutomaticaEmpresa" autocomplete="off" required >
                           <!-- msg error -->                
                           <p class="error fechaAutomatica_error"></p>
                        </div>
                       <div class="valoresInput">
                           <label class="valoresLabel">IMEI</label>
                           <input class="inputShake" id="InputImei" type="text" name="imei"  oninput="validateNumber(this)" placeholder="Escriba el imei del equipo..." autocomplete="off" required > 
                           <!-- msg error -->                
                           <p class="error imei_error"></p>
                        </div>
                       <div class="valoresInput">
                           <label class="valoresLabel" id="labelEmpresa">Empresa</label>
                           <label class="valoresLabel" id="labelCliente">Cliente</label>
                           <input class="inputShake" id="InputEmpresa" type="text" name="empresa" placeholder="Escriba la empresa..." autocomplete="off" required >
                           <!-- select empresas -->
                           <select id="selectInputEmpresa" class="inputNoshake">
                              <option value="" selected disabled>Selecciona una empresa...</option>
                              <?php

                              $queryEmpresa = "SELECT nombre FROM empresas";
                              $resultEmpresa = mysqli_query($conn, $queryEmpresa);

                              if (mysqli_num_rows($resultEmpresa) > 0){

                                 foreach($resultEmpresa as $row){
                                    ?>
                                       <option value="<?php echo $row['nombre'];?>"><?=$row['nombre'];?></option>
                                    <?php
                                 }

                              } else {
                                 ?>
                                    <option value="">No se econtraron resultados</option>
                                 <?php
                              }
                              ?>
                                  <option value="otro">Otro</option> <!-- Opción adicional "Otro" -->
                           </select>
                           <!-- msg error -->                
                           <p class="error empresa_error"></p>
                       </div>

                       <!-- EQUIPO -->
                       <div id="fallaEquipo" class="valoresInput">
                           <label class="valoresLabel">Falla del equipo</label> 
                           <select id="selectFallaTelefono" class="inputNoshake">
                              <option value="" selected disabled>Selecciona una falla...</option>
                              <?php

                              $queryFalla = "SELECT falla FROM fallas_iphone";
                              $resultFalla = mysqli_query($conn, $queryFalla);

                              if (mysqli_num_rows($resultFalla) > 0){

                                 foreach($resultFalla as $row){
                                    ?>
                                       <option value="<?php echo $row['falla'];?>"><?=$row['falla'];?></option>
                                    <?php
                                 }

                              } else {
                                 ?>
                                    <option value="">No se econtraron resultados</option>
                                 <?php
                              }
                              ?>
                                    <option value="otro">Otro...</option>
                           </select>
                       </div>

                        <!-- TABLET -->
                       <div id="fallaTablet" class="valoresInput">
                           <label class="valoresLabel">Falla del equipo</label> 
                           <select id="selectFallaTablet" class="inputNoshake">
                              <option value="" selected disabled>Selecciona una falla...</option>
                              <?php

                              $queryFalla = "SELECT falla FROM fallas_tablet";
                              $resultFalla = mysqli_query($conn, $queryFalla);

                              if (mysqli_num_rows($resultFalla) > 0){

                                 foreach($resultFalla as $row){
                                    ?>
                                       <option value="<?php echo $row['falla'];?>"><?=$row['falla'];?></option>
                                    <?php
                                 }

                              } else {
                                 ?>
                                    <option value="">No se econtraron resultados</option>
                                 <?php
                              }
                              ?>
                                 <option value="otro">Otro...</option>

                           </select>
                       </div>

                       
                        <!-- NOTEBOOK -->
                        <div id="fallaNotebook" class="valoresInput">
                           <label class="valoresLabel">Falla del equipo</label> 
                           <select id="selectFallaNotebook" class="inputNoshake">
                              <option value="" selected disabled>Selecciona una falla...</option>
                              <?php

                              $queryFalla = "SELECT falla FROM fallas_notebook";
                              $resultFalla = mysqli_query($conn, $queryFalla);

                              if (mysqli_num_rows($resultFalla) > 0){

                                 foreach($resultFalla as $row){
                                    ?>
                                       <option value="<?php echo $row['falla'];?>"><?=$row['falla'];?></option>
                                    <?php
                                 }

                              } else {
                                 ?>
                                    <option value="">No se econtraron resultados</option>
                                 <?php
                              }
                              ?>
                                 <option value="otro">Otro...</option>
                           </select>
                       </div>

                       
                        <!-- RELOJ -->
                        <div id="fallaReloj" class="valoresInput">
                           <label class="valoresLabel">Falla del equipo</label> 
                           <select id="selectFallaReloj" class="inputNoshake">
                              <option value="" selected disabled>Selecciona una falla...</option>
                              <?php

                              $queryFalla = "SELECT falla FROM fallas_reloj";
                              $resultFalla = mysqli_query($conn, $queryFalla);

                              if (mysqli_num_rows($resultFalla) > 0){

                                 foreach($resultFalla as $row){
                                    ?>
                                       <option value="<?php echo $row['falla'];?>"><?=$row['falla'];?></option>
                                    <?php
                                 }

                              } else {
                                 ?>
                                    <option value="">No se econtraron resultados</option>
                                 <?php
                              }
                              ?>
                                 <option value="otro">Otro...</option>
                           </select>
                       </div>

                       <!-- msg error -->                
                       <p class="error falla_error"></p>

                       <div class="valoresInput">
                           <label class="valoresLabel">Detalles</label>
                           <input class="inputShake" id="InputDetalles" type="text" name="detalles" placeholder="Escriba los detalles del equipo..." autocomplete="off" required >
                           <!-- msg error -->                
                           <p class="error detalles_error"></p>

                           <label class="valoresLabel">Seleccione lo que no funcione:</label>

                           <div class="container_perifericos">
                              <div class="checkboxes">
                                 <?php
                                 $queryPerifericos = "SELECT periferico FROM perifericos_iphone";
                                 $resultPerifericos = mysqli_query($conn, $queryPerifericos);

                                 if (mysqli_num_rows($resultPerifericos) > 0){
                                    foreach($resultPerifericos as $row){
                                       ?>
                                       <label class="checkbox-label">
                                          <input type="checkbox" name="perifericos[]" value="<?php echo $row['periferico'];?>">
                                          <?php echo $row['periferico'];?>
                                       </label>
                                       <?php
                                    }
                                 } else {
                                    ?>
                                    <p>No se encontraron resultados</p>
                                    <?php
                                 }
                                 ?>
                              </div>
                           </div>
                       </div>
                       <div class="valoresInput">
                           <label class="valoresLabel">Clave del equipo</label>
                           <input class="inputShake" id="InputClave" type="text" name="clave" placeholder="Escriba la clave del equipo..." autocomplete="off" required >
                           <!-- msg error -->                
                           <p class="error clave_error"></p>
                        </div>
                        <div class="valoresInput">
                           <label class="valoresLabel">Precio</label>
                           <input class="inputShake" id="InputPrecio" onkeyup="formatPrice(this)" oninput="validateNumber(this)"placeholder="Escriba el precio de la reparación..." type="text" name="precio" autocomplete="off" required >
                           <!-- msg error -->                
                           <p class="error precio_error"></p>
                        </div>
                      <!-- <div class="valoresBotones">
                           <input type="submit" onclick="agregarEquipo_function('nextTo5')" class="btn btn-primary" id="submitButton" value="Guardar" name="grabardatos" >
                       </div>-->
                        <div class="btnItem" style="margin:0 auto;">
                           <button onclick="agregarEquipo_function('nextTo5')"><span class="material-symbols-sharp">arrow_forward_ios</span></button>
                        </div>
                  </div>
                  
               </div>

               <!-- ------------------------------------------- -->
               <!-- ITEM 5 -->
               <div id="item5" class="agregarEquipo_function">
                  <h2>Finalizar Pedido:</h2>
                  <h3>¡Pedido Cargado Exitosamente!</h3>
                  <div class="buttonsGeneral">
                     <div class="btnItem">
                        <button onclick="agregarEquipo_function('imprimir')"><span class="material-symbols-sharp">print</span></button>
                        <span>Imprimir</span>
                     </div>
                        <div class="btnItem">
                        <button onclick="agregarEquipo_function('mail')"><span class="material-symbols-sharp">mail</span></button>
                        <span>Mail</span>
                     </div>
                  </div>

               </div>

               <div id="finalPedido">
                  <h2>¡Pedido Cargado!</h2>
                  <div class="btnItem">   
                     <button onclick="agregarEquipo_function('fin')">LISTO!</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </main>
   <!-- ========== FIN DASHBOARD ========== -->

   <!-- ====== ====== ====== ====== ====== ====== -->
   <!-- ============== #2 ============== -->
   <!-- ====== ====== ====== ====== ====== ====== -->

   <!-- ========== LISTADO DE EQUIPOS ========== -->
   <main id="div2" class="sidebar_function saveLocalDiv" style="display: none;">
      
   <!-- PHP GENERAL -->
   <?php
         //Consulta para contar registros con valor "si" y "no"
         $query_si = "SELECT COUNT(*) AS cantidad_si FROM equipos WHERE terminado = 'si'";
         $query_no = "SELECT COUNT(*) AS cantidad_no FROM equipos WHERE terminado = 'no'";
         $query_total = "SELECT COUNT(*) as total FROM equipos";
         $resultado_si = mysqli_query($conn, $query_si);
         $resultado_no = mysqli_query($conn, $query_no);
         $resultado_total = mysqli_query($conn, $query_total);
         
         //Obtener los resultados de la consulta
         $fila_si = mysqli_fetch_assoc($resultado_si);
         $fila_no = mysqli_fetch_assoc($resultado_no);
         $fila_total = mysqli_fetch_assoc($resultado_total);
      ?>

      <!----- TABLA ----->
      <div class="table-phones" id="tablaListado">
         
         <div class="tablah1_search">
            <h1>Listado de Equipos</h1>
         </div>

         <div class="tablah2_search">
            <!--<h2>Todos los equipos ingresados:</h2>-->
            <div class="bar">
               <input type="search" id="search-input" name="search" pattern=".*\S.*" required autocomplete="off">
               <button class="search-btn" id="search-button" type="submit">
               </button>
            </div>

            <span id="search_span">Si agregas comillas, la busqueda es literal lo que escribas.</span>

         </div>
         <table>
            <thead>
               <tr>
                  <th>Fecha</th>
                  <th>Equipo</th>
                  <th>IMEI</th>
                  <th>Empresa / Cliente</th>
                  <th>Falla</th>
                  <th>Clave</th>
                  <th>Para Entregar?</th>
                  <th>Mas</th>
                  <th>Editar</th>
                  <th>Eliminar</th>
               </tr>
            </thead>

         <!-- PHP TABLA -->
         <?php
            //$sql = "SELECT id, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha_formateada, equipo, imei, empresa, falla, detalles, color, solucion, repuestoUtilizado, clave, precio, terminado, paraEntregar FROM equipos";
            $sql = "SELECT * FROM equipos";
            $result = mysqli_query($conn, $sql);
            $i = 0;
            
            while ($mostrar = mysqli_fetch_array($result)) {
               $i++;
         ?>

            <tbody id="table-body">
               <tr>
                  <td><?php echo $mostrar['fecha'] ?></td>
                  <td><?php echo $mostrar['equipo'] ?></td>
                  <td><?php echo $mostrar['imei'] ?></td>
                  <td><?php echo $mostrar['empresa'] ?></td>
                  <td><?php echo $mostrar['falla'] ?></td>
                  <td style="display: none;"><?php echo $mostrar['detalles'] ?></td>
                  <td style="display: none;"><?php echo $mostrar['perifericos'] ?></td>
                  <td style="display: none;"><?php echo $mostrar['color'] ?></td>
                  <td style="display: none;"><?php echo $mostrar['solucion'] ?></td>
                  <td style="display: none;"><?php echo $mostrar['repuestoUtilizado'] ?></td>
                  <td><?php echo $mostrar['clave'] ?></td>
                  <td style="display: none;"><?php echo $mostrar['precio'] ?></td>
                  <td style="display: none;"><?php echo $mostrar['terminado'] ?></td>
                  <td><?php echo $mostrar['paraEntregar'] ?></td>
                  <td><button class="btnOpenDetalles" data-id="<?php echo $mostrar['id']; ?>"><span class="material-symbols-sharp">add</span></button></td>
                  <td><button class="btnOpenEditar" data-id="<?php echo $mostrar['id']; ?>"><span class="material-symbols-sharp">edit_square</span></button></td>
                  <td><button class="btnEliminar" onclick="confirmDeleteEquipo(this);" data-id="<?php echo $mostrar['id']; ?>" data-equipo="<?php echo $mostrar['equipo']; ?>" data-empresa="<?php echo $mostrar['empresa']; ?>"><span class="material-symbols-sharp">delete</span></td>
               </tr>

         <?php
            }
         ?>
            </tbody>
         </table>
         
         <!-- Paginación -->
         <ul class="pagination" id="paginationListado">
            <!-- Los enlaces de paginación se agregarán aquí dinámicamente -->
         </ul>
         <!--<span id="total-pages"></span>-->
      </div>
      <!----- FIN TABLA ----->

      <!-- modal Agregar nueva empresa -->
      <div id="deleteEquipo">
         <div class="agregarEmpresa_content">
            <span class="confirm-delete"></span>
            <form method="POST" action="php/equipo_eliminar.php" id="form_delete_equipo">
               <input type="hidden" name="id">
            </form>

            <div class="buttonsDelete">
               <button class="redDelete" type="submit" form="form_delete_equipo"><span>si</span></button>
               <button type="button" onclick="cancelDeleteEquipo();"><span>cancelar</span></button>
            </div>

         </div>
      </div>


   </main>
   <!-- ========== FIN LISTADO DE EQUIPOS ========== -->

<!-- EDITAR Y MAS DETALLES POR FUERA DE TODOS MIS MAIN PARA USARLOS EN CUALQUIER LADO -->
<!-- Editar y Mas Detalles -->
<div id="editarEquipo" class="ModalEditar">
            <div class="editar_content">
               <button class="btnClose">&times;</button>
       
               <h2>Editar Equipo:</h2>

               <!-- PHP para obtener los SELECTS -->
               <?php

               ?>
       
               <form id="formEditar" action="php/equipo_editar.php" method="POST">
               <input type="hidden" name="idEditar" id="idEditar" >

               <div id="editarScroll" id="popupEditarTelefono">

                  <div class="form-editar">
                      <label for="">Fecha</label>
                      <input type="text" name="fechaEditar" id="fechaEditar">
                  </div>

                  <!-- Select Modelo -->
                  <?php
                     $equipos = array(
                         'telefono' => 'modelos_iphone',
                         'tablet' => 'modelos_tablet',
                         'notebook' => 'modelos_notebook',
                         'reloj' => 'modelos_reloj'
                     );
                     
                     foreach ($equipos as $equipo => $tabla) {
                         $resultModelos = mysqli_query($conn, "SELECT modelo FROM $tabla");
                         echo "<div class=\"select-editar\" id=\"modelo-$equipo\">
                                  <label for=\"\">Modelo</label>
                                  <select name=\"equipoEditar\" id=\"modeloEditar-$equipo\">";
                         
                         if ($resultModelos && mysqli_num_rows($resultModelos) > 0) {
                             while ($rowModelo = mysqli_fetch_assoc($resultModelos)) {
                                 $modelo = $rowModelo['modelo'];
                                 echo "<option value=\"$modelo\">$modelo</option>";
                             }
                         } else {
                             echo "<option value=\"\">No se encontraron resultados</option>";
                         }
                         
                         echo "</select>
                               </div>";
                     }
                  ?>
            
                  <div class="form-editar">
                      <label for="">IMEI</label>
                      <input type="text" name="imeiEditar" id="imeiEditar" autocomplete="off" >
                  </div>

                  <!-- empresa -->
                  <!-- input -->
                  <div class="select-editar" id="showInputClient">
                     <label for="">Cliente</label>
                     <!--<input type="text" name="clienteEditar" id="clienteEditar">-->
                     <select name="clienteEditar" id="clienteEditar">

                     <?php
                        $queryClientes = "SELECT nombre, apellido FROM clientes";
                        $resultClientes = mysqli_query($conn, $queryClientes);

                        if ($resultClientes && mysqli_num_rows($resultClientes) > 0) {
                           while ($rowCliente = mysqli_fetch_assoc($resultClientes)) {
                              $nombreCliente = $rowCliente['nombre'];
                              $apellidoCliente = $rowCliente['apellido'];
                              echo "<option value=\"$nombreCliente $apellidoCliente\">$nombreCliente $apellidoCliente</option>";
                           }
                        } else {
                           echo "<option value=\"\">No se encontraron resultados</option>";
                        }
                     ?>

                     </select>
                  </div>

                  <!-- select -->
                  <div class="select-editar" id="showSelectEmpresa">
                     <label for="">Empresa</label>
                     <select name="empresaEditar" id="empresaEditar">

                     <?php
                        $queryEmpresas = "SELECT nombre FROM empresas";
                        $resultEmpresas = mysqli_query($conn, $queryEmpresas);

                        if ($resultEmpresas && mysqli_num_rows($resultEmpresas) > 0) {
                           while ($rowEmpresa = mysqli_fetch_assoc($resultEmpresas)) {
                              $empresa = $rowEmpresa['nombre'];
                              echo "<option value=\"$empresa\">$empresa</option>";
                           }
                        } else {
                           echo "<option value=\"\">No se encontraron resultados</option>";
                        }
                     ?>

                     </select>
                  </div>
                  
                  <!-- para ver si es empresa o cliente -->
                  <input type="hidden" name="select_seleccionado" id="select_seleccionado" value="">

                                              
                  <!-- Select Falla -->
                  <?php
                     $fallas = array(
                         'telefono' => 'fallas_iphone',
                         'tablet' => 'fallas_tablet',
                         'notebook' => 'fallas_notebook',
                         'reloj' => 'fallas_reloj'
                     );
                     
                     foreach ($fallas as $equipo => $tabla) {
                         $resultFallas = mysqli_query($conn, "SELECT falla FROM $tabla");
                         echo "<div class=\"select-editar\" id=\"falla-$equipo\">
                                  <label for=\"\">Falla</label>
                                  <select name=\"fallaEditar\" id=\"fallaEditar-$equipo\">";
                         
                         if ($resultFallas && mysqli_num_rows($resultFallas) > 0) {
                             while ($rowFalla = mysqli_fetch_assoc($resultFallas)) {
                                 $falla = $rowFalla['falla'];
                                 echo "<option value=\"$falla\">$falla</option>";
                             }
                         } else {
                             echo "<option value=\"\">No se encontraron resultados</option>";
                         }
                         
                         echo "</select>
                               </div>";
                     }
                  ?>
                     
                  <div class="form-editar">
                      <label for="">Detalles</label>
                      <input type="text" name="detallesEditar" id="detallesEditar" autocomplete="off" >
                  </div>

                  <!-- aca los checkboxes -->
                  <div class="container_perifericos_editar">
                  <label for="">Seleccione lo que no funciona</label>
                     <div class="checkboxes">
                        <?php
                        $queryPerifericos = "SELECT periferico FROM perifericos_iphone";
                        $resultPerifericos = mysqli_query($conn, $queryPerifericos);

                        if (mysqli_num_rows($resultPerifericos) > 0){
                           foreach($resultPerifericos as $row){
                              ?>
                              <label class="checkbox-label">
                                 <input type="checkbox" name="perifericos[]" value="<?php echo $row['periferico'];?>">
                                 <?php echo $row['periferico'];?>
                              </label>
                              <?php
                           }
                        } else {
                           ?>
                           <p>No se encontraron resultados</p>
                           <?php
                        }
                        ?>
                     </div>
                  </div>
                  <!-- fin checkboxes -->
                     
                  <!-- Select Falla -->
                  <?php
                     $colores = array(
                         'telefono' => 'colores_iphone',
                         'tablet' => 'colores_tablet',
                         'notebook' => 'colores_notebook',
                         'reloj' => 'colores_reloj'
                     );
                     
                     foreach ($colores as $equipo => $tabla) {
                         $resultColores = mysqli_query($conn, "SELECT color FROM $tabla");
                         echo "<div class=\"select-editar\" id=\"color-$equipo\">
                                  <label for=\"\">Color</label>
                                  <select name=\"colorEditar\" id=\"colorEditar-$equipo\">";
                         
                         if ($resultColores && mysqli_num_rows($resultColores) > 0) {
                             while ($rowColor = mysqli_fetch_assoc($resultColores)) {
                                 $color = $rowColor['color'];
                                 echo "<option value=\"$color\">$color</option>";
                             }
                         } else {
                             echo "<option value=\"\">No se encontraron resultados</option>";
                         }
                         
                         echo "</select>
                               </div>";
                     }
                  ?>
                     
                  <div class="form-editar">
                      <label for="">Solucion</label>
                      <input type="text" name="solucionEditar" id="solucionEditar" autocomplete="off" >
                  </div>
                     
                  <div class="form-editar">
                      <label for="">Repuesto utilizado</label>
                      <input type="text" name="repuestoUtilizadoEditar" id="repuestoUtilizadoEditar" autocomplete="off" >
                  </div>
                     
                  <div class="form-editar">
                      <label for="">Clave del equipo</label>
                      <input type="text" name="claveEditar" id="claveEditar" autocomplete="off" >
                  </div>
                     
                  <div class="form-editar">
                      <label for="">Precio del equipo</label>
                      <input type="text" name="precioEditar" id="precioEditar" onkeyup="formatPrice(this)" autocomplete="off" >
                  </div>
                     
                  <div class="terminado-editar">
                     <div class="uno">
                         <label class="terminadoTitulo">¿Terminado?</label>
                         <div class="valoresTerminado">
                             <input class="terminadoInput" type="radio" name="terminadoEditar" value="si" id="terminadoSi">
                             <label class="terminadoLabel" for="terminadoSi">SI</label>
                             <input class="terminadoInput" type="radio" name="terminadoEditar" value="no" id="terminadoNo">
                             <label class="terminadoLabel" for="terminadoNo">NO</label>
                         </div>
                     </div>
                     
                     <div class="uno">
                         <label class="terminadoTitulo">¿Para Entregar?</label>
                         <div class="valoresTerminado">
                             <input class="terminadoInput" type="radio" name="paraEntregarEditar" value="si" id="paraEntregarSi">
                             <label class="terminadoLabel" for="paraEntregarSi">SI</label>
                             <input class="terminadoInput" type="radio" name="paraEntregarEditar" value="no" id="paraEntregarNo">
                             <label class="terminadoLabel" for="paraEntregarNo">NO</label>
                         </div>
                     </div>
                  </div>
      
                  <div class="cerrarEditar">
                      <button type="submit" class="btn btn-primary">Guardar cambios</button>
                  </div>
               </div>
            </div>
         </form>
      </div>
      <!-- FIN Modal Editar Equipo Button -->

         <!-- Modal Mas Detalles Button -->
         <div id="masDetalles" class="ModalDetalles">
            <div class="modal-content_detalles">
               
               <div class="spanTitle">
                  Mas detalles del equipo:  <span id="name_equipo"></span><span id="name_cliente">, del cliente: </span> <span id="name_empresa">de la empresa: </span>
               </div>
               
               <button class="btnClose" style="background-color:#41f1b6;color:black;padding:5px 10px 5px 10px;">&times;</button>
            
               <input type="hidden" name="idMasDetalles" id="idMasDetalles" >

               <div class="detalles_content">

                  <div class="itemsLeft">
                     <div class="grid_items">
                        <span class="detalles_titulo">Detalles:</span>
                        <span class="detalles_info" id="valorDetalles"></span>
                     </div>
                     <div class="grid_items">
                        <span class="detalles_titulo">Solución:</span>
                        <span class="detalles_info" id="valorSolucion"></span>
                     </div>
                     <div class="grid_items">
                        <span class="detalles_titulo">Repuesto Utilizado:</span>
                        <span class="detalles_info" id="valorRepuesto"></span>
                     </div>
                  </div>

                  <div class="itemsRight">
                     <div class="grid_items">
                        <span class="detalles_titulo">Color:</span>
                        <span class="detalles_info" id="valorColor"></span>
                     </div>
                     <div class="grid_items">
                        <span class="detalles_titulo">Precio:</span>
                        <span class="detalles_info" id="valorPrecio"></span>
                     </div>
                     <div class="grid_items">
                        <span class="detalles_titulo">¿Terminado?:</span>
                        <span class="detalles_info" id="valorTerminado"></span>
                     </div>
                  </div>

                  <div class="itemsBottom">
                     <div class="grid_items">
                        <span class="detalles_titulo">Perifericos fallados:</span>
                        <span class="detalles_info" id="valorPeriferico"></span>
                     </div>
                  </div>
                     
               </div>
                     
               <div class="btnItem">
                  <button class="btnOk">OK</button>
               </div>

            </div>
         </div>
      <!-- FIN Editar y Mas Detalles -->
<!-- fin prueba -->

   <!-- ========== EMPRESA ========== -->
   <main id="div3" class="sidebar_function saveLocalDiv" style="display: none;"> 

   <div class="divTop">
      
      <div class="divLeft">
      <h1>Empresas</h1>

<div class="agregarEquipo">
   <button id="btnAgregarEmpresa" onclick="agregarEmpresa_function('empresa')"><span class="material-symbols-sharp">add</span></button>
   <span class="textAgregarEquipo">Agregar Nueva Empresa</span>
</div>

<div class="selectEmpresa">
   <span>Selecciona una empresa</span>
   <select id="selectEmpresa">
      <option selected disabled>Elegi una empresa</option>

      <?php
         $queryEmpresas = "SELECT nombre FROM empresas";
         $resultEmpresas = mysqli_query($conn, $queryEmpresas);

         if ($resultEmpresas && mysqli_num_rows($resultEmpresas) > 0) {
            while ($rowEmpresa = mysqli_fetch_assoc($resultEmpresas)) {
               $empresa = $rowEmpresa['nombre'];
               echo "<option value=\"$empresa\">$empresa</option>";
            }
         } else {
            echo "<option value=\"\">No se encontraron resultados</option>";
         }
      ?>

   </select>
</div>
</div> <!-- div left -->

<!-- info empresas -->
<div class="slider-wrapper">
         <div id="containerEmpresas">
            <!--<button class="slide-arrow" id="slide-arrow-prev">
              &#8249;
            </button>
            <button class="slide-arrow" id="slide-arrow-next">
              &#8250;
            </button>-->
            <ul class="slides-container" id="slides-container">
               <?php
                  $sql = "SELECT * FROM empresas ";
                  $empresa = mysqli_query($conn, $sql);
                  $empresas = mysqli_fetch_all($empresa, MYSQLI_ASSOC);
                  $totalEmpresas = count($empresas);
                  $position = 0;

                      foreach ($empresas as $resultEmpresa) {                  
                          $parts = explode('@', $resultEmpresa['email']);
                          $domain = end($parts);

                          //busco la cantidad de emails
                          $resultUser = mysqli_query($conn, "SELECT COUNT(*) as count FROM usuarios WHERE email LIKE '%@$domain'");
                          $row = mysqli_fetch_assoc($resultUser);
                          $count = $row['count'];

                          //saveDivLocal
                          $position++;
                  ?>
              <li class="slide" data-empresa="<?php echo $resultEmpresa['nombre'] ?>">
                  <div class="infoEmpresa">
                      <div class="infoDetalle">
                           <h1 data-info="nombre"><?php echo $resultEmpresa['nombre'] ?></h1>
                          <div>
                              <h3>Ubicación: </h3><span data-info="ubicacion"><?php echo $resultEmpresa['ubicacion'] ?></span>
                          </div>
                          <div>
                              <h3>Telefono: </h3><span data-info="telefono"><?php echo $resultEmpresa['telefono'] ?></span>
                          </div>
                          <div>
                              <h3>Pagina: </h3><span data-info="pagina"><?php echo $resultEmpresa['pagina'] ?></span>
                          </div>
                          <div>
                              <h3>Usuarios Registrados: </h3><span><?php echo $count; ?></span>
                          </div>
                          <span class="totalEmpresa">Total Empresas: <?php echo $position; ?>/<?php echo $totalEmpresas; ?></span>
                      
                      <button class="btnEditar" data-id="<?php echo $resultEmpresa['id']; ?>">Editar Empresa</button>
                      <div class="space"></div>
                      <button class="btnDominio" data-domain="<?php echo $domain; ?>"><span class="material-symbols-sharp">keyboard_double_arrow_down</span></button>
                      </div>
                  </div>

              </li>
              <?php 
                  }
              ?>
            </ul>

            <div class="spanInfoEmpresa">
               <span>Selecciona una empresa para visualizar sus caracteristicas: </span>
            </div>

         </div>
      </div> <!-- div right -->
      <!-- fin info empresas -->
   </div> <!-- div top -->

      <!-- popup editar empresa -->
      <div id="editarEmpresa" class="ModalEditar">
         <div class="editar_content">
            <button class="btnClose">&times;</button>
       
            <h2>Editar Empresa:</h2>
            
            <input type="hidden" name="idEditarEmpresa" id="idEditarEmpresa" >

            <div id="editarScrollEmpresa">
               <div class="form-editar">
                   <label for="">Nombre</label>
                   <input type="text" name="nombreEditarEmpresa" id="nombreEditarEmpresa" autocomplete="off" >
               </div>

               <div class="form-editar">
                   <label for="">Ubicación</label>
                   <input type="text" name="ubicacionEditarEmpresa" id="ubicacionEditarEmpresa" autocomplete="off" >
               </div>

               <div class="form-editar">
                   <label for="">Telefono</label>
                   <input type="text" name="telefonoEditarEmpresa" id="telefonoEditarEmpresa" autocomplete="off" >
               </div>

               <div class="form-editar">
                   <label for="">Pagina</label>
                   <input type="text" name="paginaEditarEmpresa" id="paginaEditarEmpresa" autocomplete="off" >
               </div>
      
               <div class="cerrarEditar">
                   <button id="btnGuardarCambios" class="btn btn-primary">Guardar cambios</button>
               </div>
            </div>
         </div>
      </div>

   <!-- modal Agregar nueva empresa -->
   <div id="agregarEmpresa">
      <div class="agregarEmpresa_content">
         <button id="closeAgregarEmpresa" class="btnClose">&times;</button>
         <h2>Ingresar los datos de la empresa: </h2>
         
         <div class="datosNuevaEmpresa">
            <div class="valoresInput">
                <label class="valoresLabel">Nombre</label>
                <input class="inputShake" id="InputNombreEmpresa" type="text" name="nombre" placeholder="Escriba el nombre de la empresa..." autocomplete="off" required >
                <!-- msg error -->                
                <p class="error nombre_error"></p>
             </div>
            <div class="valoresInput">
                <label class="valoresLabel">Mail <span style="font-size: 0.6em;">(@empresa.com, ejemplo: @appletime.com)</span> </label>
                <input class="inputShake" id="InputMailEmpresa" type="text" name="mail" placeholder="Escriba el mail de la empresa..." autocomplete="off" required > 
                <!-- msg error -->                
                <p class="error mail_error"></p>
             </div>
            <div class="valoresInput">
                <label class="valoresLabel">Ubicación</label>
                <input class="inputShake" id="InputUbicacionEmpresa" type="text" name="ubicacion" placeholder="Escriba la ubicacion de la empresa..." autocomplete="off" required >
                <!-- msg error -->                
                <p class="error ubicacion_error"></p>
            </div>
            <div class="valoresInput">
                <label class="valoresLabel">Telefono</label>
                <input class="inputShake" id="InputTelefonoEmpresa" type="text" name="telefono" placeholder="Escriba el telefono de la empresa..." autocomplete="off" required >
                <!-- msg error -->                
                <p class="error telefono_error"></p>
            </div>
            <div class="valoresInput">
                <label class="valoresLabel">Página</label>
                <input class="inputShake" id="InputPaginaEmpresa" type="text" name="pagina" placeholder="Escriba la pagina de la empresa..." autocomplete="off" required >
                <!-- msg error -->                
                <p class="error pagina_error"></p>
            </div>

            <div class="btnItem" style="margin:0 auto;">
               <button onclick="agregarEmpresa_function('empresaOk')"><span class="material-symbols-sharp">arrow_forward_ios</span></button>
            </div>

         </div>
      </div>
   </div>

   <!-- modal Agregar nuevo usuario rol4-->
   <div id="agregarUsuario">
      <div class="agregarEmpresa_content">
         <button id="closeAgregarUsuario" class="btnClose">&times;</button>
         <h2>Ingresar los datos del usuario: </h2>


         <div class="datosNuevaEmpresa">
            <div class="valoresInput">
                <label class="valoresLabel">Nombre</label>
                <input class="inputShake" id="InputNombreUsuario" type="text" name="nombre" placeholder="Escriba el nombre del usuario..." autocomplete="off" required >
                <!-- msg error -->                
                <p class="error Unombre_error"></p>
            </div>
            <div class="valoresInput">
                <label class="valoresLabel">Mail</label>
                <input class="textEmpresa" id="InputMailUsuario" type="text" name="mail" placeholder="Escriba el mail del usuario..." autocomplete="off" required>
                <input class="nombreEmpresa" id="nombreEmpresa" type="text" name="nombreEmpresa" autocomplete="off" readonly>
                <!-- msg error -->                
                <p class="error Umail_error"></p>
            </div>
            <div class="valoresInput">
                <label class="valoresLabel">Contraseña</label>
                <input class="inputShake" id="InputPasswordUsuario" type="text" name="password" placeholder="Escriba la contraseña del usuario..." autocomplete="off" required >
                <!-- msg error -->                
                <p class="error Upassword_error"></p>
            </div>

            <div class="btnItem" style="margin:0 auto;">
               <button onclick="agregarEmpresa_function('usuarioOk')"><span class="material-symbols-sharp">arrow_forward_ios</span></button>
            </div>

         </div>
      </div>
   </div>

      <!-- info + tabla usuarios -->
      <div class="spanTablaUsuarios">
         <span>Usuarios de las empresas que cargan equipos al sistema: </span>
      </div>

      <div class="usuariosTable">
         <div class="divLeftUsuariosTable">
            <div class="titleEmpresa">

               <span>Empresa</span>
               <h1 id="empresaName"></h1>
            </div>

            <div class="agregarUsuario">
               <button id="btnAgregarUsuario" onclick="agregarEmpresa_function('usuario')"><span class="material-symbols-sharp">add</span></button>
               <span class="textAgregarEquipo">Crear Usuario</span>
            </div>
         </div>

         <!----- TABLA USUARIOS ----->
         <div id="containerTableUsuarios">
            
            <?php
            $sql = "SELECT * FROM usuarios";
            $result = mysqli_query($conn, $sql);
            $usuarios = mysqli_fetch_all($result, MYSQLI_ASSOC);

            $dominioUsuarios = array();

            foreach ($usuarios as $resultUsuarios) {
                $parts = explode('@', $resultUsuarios['email']);
                $domain = end($parts);
            
                if (!isset($dominioUsuarios[$domain])) {
                    $dominioUsuarios[$domain] = array();
                }
             
                $dominioUsuarios[$domain][] = $resultUsuarios;
            }

            ?>

            <!-- tabla usuarios -->
            <table id="tablaUsuarios">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Fecha de Creación</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dominioUsuarios as $domain => $usuariosPorDominio) { ?>
                        <tr>
                            <td colspan="5" style="display:none;"><strong>@<?php echo $domain; ?></strong></td>
                        </tr>
                        <?php foreach ($usuariosPorDominio as $row) { ?>
                            <tr>
                                <td><?php echo $row['nombre'] ?></td>
                                <td><?php echo $row['email'] ?></td>
                                <td><?php echo $row['fechaCreacion'] ?></td>
                                <td><button class="btnOpenEditarUsuario" data-id="<?php echo $row['id']; ?>"><span class="material-symbols-sharp">edit_square</span></button></td>
                                <td><button class="btnUsuarioEliminar" onclick="confirmDelete(this, '¿Estás seguro de querer eliminar a este usuario?', 'php/usuario_eliminar.php');" data-id="<?php echo $row['id']; ?>" data-mail="<?php echo $row['email']; ?>"><span class="material-symbols-sharp">delete</span></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
         </div>
      </div>
      <!-- fin info + tabla usuarios -->

      <!-- popup editar user -->
      <div id="editarUser" class="ModalEditar">
         <div class="editar_content">
            <button class="btnClose">&times;</button>
       
            <h2>Editar Usuario:</h2>

            <form id="formEditarUsuario" action="php/usuario_editar.php" method="POST">
            
               <input type="hidden" name="idEditarUsuario" id="idEditarUsuario" >

               <div id="editarScrollUsuario">
                  <div class="form-editar">
                      <label for="">Nombre</label>
                      <input type="text" name="nombreEditarUsuario" id="nombreEditarUsuario" autocomplete="off" >
                  </div>
                           
                  <div class="form-editar">
                      <label for="">Mail</label>
                      <input type="text" name="mailEditarUsuario" id="mailEditarUsuario" autocomplete="off" >
                  </div>
      
                  <div class="cerrarEditar">
                      <button type="submit" class="btn btn-primary">Guardar cambios</button>
                  </div>
               </div>
            </form>
         </div>
      </div>

      <!-- popup delete user -->
      <div id="deleteUser">
         <div class="agregarEmpresa_content">
            <span class="confirm-message"></span>
            <form method="POST" action="php/usuario_eliminar.php" id="form_delete_user">
               <input type="hidden" name="id">
            </form>

            <div class="buttonsDelete">
               <button class="redDelete" type="submit" form="form_delete_user"><span>si</span></button>
               <button type="button" onclick="cancelDelete();"><span>cancelar</span></button>
            </div>

         </div>
      </div>

      <!----- tabla debajo empresas ----->
      <div id="containerTablaEquiposEmpresas">
         <div>
            <span>Todos los equipos de la empresa seleccionada: </span>
         </div>

            <!-- PHP TABLA -->
            <?php
               $sqlEquipos = "SELECT * FROM equipos";
               $resultEquipos = mysqli_query($conn, $sqlEquipos);
               $equipos = mysqli_fetch_all($resultEquipos, MYSQLI_ASSOC);

               $dominioEquipos = array();

               foreach ($equipos as $equipo) {
                  $parts = explode('@', $equipo['empresa']);
                  $domain = reset($parts); // Tomar solo el nombre de la empresa
               
                   if (!isset($dominioEquipos[$domain])) {
                       $dominioEquipos[$domain] = array();
                   }
                
                   $dominioEquipos[$domain][] = $equipo;
               }
            ?>

            <!-- Aquí puedes mostrar la tabla con los equipos de la empresa seleccionada -->
            <table id="tablaEquiposPorEmpresa">
               <thead>
                  <tr>
                     <th>Fecha</th>
                     <th>Equipo</th>
                     <th>IMEI</th>
                     <th>Empresa / Cliente</th>
                     <th>Falla</th>
                     <th>Clave</th>
                     <th>Para Entregar?</th>
                     <th>Mas</th>
                     <th>Editar</th>
                  </tr>
               </thead>
               <tbody>
                  <?php foreach ($dominioEquipos as $domain => $equiposPorDominio) { ?>
                        <tr>
                            <td colspan="5" style="display:none;"><strong>@<?php echo $domain; ?></strong></td>
                        </tr>
                        <?php foreach ($equiposPorDominio as $equipo) { ?>
                            <tr>
                        <td><?php echo $equipo['fecha'] ?></td>
                        <td><?php echo $equipo['equipo'] ?></td>
                        <td><?php echo $equipo['imei'] ?></td>
                        <td><?php echo $equipo['empresa'] ?></td>
                        <td><?php echo $equipo['falla'] ?></td>
                        <td style="display: none;"><?php echo $equipo['detalles'] ?></td>
                        <td style="display: none;"><?php echo $equipo['perifericos'] ?></td>
                        <td style="display: none;"><?php echo $equipo['color'] ?></td>
                        <td style="display: none;"><?php echo $equipo['solucion'] ?></td>
                        <td style="display: none;"><?php echo $equipo['repuestoUtilizado'] ?></td>
                        <td><?php echo $equipo['clave'] ?></td>
                        <td style="display: none;"><?php echo $equipo['precio'] ?></td>
                        <td style="display: none;"><?php echo $equipo['terminado'] ?></td>
                        <td><?php echo $equipo['paraEntregar'] ?></td>
                        <td><button class="btnOpenDetalles" data-id="<?php echo $equipo['id']; ?>"><span class="material-symbols-sharp">add</span></button></td>
                        <td><button class="btnOpenEditar" data-id="<?php echo $equipo['id']; ?>"><span class="material-symbols-sharp">edit_square</span></button></td>
                     </tr>
                  <?php } 
                  }?>
               </tbody>
            </table>
      </div>
      <!----- fin tabla debajo empresas ----->



   </main>
   <!-- ========== FIN EMPRESA ========== -->

   <!-- ========== USUARIOS ========== -->
   <main id="div4" class="sidebar_function saveLocalDiv" style="display: none;"> 
      
      <div class="divLeftUsuario">
         <h1>Usuarios</h1>

         <div class="agregarEquipo">
            <button id="btnAgregarUsuario02" onclick="agregarUsuario_function('usuario')"><span class="material-symbols-sharp">add</span></button>
            <span class="textAgregarEquipo">Agregar Nuevo Usuario</span>
         </div>
      </div> <!-- div left -->

      <!-- tabla usuarios -->
      <div id="containerTableUsuarios02">
         <table id="tablaUsuarios02">
             <thead>
                 <tr>
                     <th>Nombre</th>
                     <th>Email</th>
                     <th>Contraseña</th>
                     <th>Rol</th>
                     <th>Editar</th>
                     <th>Eliminar</th>
                 </tr>
             </thead>
             <tbody>
             <?php
               $sql = "SELECT * FROM usuarios";
               $result = mysqli_query($conn, $sql);
               $i = 0;
                  
               while ($mostrar = mysqli_fetch_array($result)) {
                  $i++;
            ?>
               <tr>
                   <td><?php echo $mostrar['nombre'] ?></td>
                   <td><?php echo $mostrar['email'] ?></td>
                   <td style="display:none;"><?php echo $row['fechaCreacion'] ?></td>
                   <td class="centered-cell">
                       <span id="password_<?php echo $mostrar['id']; ?>" style="display: none;"><?php echo $mostrar['password'] ?></span>
                       <span class="maskedPassword" id="maskedPassword_<?php echo $mostrar['id']; ?>"><?php echo str_repeat('*', strlen($mostrar['password'])); ?></span>
                       <button class="btnShowHide"
                               onmousedown="showPassword(<?php echo $mostrar['id']; ?>)"
                               onmouseup="hidePassword(<?php echo $mostrar['id']; ?>)"
                               onmouseout="hidePassword(<?php echo $mostrar['id']; ?>)">👁️</button>
                   </td>
                   <td><?php
                           $rolId = $mostrar['rol_id'];
                           if ($rolId == 1) {
                               echo "Administrador";
                           } elseif ($rolId == 2) {
                               echo "Supervisor";
                           } elseif ($rolId == 3) {
                               echo "Técnico";
                           } elseif ($rolId == 4) {
                               echo "Cliente";
                           } 
                   ?></td>
                   <td><button class="btnOpenEditarUsuarios" data-id="<?php echo $mostrar['id']; ?>"><span class="material-symbols-sharp">edit_square</span></button></td>
                   <td><button class="btnEliminar" onclick="confirmDeleteUsers(this);" data-id="<?php echo $mostrar['id']; ?>" data-mail="<?php echo $mostrar['email']; ?>"><span class="material-symbols-sharp">delete</span></button></td>
               </tr>
            <?php } ?>
            </tbody>
         </table>
      </div>
      <!-- fin info + tabla usuarios -->

      <!-- popup editar user -->
      <div id="editarUsers" class="ModalEditar">
         <div class="editar_content">
            <button class="btnClose">&times;</button>
       
            <h2>Editar Usuario:</h2>

            <form id="formEditarUsuarios" action="php/usuario_editar.php" method="POST">
            
               <input type="hidden" name="idEditarUsuarios" id="idEditarUsuarios" >

               <div id="editarScrollUsuarios">
                  <div class="form-editar">
                      <label for="">Nombre</label>
                      <input type="text" name="nombreEditarUsuarios" id="nombreEditarUsuarios" autocomplete="off" >
                  </div>
                           
                  <div class="form-editar">
                      <label for="">Mail</label>
                      <input type="text" name="mailEditarUsuarios" id="mailEditarUsuarios" autocomplete="off" >
                  </div>

                  <div class="form-editar">
                      <label for="">Contraseña</label>
                      <input type="text" name="passwordEditarUsuarios" id="passwordEditarUsuarios" autocomplete="off" >
                  </div>

                  <div id="rolEditarUsuario" class="select-editar">
                     <label for="">Rol</label>
                     <select name="selectEditarRolUsuario" id="selectEditarRolUsuario">
                        <?php
                           $resultRoles = mysqli_query($conn, "SELECT rol FROM roles");
                           if ($resultRoles && mysqli_num_rows($resultRoles) > 0) {
                               while ($rowRol = mysqli_fetch_assoc($resultRoles)) {
                                   $rol = $rowRol['rol'];
                                   echo "<option value=\"$rol\">$rol</option>";
                               }
                           } else {
                               echo "<option value=\"\">No se encontraron roles</option>";
                           }
                        ?>
                     </select>
                  </div>

      
                  <div class="cerrarEditar">
                      <button type="submit" class="btn btn-primary">Guardar cambios</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
      
      <!-- eliminar usuario -->
      <div id="deleteUsers">
         <div class="agregarEmpresa_content">
            <span class="confirm-delete_users"></span>
            <form method="POST" action="php/usuario_eliminar.php" id="form_delete_users">
               <input type="hidden" name="id">
            </form>

            <div class="buttonsDelete">
               <button class="redDelete" type="submit" form="form_delete_users"><span>si</span></button>
               <button type="button" onclick="cancelDeleteUsers();"><span>cancelar</span></button>
            </div>

         </div>
      </div>

      <!-- agregar usuario -->
      <div id="agregarUsuario02">
      <div class="agregarEmpresa_content">
         <button id="close02AgregarUsuario" class="btnClose">&times;</button>
         <h2>Ingresar usuarios para este negocio: </h2>


         <div class="datosNuevaEmpresa">
            <div class="valoresInput">
                <label class="valoresLabel">Nombre</label>
                <input class="inputShake" id="InputAgregarNombre" type="text" name="nombre" placeholder="Escriba el nombre del usuario..." autocomplete="off" required >
                <!-- msg error -->                
                <p class="error Anombre_error"></p>
            </div>
            <div class="valoresInput">
                <label class="valoresLabel">Mail</label>
                <input class="inputShake" id="InputAgregarMail" type="text" name="mail" placeholder="Escriba el mail del usuario..." autocomplete="off" required >
                <!-- msg error -->                
                <p class="error Amail_error"></p>
            </div>
            <div class="valoresInput">
                <label class="valoresLabel">Contraseña</label>
                <input class="inputShake" id="InputAgregarPassword" type="text" name="password" placeholder="Escriba la contraseña del usuario..." autocomplete="off" required >
                <!-- msg error -->                
                <p class="error Apassword_error"></p>
            </div>

            <div id="rolUsuario" class="valoresInput">
               <label class="valoresLabel">Rol</label>
               <select name="rolUsuario" id="selectRolUsuario" class="inputShake">
                  <option value="" selected disabled>Selecciona un rol...</option>
                  <?php

                  $queryRol = "SELECT * FROM roles";
                  $resultRol = mysqli_query($conn, $queryRol);

                  if (mysqli_num_rows($resultRol) > 0){

                     foreach($resultRol as $row){
                        ?>
                           <option value="<?php echo $row['id'];?>"><?=$row['rol'];?></option>
                        <?php
                     }

                  } else {
                     ?>
                        <option value="">No se encontraron resultados</option>
                     <?php
                  }
                  ?>

               </select>

               <!-- msg error -->                
               <p class="error rolUser_error"></p>

            </div>


            <div class="btnItem" style="margin:0 auto;">
               <button onclick="agregarUsuario_function('usuarioOk')"><span class="material-symbols-sharp">arrow_forward_ios</span></button>
            </div>

         </div>

   </main>
   <!-- ========== FIN USUARIOS ========== -->


   <!-- ========== REPUESTOS ========== -->
   <main id="div5" class="sidebar_function saveLocalDiv" style="display: none;"> 
      
      <div class="left-top">
         <h1>Repuestos</h1>
         <br><br>
         <h2>En Mantenimiento...</h2>
      </div>

   </main>
   <!-- ========== FIN REPUESTOS ========== -->

      <!-- ========== REPUESTOS ========== -->
   <main id="div6" class="sidebar_function saveLocalDiv" style="display: none;"> 
      
      <div>
         <h1>Configuración</h1>
      </div>

      <div class="containerConfig">
         <div class="tabsMenu">
            <a href="#generalConfig" class="tab_item active">General</a>
            <a href="#mensajeConfig" class="tab_item">Mensajes al Cliente</a>
            <a href="#ocultarConfig" class="tab_item">Ocultar Elementos</a>
         </div>

         <div class="tabsContent" id="generalConfig">
            <span>Toda la configuración general del sistema</span>
         </div>

         <div class="tabsContent" id="mensajeConfig">
            <span>Configurar los textos que se envian a los clientes a traves de mensajes de texto o mail</span>
         </div>

         <div class="tabsContent" id="ocultarConfig">
            <span>Elementos que se pueden ocultar para trabajar a tu gusto</span>
         </div>

      </div>
      

   </main>
   <!-- ========== FIN REPUESTOS ========== -->



</div> <!-- end container all -->   

   <!--CLASES JS
   <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>-->

   <!-- Mi JS -->
   <script src="static/js/main.js"></script>

  <!-- <script>
      $(document).ready(function() {
          $('.js-example-basic-single').select2();
      });
   </script> -->
   

</body>
</html>