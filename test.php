// EMPRESA EDITAR
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
        // Crear un array con los nuevos valores (incluso si no hay cambios)
        $response = array(
            'success' => true,
            'message' => 'Cambios guardados correctamente',
            'nuevosValores' => array(
                'nombre' => $nombreEmpresa,
                'ubicacion' => $ubicacionEmpresa,
                'telefono' => $telefonoEmpresa,
                'pagina' => $paginaEmpresa
            )
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
// FIN EMPRESA EDITAR

// SUPERVISOR SELECT2
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
// FIN SUPERVISOR SELECT

// JS EDITAR
// EDITAR EMPRESA
document.addEventListener("DOMContentLoaded", function() {
  const btnEditarList = document.querySelectorAll(".btnEditar");

  // Obtener el valor almacenado en localStorage para la empresa seleccionada
  let storedCompanyId = localStorage.getItem("currentCompanyId");

  // Obtener el elemento select
  const selectEmpresa = document.getElementById("selectEmpresa");

  // Verificar si hay un valor almacenado en localStorage
  const selectedEmpresa = localStorage.getItem("selectedEmpresa");

  if (selectedEmpresa) {
    // Selecciona automáticamente la opción correspondiente en el select
    selectEmpresa.value = selectedEmpresa;
  }

  // Agregar un evento change al select
  selectEmpresa.addEventListener("change", function() {
    // Obtener el valor seleccionado en el select
    const selectedCompany = selectEmpresa.value;
    // Guardar el valor seleccionado en localStorage
    localStorage.setItem("currentCompanyId", selectedCompany);
    // Actualizar la variable storedCompanyId
    storedCompanyId = selectedCompany;
  });

  btnEditarList.forEach(function(btnEditar) {
      btnEditar.addEventListener("click", function() {
          // Obtener los valores de la empresa desde los atributos de datos
          const empresaId = btnEditar.getAttribute("data-id");
          const companyName = btnEditar.getAttribute("data-empresa");
          
          // Guardar el valor seleccionado en localStorage
          //localStorage.setItem("currentCompanyId", empresaId);
          localStorage.setItem("currentCompanyId", companyName);

          const empresaNombreElement = btnEditar.parentElement.querySelector("h1[data-info='nombre']");
          const empresaUbicacionElement = btnEditar.parentElement.querySelector("span[data-info='ubicacion']");
          const empresaTelefonoElement = btnEditar.parentElement.querySelector("span[data-info='telefono']");
          const empresaPaginaElement = btnEditar.parentElement.querySelector("span[data-info='pagina']");

          const empresaNombre = empresaNombreElement ? empresaNombreElement.textContent : "";
          const empresaUbicacion = empresaUbicacionElement ? empresaUbicacionElement.textContent : "";
          const empresaTelefono = empresaTelefonoElement ? empresaTelefonoElement.textContent : "";
          const empresaPagina = empresaPaginaElement ? empresaPaginaElement.textContent : "";

          // Asignar los valores a los campos del formulario de edición
          document.getElementById("idEditarEmpresa").value = empresaId;
          document.getElementById("nombreEditarEmpresa").value = empresaNombre;
          document.getElementById("ubicacionEditarEmpresa").value = empresaUbicacion;
          document.getElementById("telefonoEditarEmpresa").value = empresaTelefono;
          document.getElementById("paginaEditarEmpresa").value = empresaPagina;

          // Mostrar el formulario de edición
          const popupEditar = document.getElementById("editarEmpresa");
          popupEditar.style.display = "block";
      });
  });

  // Verificar si hay un ID guardado y mostrar el div correspondiente
  if (storedCompanyId) {
      const divToShow = document.querySelector(`li.slide[data-empresa="${storedCompanyId}"]`);
      if (divToShow) {
          divToShow.style.display = "block"; // Muestra el div correspondiente
      }
  }

  // Agregar un evento al botón "Guardar Cambios" fuera del bucle anterior
  const btnGuardarCambios = document.querySelector("#btnGuardarCambios");
  btnGuardarCambios.addEventListener("click", function(event) {
      event.preventDefault();
      // Obtener los valores del formulario de edición
      const idEditarEmpresa = document.getElementById("idEditarEmpresa").value;
      const nombreEditarEmpresa = document.getElementById("nombreEditarEmpresa").value;
      const ubicacionEditarEmpresa = document.getElementById("ubicacionEditarEmpresa").value;
      const telefonoEditarEmpresa = document.getElementById("telefonoEditarEmpresa").value;
      const paginaEditarEmpresa = document.getElementById("paginaEditarEmpresa").value;


      // Validar que los campos no estén vacíos
      if (nombreEditarEmpresa !== "" && ubicacionEditarEmpresa !== "" && telefonoEditarEmpresa !== "" && paginaEditarEmpresa !== "") {
          // Crear un objeto con los datos que deseas enviar al archivo PHP
          var data = {
              idEditarEmpresa: idEditarEmpresa, // Usar el ID guardado previamente
              nombreEditarEmpresa: nombreEditarEmpresa,
              ubicacionEditarEmpresa: ubicacionEditarEmpresa,
              telefonoEditarEmpresa: telefonoEditarEmpresa,
              paginaEditarEmpresa: paginaEditarEmpresa
          };

          // Enviar los datos al servidor mediante Fetch API
          fetch('php/empresa_editar.php', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json'
              },
              body: JSON.stringify(data)
          })
          .then(response => response.json())
          .then(result => {
              // Manejar la respuesta del servidor y actualizar el DOM
              if (result.success) {
                  // Los cambios se guardaron con éxito
                  //alert("Cambios guardados correctamente.");

                  // Actualiza el valor en el localStorage
                  localStorage.setItem("selectedEmpresa", result.nuevosValores.nombre);
                  // Ocultar el formulario de edición                 
                  const popupEditar = document.getElementById("editarEmpresa");
                  popupEditar.style.display = "none";

                  // Actualizar los elementos <span> con los nuevos valores
                  const empresaNombreElement = document.querySelector(`li.slide[data-empresa="${storedCompanyId}"] h1[data-info='nombre']`);
                  const empresaUbicacionElement = document.querySelector(`li.slide[data-empresa="${storedCompanyId}"] span[data-info='ubicacion']`);
                  const empresaTelefonoElement = document.querySelector(`li.slide[data-empresa="${storedCompanyId}"] span[data-info='telefono']`);
                  const empresaPaginaElement = document.querySelector(`li.slide[data-empresa="${storedCompanyId}"] span[data-info='pagina']`);

                  empresaNombreElement.textContent = result.nuevosValores.nombre;
                  empresaUbicacionElement.textContent = result.nuevosValores.ubicacion;
                  empresaTelefonoElement.textContent = result.nuevosValores.telefono;
                  empresaPaginaElement.textContent = result.nuevosValores.pagina;


                  selectEmpresa.value = result.nuevosValores.nombre;
                  console.log(result.nuevosValores.nombre);
              } else {
                  // Hubo un error al guardar los cambios
                  alert("Hubo un error al guardar los cambios.");
              }
          });
      } else {
          alert("Por favor, complete los campos antes de continuar.");
      }
  });
});
// FIN JS EDITAR