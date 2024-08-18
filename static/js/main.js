//SET TIME AND DATE ACTUAL EVERY 1 SECOND
function updateDateTime() {
    var now = new Date();

    var dateDivs = document.getElementsByClassName("current-date");
    for (var i = 0; i < dateDivs.length; i++) {
        dateDivs[i].textContent = now.toLocaleDateString();
    }

    var timeDivs = document.getElementsByClassName("current-time");
    for (var j = 0; j < timeDivs.length; j++) {
        timeDivs[j].textContent = now.toLocaleTimeString();
    }
}

// Actualizar la fecha y hora cada segundo
setInterval(updateDateTime, 1000);

// Recargar web on clic button
var botonRecargar = document.getElementById("recargar_sistema");

// Agregar un evento al hacer clic en el botón
botonRecargar.addEventListener("click", function () {
    // Recargar la página
    location.reload();
});

// ============================ SIDEBAR + DARK LIGHT THEME =====================================
const sideMenu = document.querySelector("aside");
const menuBtns = document.querySelectorAll(".menu-btn");
const closeBtn = document.querySelector("#close-btn");

// Show sidebar on any menu button click
menuBtns.forEach((menuBtn) => {
    menuBtn.addEventListener("click", () => {
        sideMenu.style.display = "block";
    });
});

// Close sidebar
closeBtn.addEventListener("click", () => {
    sideMenu.style.display = "none";
});

//- THEME TOGGLER - DARK LIGHT THEME =================================
const themeToggler = document.querySelector(".theme-toggler");
const body = document.body;

// Función para cambiar el tema y gestionar la clase .active
function toggleTheme() {
    const isDarkMode = body.classList.toggle("dark-theme-variables");
    themeToggler
        .querySelector("span:nth-child(1)")
        .classList.toggle("active", !isDarkMode);
    themeToggler
        .querySelector("span:nth-child(2)")
        .classList.toggle("active", isDarkMode);

    // Guardar el estado del tema en el almacenamiento local
    localStorage.setItem("darkMode", isDarkMode);
}

// Mostrar el tema guardado en el almacenamiento local al cargar la página
window.addEventListener("load", () => {
    const isDarkMode = localStorage.getItem("darkMode") === "true";
    body.classList.toggle("dark-theme-variables", isDarkMode);
    themeToggler
        .querySelector("span:nth-child(1)")
        .classList.toggle("active", !isDarkMode);
    themeToggler
        .querySelector("span:nth-child(2)")
        .classList.toggle("active", isDarkMode);
});

// Cambiar tema al hacer clic
themeToggler.addEventListener("click", toggleTheme);
//FIN - THEME TOGGLER - DARK LIGHT THEME =================================

// ============================ SAVE POSITION DIV (when reload stay in the same div) =====================================
function sidebar_function(div) {
    // Obtener todos los divs de la barra de navegación
    var navbarDivs = document.getElementsByClassName("saveLocalDiv");

    // Recorrer los divs y ocultar todos menos el que se ha hecho clic
    for (var i = 0; i < navbarDivs.length; i++) {
        if (navbarDivs[i].id == div) {
            navbarDivs[i].style.display = "block";
        } else {
            navbarDivs[i].style.display = "none";
        }
    }

    // Guardar el id del div actual en el almacenamiento local
    localStorage.setItem("currentDiv", div);

    var links = document.querySelectorAll(".sidebar a");
    links.forEach(function (link) {
        link.classList.remove("active");
    });

    var clickedLink = document.querySelector(
        "a[onclick=\"sidebar_function('" + div + "')\"]"
    );
    clickedLink.classList.add("active");
}
// Obtener el id del div actual almacenado en el almacenamiento local
var currentDivId = localStorage.getItem("currentDiv");
// Verificar si hay un div actual guardado
if (currentDivId) {
    // Mostrar el div actual guardado en la barra de navegación
    sidebar_function(currentDivId);
} else {
    // No hay un div actual guardado, mostrar el primer div por defecto en la barra de navegación
    sidebar_function("div1");
}

//function showDiv(divId) {
//var divs = document.getElementsByClassName("content-div");
//
//// Ocultar todos los divs
//for (var i = 0; i < divs.length; i++) {
//  divs[i].style.display = "none";
//}
//
//// Mostrar el div correspondiente al divId recibido
//var divToShow = document.getElementById(divId);
//divToShow.style.display = "block";
//
//// Guardar el id del div en el almacenamiento local
//localStorage.setItem("currentDiv", divId);
//}

// ============================ TABLE  =====================================

//SEARCH con este busca literalmente no lo que se escriba
//const searchInput = document.getElementById('search-input');
//const tableRows = document.querySelectorAll('#table-body tr');
//
//searchInput.addEventListener('input', function() {
//    const searchTerm = searchInput.value.trim();
//    const searchRegex = new RegExp(`^${searchTerm}$`, 'i');
//
//    tableRows.forEach(row => {
//        const rowData = Array.from(row.cells).map(cell => cell.textContent.trim());
//        const shouldDisplay = rowData.some(data => searchRegex.test(data));
//        row.style.display = shouldDisplay ? '' : 'none';
//    });
//});

//SEARCH
const searchInput = document.getElementById("search-input");
const tableRows = document.querySelectorAll("#table-body tr");

searchInput.addEventListener("input", function () {
    const searchTerm = searchInput.value.trim();
    const literalSearch =
        searchTerm.startsWith('"') && searchTerm.endsWith('"');

    const normalizedSearchTerm = literalSearch
        ? searchTerm.substring(1, searchTerm.length - 1).toLowerCase()
        : searchTerm.toLowerCase();

    tableRows.forEach((row) => {
        const rowData = Array.from(row.cells).map((cell) =>
            cell.textContent.trim().toLowerCase()
        );
        const shouldDisplay = rowData.some((data) => {
            if (literalSearch) {
                return data === normalizedSearchTerm;
            } else {
                return data.includes(normalizedSearchTerm);
            }
        });
        row.style.display = shouldDisplay ? "" : "none";
    });
});

// agregue en totalPages el -1 en la ecuacion, porque sino me hacia una pagina vacia
// esto es para agregar paginas en la tabla  y que se muestren solo 10 filas por pagina.
// PANEL Y LISTADO Son mis dos tablas que son distintas.
document.addEventListener("DOMContentLoaded", function () {
    var tableRowsListado = document.querySelectorAll("#tablaListado tbody tr");
    var rowsPerPage = 10;
    var currentPageListado = 1; // Página actual para la tabla "Listado"
    var totalPagesListado = Math.ceil(tableRowsListado.length / rowsPerPage);

    function showPage(page, tableRows) {
        var startIndex = (page - 1) * rowsPerPage;
        var endIndex = startIndex + rowsPerPage;

        tableRows.forEach(function (row, index) {
            row.style.display =
                index >= startIndex && index < endIndex ? "table-row" : "none";
        });
    }

    function updatePagination(
        paginationElement,
        totalPages,
        currentPage,
        tableRows
    ) {
        paginationElement.innerHTML = "";

        // Mostrar máximo 5 páginas
        var maxPages = 5;
        var startPage = Math.max(currentPage - Math.floor(maxPages / 2), 1);
        var endPage = Math.min(startPage + maxPages - 1, totalPages);

        // Botón "anterior"
        if (currentPage > 1) {
            var prevLi = document.createElement("li");
            var prevLink = document.createElement("a");
            prevLink.textContent = "<";
            prevLink.addEventListener("click", function () {
                currentPage--;
                showPage(currentPage, tableRows);
                updatePagination(
                    paginationElement,
                    totalPages,
                    currentPage,
                    tableRows
                );
            });
            prevLi.appendChild(prevLink);
            paginationElement.appendChild(prevLi);
        }

        // Páginas numeradas
        for (var i = startPage; i <= endPage; i++) {
            var li = document.createElement("li");
            var link = document.createElement("a");
            link.textContent = i;
            link.addEventListener("click", function () {
                currentPage = parseInt(this.textContent);
                showPage(currentPage, tableRows);
                updatePagination(
                    paginationElement,
                    totalPages,
                    currentPage,
                    tableRows
                );
            });

            if (i === currentPage) {
                li.classList.add("active");
            }

            li.appendChild(link);
            paginationElement.appendChild(li);
        }

        // Botón "siguiente"
        if (currentPage < totalPages) {
            var nextLi = document.createElement("li");
            var nextLink = document.createElement("a");
            nextLink.textContent = ">";
            nextLink.addEventListener("click", function () {
                currentPage++;
                showPage(currentPage, tableRows);
                updatePagination(
                    paginationElement,
                    totalPages,
                    currentPage,
                    tableRows
                );
            });
            nextLi.appendChild(nextLink);
            paginationElement.appendChild(nextLi);
        }
    }

    var paginationListado = document.getElementById("paginationListado");

    showPage(currentPageListado, tableRowsListado);
    updatePagination(
        paginationListado,
        totalPagesListado,
        currentPageListado,
        tableRowsListado
    );
});

// ============================ POPUPS =====================================
//Popup Modal Editar Equipo Button
//esto es lo del modal para abrir mas detalles y editar. modal son popus.

//ALL

//var ES = document.getElementById("queEs");
//var inputValue = ES.value.toLowerCase();
//var TipoEquipo = '';

function editar_function(item) {
    //    //EDITAR
    //  var modalEditar = document.getElementsByClassName("editarEquipo");
    //  var btnOpenEditar = document.getElementsByClassName("btnOpenEditar");
    //
    //  // modelo
    //  var modeloTelefono = document.getElementById("EDITARselectModeloTelefono");
    //  var modeloTablet = document.getElementById("EDITARselectModeloTablet");
    //  var modeloNotebook = document.getElementById("EDITARselectModeloNotebook");
    //  var modeloReloj = document.getElementById("EDITARselectModeloReloj");
    //  // color
    //  var colorTelefono = document.getElementById("EDITARcolorEquipoTelefono");
    //  var colorTablet = document.getElementById("EDITARcolorEquipoTablet");
    //  var colorNotebook = document.getElementById("EDITARcolorEquipoNotebook");
    //  var colorReloj = document.getElementById("EDITARcolorEquipoReloj");
    //  // falla
    //  var fallaTelefono = document.getElementById("EDITARfallaTelefono");
    //  var fallaTablet = document.getElementById("EDITARfallaTablet");
    //  var fallaNotebook = document.getElementById("EDITARfallaNotebook");
    //  var fallaReloj = document.getElementById("EDITARfallaReloj");
    //
    //  if (item === "openEdit") {
    //    //registrarSeleccion("OpenEdit");
    //    modalEditar.style.display = "flex";
    //  }
    //
    //
    //  var valorTipoEquipo = document.getElementById("valorTipoEquipo" + dataId);
    //  var valorTipoEquipoMinuscula = valorTipoEquipo.value.toLowerCase();
    //  var TipoEquipo = '';
    //
    //  if (valorTipoEquipoMinuscula.includes('iphone')){
    //    TipoEquipo = "iphone"
    //  } else if (valorTipoEquipoMinuscula.includes('ipad')){
    //    TipoEquipo = "tablet"
    //  } else if (valorTipoEquipoMinuscula.includes('macbook')){
    //    TipoEquipo = "notebook"
    //  } else if (valorTipoEquipoMinuscula.includes('watch')){
    //    TipoEquipo = "reloj"
    //  }
    //
    //  console.log(TipoEquipo);
    //
    //  if (TipoEquipo === "iphone"){
    //    modeloTelefono.style.display = "block";
    //    modeloTablet.style.display = "none";
    //    modeloNotebook.style.display = "none";
    //    modeloReloj.style.display = "none";
    //
    //    colorTelefono.style.display = "block";
    //    colorTablet.style.display = "none";
    //    colorNotebook.style.display = "none";
    //    colorReloj.style.display = "none";
    //
    //    fallaTelefono.style.display = "block";
    //    fallaTablet.style.display = "none";
    //    fallaNotebook.style.display = "none";
    //    fallaReloj.style.display = "none";
    //  } else if (TipoEquipo === "tablet"){
    //    modeloTelefono.style.display = "none";
    //    modeloTablet.style.display = "block";
    //    modeloNotebook.style.display = "none";
    //    modeloReloj.style.display = "none";
    //
    //    colorTelefono.style.display = "none";
    //    colorTablet.style.display = "block";
    //    colorNotebook.style.display = "none";
    //    colorReloj.style.display = "none";
    //
    //    fallaTelefono.style.display = "none";
    //    fallaTablet.style.display = "block";
    //    fallaNotebook.style.display = "none";
    //    fallaReloj.style.display = "none";
    //  } else if (TipoEquipo === "notebook"){
    //    modeloTelefono.style.display = "none";
    //    modeloTablet.style.display = "none";
    //    modeloNotebook.style.display = "block";
    //    modeloReloj.style.display = "none";
    //
    //    colorTelefono.style.display = "none";
    //    colorTablet.style.display = "none";
    //    colorNotebook.style.display = "block";
    //    colorReloj.style.display = "none";
    //
    //    fallaTelefono.style.display = "none";
    //    fallaTablet.style.display = "none";
    //    fallaNotebook.style.display = "block";
    //    fallaReloj.style.display = "none";
    //  } else if (TipoEquipo === "reloj"){
    //    modeloTelefono.style.display = "none";
    //    modeloTablet.style.display = "none";
    //    modeloNotebook.style.display = "none";
    //    modeloReloj.style.display = "block";
    //
    //    colorTelefono.style.display = "none";
    //    colorTablet.style.display = "none";
    //    colorNotebook.style.display = "none";
    //    colorReloj.style.display = "block";
    //
    //    fallaTelefono.style.display = "none";
    //    fallaTablet.style.display = "none";
    //    fallaNotebook.style.display = "none";
    //    fallaReloj.style.display = "block";
    //  }
}

//function asd(id){
//  for (var i = 0; i < id.length; i++) {
//
//      var modalEditar = document.getElementById("editarEquipo" + id);
//
//      var modalValorTipo = document.getElementById("valorTipoEquipo" + id);
//
//      //var btnOpenEditar = document.getElementById("btnOpenEditar" + dataId);
//      console.log(id);
//}
//}

////////////////////////////////////// PANEL
//MAS DETALLES y EDITAR
var modalMasDetalles = document.getElementsByClassName("ModalDetalles");
var modalEditar = document.getElementsByClassName("ModalEditar");
var btnOpenEditar = document.getElementsByClassName("btnOpenEditar");
var btnMasDetalles = document.getElementsByClassName("btnOpenDetalles");
//AGREGAR
var modalAgregarEquipo = document.getElementById("agregarEquipo");
var btnAgregarEquipo = document.getElementById("btnAgregarEquipo");
//BUTTONS
var btnClose = document.getElementsByClassName("btnClose");
var btnOk = document.getElementsByClassName("btnOk");

//EDITAR USUARIO SUPERVISOR.PHP Y ADMINISTRADOR.PHP
var btnOpenEditarUsuario = document.getElementsByClassName(
    "btnOpenEditarUsuario"
);
var btnOpenEditarUsuarios = document.getElementsByClassName(
    "btnOpenEditarUsuarios"
);

//var EditarmodeloTelefono = document.getElementById("EDITARselectModeloTelefono");
//var EditarmodeloTablet = document.getElementById("EDITARselectModeloTablet");
//var EditarmodeloNotebook = document.getElementById("EDITARselectModeloNotebook");
//var EditarmodeloReloj = document.getElementById("EDITARselectModeloReloj");

//price edit
const precioEditar = document.getElementById("precioEditar");

// EDITAR
for (var i = 0; i < btnOpenEditar.length; i++) {
    btnOpenEditar[i].onclick = function () {
        var dataId = this.getAttribute("data-id");
        var modalEditar = document.getElementById("editarEquipo");

        if (modalEditar) {
            // Encontrar la fila correspondiente en la tabla
            var row = this.closest("tr");

            // Obtener los valores de los campos de la fila
            var datos = Array.from(row.querySelectorAll("td")).map(function (
                td
            ) {
                return td.textContent;
            });

            //Para testear
            //console.log(datos[11], datos[12]);

            //SELECT MODELO - FALLA - COLOR
            //MODELO
            var modeloTelefono = document.getElementById("modelo-telefono");
            var modeloTablet = document.getElementById("modelo-tablet");
            var modeloNotebook = document.getElementById("modelo-notebook");
            var modeloReloj = document.getElementById("modelo-reloj");
            var modeloValue;
            //FALLA
            var fallaTelefono = document.getElementById("falla-telefono");
            var fallaTablet = document.getElementById("falla-tablet");
            var fallaNotebook = document.getElementById("falla-notebook");
            var fallaReloj = document.getElementById("falla-reloj");
            var fallaValue;
            //COLOR
            var colorTelefono = document.getElementById("color-telefono");
            var colorTablet = document.getElementById("color-tablet");
            var colorNotebook = document.getElementById("color-notebook");
            var colorReloj = document.getElementById("color-reloj");
            var colorValue;

            //empresa o cliente
            var selectEditarEmpresa = document.getElementById("empresaEditar");
            var selectEditarCliente = document.getElementById("clienteEditar");
            var showClient = document.getElementById("showInputClient");
            var showEmpresa = document.getElementById("showSelectEmpresa");
            var nombreCliente;

            // Verificar si el valor de equipoEditar contiene "iPhone"
            if (datos[1].toLowerCase().includes("iphone")) {
                //Asigno modeloValue para darle valor al selecet correspondiente.
                modeloValue = document.getElementById("modeloEditar-telefono");
                fallaValue = document.getElementById("fallaEditar-telefono");
                colorValue = document.getElementById("colorEditar-telefono");

                if (modeloTelefono) {
                    modeloTelefono.style.display = "grid";
                    modeloTablet.style.display = "none";
                    modeloNotebook.style.display = "none";
                    modeloReloj.style.display = "none";
                }
                if (fallaTelefono) {
                    fallaTelefono.style.display = "grid";
                    fallaTablet.style.display = "none";
                    fallaNotebook.style.display = "none";
                    fallaReloj.style.display = "none";
                }
                if (colorTelefono) {
                    colorTelefono.style.display = "grid";
                    colorTablet.style.display = "none";
                    colorNotebook.style.display = "none";
                    colorReloj.style.display = "none";
                }
            } else if (datos[1].toLowerCase().includes("ipad")) {
                //Asigno modeloValue para darle valor al selecet correspondiente.
                modeloValue = document.getElementById("modeloEditar-tablet");
                fallaValue = document.getElementById("fallaEditar-tablet");
                colorValue = document.getElementById("colorEditar-tablet");

                if (modeloTablet) {
                    modeloTablet.style.display = "grid";
                    modeloTelefono.style.display = "none";
                    modeloNotebook.style.display = "none";
                    modeloReloj.style.display = "none";
                }
                if (fallaTablet) {
                    fallaTablet.style.display = "grid";
                    fallaTelefono.style.display = "none";
                    fallaNotebook.style.display = "none";
                    fallaReloj.style.display = "none";
                }
                if (colorTablet) {
                    colorTablet.style.display = "grid";
                    colorTelefono.style.display = "none";
                    colorNotebook.style.display = "none";
                    colorReloj.style.display = "none";
                }
            } else if (datos[1].toLowerCase().includes("macbook")) {
                //Asigno modeloValue para darle valor al selecet correspondiente.
                modeloValue = document.getElementById("modeloEditar-notebook");
                fallaValue = document.getElementById("fallaEditar-notebook");
                colorValue = document.getElementById("colorEditar-notebook");

                if (modeloNotebook) {
                    modeloNotebook.style.display = "grid";
                    modeloTelefono.style.display = "none";
                    modeloTablet.style.display = "none";
                    modeloReloj.style.display = "none";
                }
                if (fallaNotebook) {
                    fallaNotebook.style.display = "grid";
                    fallaTablet.style.display = "none";
                    fallaTelefono.style.display = "none";
                    fallaReloj.style.display = "none";
                }
                if (colorNotebook) {
                    colorNotebook.style.display = "grid";
                    colorTablet.style.display = "none";
                    colorTelefono.style.display = "none";
                    colorReloj.style.display = "none";
                }
            } else if (datos[1].toLowerCase().includes("watch")) {
                //Asigno modeloValue para darle valor al selecet correspondiente.
                modeloValue = document.getElementById("modeloEditar-reloj");
                fallaValue = document.getElementById("fallaEditar-reloj");
                colorValue = document.getElementById("colorEditar-reloj");

                if (modeloReloj) {
                    modeloReloj.style.display = "grid";
                    modeloTelefono.style.display = "none";
                    modeloTablet.style.display = "none";
                    modeloNotebook.style.display = "none";
                }
                if (fallaReloj) {
                    fallaReloj.style.display = "grid";
                    fallaTablet.style.display = "none";
                    fallaNotebook.style.display = "none";
                    fallaTelefono.style.display = "none";
                }
                if (colorReloj) {
                    colorReloj.style.display = "grid";
                    colorTablet.style.display = "none";
                    colorNotebook.style.display = "none";
                    colorTelefono.style.display = "none";
                }
            } else {
                modeloTelefono.style.display = "none";
                modeloTablet.style.display = "none";
                modeloNotebook.style.display = "none";
                modeloReloj.style.display = "none";

                fallaTelefono.style.display = "none";
                fallaTablet.style.display = "none";
                fallaNotebook.style.display = "none";
                fallaReloj.style.display = "none";

                colorTelefono.style.display = "none";
                colorTablet.style.display = "none";
                colorNotebook.style.display = "none";
                colorReloj.style.display = "none";
            }

            // Asignar el valor a la opción seleccionada en el elemento de selección
            if (modeloValue) {
                modeloValue.value = datos[1];
            }
            if (fallaValue) {
                fallaValue.value = datos[4];
            }
            if (colorValue) {
                colorValue.value = datos[7];
            }

            //empresa o cliente
            document
                .getElementById("clienteEditar")
                .addEventListener("change", function () {
                    document.getElementById("select_seleccionado").value =
                        "cliente";
                });

            document
                .getElementById("empresaEditar")
                .addEventListener("change", function () {
                    document.getElementById("select_seleccionado").value =
                        "empresa";
                });

            if (datos[3].includes("CLIENTE")) {
                var nombreCliente = datos[3];
                var matches = nombreCliente.match(/\(([^)]+)\)/);

                if (matches) {
                    var contenidoCliente = matches[1];
                }

                showClient.style.display = "grid";
                showEmpresa.style.display = "none";

                selectEditarCliente.value = contenidoCliente;
            } else {
                showEmpresa.style.display = "grid";
                showClient.style.display = "none";

                selectEditarEmpresa.value = datos[3];
            }

            //perifericos
            console.log(datos[6]);
            const perifericos = datos[6];

            // Divide el valor en una lista de valores individuales
            const perifericosArray = perifericos.split(", ");

            if (perifericos.toLowerCase() === "ok") {
                // Desmarcar todos los checkboxes
                const checkboxes = document.querySelectorAll(
                    'input[type="checkbox"]'
                );
                checkboxes.forEach((checkbox) => {
                    checkbox.checked = false;
                });
            }
            // else {
            //  const values = perifericos.match(/\((.*?)\)/);
            //  if (values && values[1]) {
            //      const checkboxValues = values[1].split(', ');
            //
            //      // Marcar los checkboxes correspondientes a los valores
            //      checkboxValues.forEach((value) => {
            //          setCheckboxState(value.toLowerCase(), true);
            //      });
            //  }
            //}

            function setCheckboxState(value, checked) {
                // Encuentra todos los checkboxes con el valor deseado
                const checkboxes = document.querySelectorAll(
                    `input[type="checkbox"][value="${value}"]`
                );

                // Establece el estado de los checkboxes
                checkboxes.forEach((checkbox) => {
                    checkbox.checked = checked;
                });
            }

            // Marcar los checkboxes correspondientes a los valores en perifericosArray
            perifericosArray.forEach((value) => {
                setCheckboxState(value.trim(), true);
            });

            // Asignar los valores a los campos del modal de edición
            document.getElementById("idEditar").value = dataId;
            document.getElementById("fechaEditar").value = datos[0];
            //document.getElementById("equipoEditar").value = datos[1];
            document.getElementById("imeiEditar").value = datos[2];
            //document.getElementById("empresaEditar").value = datos[3];
            //document.getElementById("fallaEditar").value = datos[4];
            document.getElementById("detallesEditar").value = datos[5];
            //document.getElementById("colorEditar").value = datos[6];
            document.getElementById("solucionEditar").value = datos[8];
            document.getElementById("repuestoUtilizadoEditar").value = datos[9];
            document.getElementById("claveEditar").value = datos[10];
            document.getElementById("precioEditar").value = datos[11];
            document.querySelector(
                "input[name='terminadoEditar'][value='" + datos[12] + "']"
            ).checked = true;
            document.querySelector(
                "input[name='paraEntregarEditar'][value='" + datos[13] + "']"
            ).checked = true;

            // Mostrar el modal de edición
            modalEditar.style.display = "block";
            formatPrice(precioEditar);
        }
    };
}

// MAS DETALLES
for (var i = 0; i < btnMasDetalles.length; i++) {
    btnMasDetalles[i].onclick = function () {
        var dataId = this.getAttribute("data-id");
        var modalMasDetalles = document.getElementById("masDetalles");

        var esEmpresa;

        if (modalMasDetalles) {
            // Encontrar la fila correspondiente en la tabla
            var row = this.closest("tr");

            // Obtener los valores de los campos de la fila
            var datos = Array.from(row.querySelectorAll("td")).map(function (
                td
            ) {
                return td.textContent;
            });

            //Datos del equipo seleccionado
            document.getElementById("name_equipo").textContent = datos[1];

            var spanCliente = document.getElementById("name_cliente");
            var spanEmpresa = document.getElementById("name_empresa");
            esEmpresa = datos[3];

            if (esEmpresa.toLowerCase().includes("cliente")) {
                spanCliente.style.display = "inline-flex";
                spanEmpresa.style.display = "none";
                spanCliente.textContent = datos[3];
            } else {
                spanEmpresa.style.display = "inline-flex";
                spanCliente.style.display = "none";
                spanEmpresa.textContent = datos[3];
            }

            // Asignar los valores a los campos del modal de edición
            document.getElementById("idMasDetalles").value = dataId;
            //document.getElementById("fechaEditar").value = datos[0];
            //document.getElementById("equipoEditar").value = datos[1];
            //document.getElementById("imeiEditar").value = datos[2];
            //document.getElementById("empresaEditar").value = datos[3];
            //document.getElementById("fallaEditar").value = datos[4];
            document.getElementById("valorDetalles").textContent = datos[5];
            document.getElementById("valorPeriferico").textContent = datos[6];
            document.getElementById("valorColor").textContent = datos[7];
            document.getElementById("valorSolucion").textContent = datos[8];
            document.getElementById("valorRepuesto").textContent = datos[9];
            //document.getElementById("claveEditar").value = datos[10];
            document.getElementById("valorPrecio").textContent = datos[11];
            document.getElementById("valorTerminado").textContent = datos[12];
            //document.querySelector("input[name='terminadoEditar'][value='" + datos[13] + "']").checked = true;
            //document.querySelector("input[name='paraEntregarEditar'][value='" + datos[14] + "']").checked = true;

            // Mostrar el modal de edición
            modalMasDetalles.style.display = "block";
        }
    };
}

//EDITAR USUARIO
//SUPERVISOR.PHP
for (var i = 0; i < btnOpenEditarUsuario.length; i++) {
    btnOpenEditarUsuario[i].onclick = function () {
        var dataId = this.getAttribute("data-id");
        var modalEditarUsuario = document.getElementById("editarUser");

        if (modalEditarUsuario) {
            // Encontrar la fila correspondiente en la tabla
            var row = this.closest("tr");

            // Obtener los valores de los campos de la fila
            var datos = Array.from(row.querySelectorAll("td")).map(function (
                td
            ) {
                return td.textContent;
            });

            // Asignar los valores a los campos del modal de edición
            document.getElementById("idEditarUsuario").value = dataId;
            document.getElementById("nombreEditarUsuario").value = datos[0];
            document.getElementById("mailEditarUsuario").value = datos[1];

            // Mostrar el modal de edición
            modalEditarUsuario.style.display = "block";
        }
    };
}

//nuevo editar
// EDITAR EMPRESA
document.addEventListener("DOMContentLoaded", function () {
    //const btnEditarList = document.querySelectorAll(".btnEditar");

    // Obtener el valor almacenado en localStorage para la empresa seleccionada
    //let storedUserId = localStorage.getItem("currentUserId");

    // Obtener el elemento select
    //const selectEmpresa = document.getElementById("selectEmpresa");
    //console.log(selectEmpresa.value);

    // Verificar si hay un valor almacenado en localStorage
    //const selectedEmpresa = localStorage.getItem("selectedEmpresa");

    const popupEditarUser = document.getElementById("editarUser");

    const btnGuardarCambiosUser = document.querySelector(
        "#btnGuardarCambiosUsuarios"
    );
    btnGuardarCambiosUser.addEventListener("click", function (event) {
        event.preventDefault();
        // Obtener los valores del formulario de edición
        const idEditarUsuario =
            document.getElementById("idEditarUsuario").value;
        const nombreEditarUsuario = document.getElementById(
            "nombreEditarUsuario"
        ).value;
        const mailEditarUsuario =
            document.getElementById("mailEditarUsuario").value;

        // Validar que los campos no estén vacíos
        if (nombreEditarUsuario !== "" && mailEditarUsuario !== "") {
            // Crear un objeto con los datos que deseas enviar al archivo PHP

            id = idEditarUsuario;
            var storedUserId = localStorage.getItem("currentUserId");
            console.log("currentUserId2:", storedUserId);

            var data = {
                idEditarUsuario: idEditarUsuario,
                nombreEditarUsuario: nombreEditarUsuario,
                mailEditarUsuario: mailEditarUsuario,
            };

            // Enviar los datos al servidor mediante Fetch API
            fetch("php/usuario_editar.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data),
            })
                .then((response) => response.json())
                .then((result) => {
                    // Manejar la respuesta del servidor y actualizar el DOM

                    //console.log('Respuesta del servidor:', result);

                    if (result.success) {
                        //console.log(idEditarUsuario, nombreEditarUsuario, mailEditarUsuario);
                        //console.log("currentUserId:", storedUserId);

                        localStorage.setItem("currentUserId", idEditarUsuario);

                        var btnEditarUsuario = document.querySelector(
                            "button[data-id='" + id + "']"
                        );

                        // Encuentra la fila (<tr>) que contiene el botón
                        var row = btnEditarUsuario.closest("tr");

                        // Busca las celdas de nombre y email dentro de la fila
                        var nombreCell = row.querySelector("td:nth-child(1)"); // Selecciona la primera columna (Nombre)
                        var emailCell = row.querySelector("td:nth-child(2)"); // Selecciona la segunda columna (Email)
                        // Aquí puedes editar el contenido de las celdas 'nombreCell' y 'emailCell'
                        // Por ejemplo:
                        //nombreCell.innerHTML = "<input type='text' value='" + nombreCell.textContent + "'>";
                        //emailCell.innerHTML = "<input type='text' value='" + emailCell.textContent + "'>";

                        nombreCell.innerHTML = nombreEditarUsuario;
                        emailCell.innerHTML = mailEditarUsuario;

                        const popupEditarUser =
                            document.getElementById("editarUser");
                        popupEditarUser.style.display = "none";
                        //let storedUserId = localStorage.getItem("currentUserId");

                        //nombreEditarUsuario
                        //mailEditarUsuario

                        // Actualiza los elementos de la tabla con los nuevos valores
                        //  const tablaUsuarios = document.getElementById("tablaUsuarios");
                        //  const tbody = tablaUsuarios.querySelector("tbody");
                        //
                        //  // Busca la fila correspondiente y actualiza los valores
                        //  const rows = tbody.querySelectorAll("tr");
                        //  for (let i = 0; i < rows.length; i++) {
                        //      const idUsuario = rows[i].getAttribute("data-id"); // Asegúrate de tener un atributo data-id en la fila
                        //
                        //      console.log (nombreEditarUsuario, mailEditarUsuario)
                        //
                        //      if (idUsuario === idEditarUsuario) {
                        //          rows[i].querySelector("td:nth-child(1)").textContent = nombreEditarUsuario;
                        //          rows[i].querySelector("td:nth-child(2)").textContent = mailEditarUsuario;
                        //          // Actualiza otras celdas según sea necesario
                        //          break; // Detén el bucle una vez que encuentres la fila correspondiente
                        //      }
                        //  }
                        // Los cambios se guardaron con éxito
                        //alert("Cambios guardados correctamente.");

                        // Actualiza el valor en el localStorage
                        //localStorage.setItem("selectedEmpresa", result.nuevosValores.nombre);
                        // Ocultar el formulario de edición

                        //
                        //  // Actualizar los elementos <span> con los nuevos valores
                        //  const empresaNombreElement = document.querySelector(`li.slide[data-empresa="${storedCompanyId}"] h1[data-info='nombre']`);
                        //  const empresaUbicacionElement = document.querySelector(`li.slide[data-empresa="${storedCompanyId}"] span[data-info='ubicacion']`);
                        //  const empresaTelefonoElement = document.querySelector(`li.slide[data-empresa="${storedCompanyId}"] span[data-info='telefono']`);
                        //  const empresaPaginaElement = document.querySelector(`li.slide[data-empresa="${storedCompanyId}"] span[data-info='pagina']`);
                        //
                        //  //lo hago directo del js
                        //  empresaNombreElement.textContent = nombreEditarEmpresa;
                        //  empresaUbicacionElement.textContent = ubicacionEditarEmpresa;
                        //  empresaTelefonoElement.textContent = telefonoEditarEmpresa;
                        //  empresaPaginaElement.textContent = paginaEditarEmpresa;
                        //
                        //  //va y vuelve al php ALPEDO
                        //  //empresaNombreElement.textContent = result.nuevosValores.nombre;
                        //  //empresaUbicacionElement.textContent = result.nuevosValores.ubicacion;
                        //  //empresaTelefonoElement.textContent = result.nuevosValores.telefono;
                        //  //empresaPaginaElement.textContent = result.nuevosValores.pagina;
                        //
                        //
                        //  // Actualizar el select con las opciones actualizadas desde el servidor
                        //  const selectEmpresa = document.getElementById("selectEmpresa");
                        //  selectEmpresa.innerHTML = ""; // Limpiar el select actual
                        //
                        //  result.empresasOptions.forEach(function (empresaOption) {
                        //      const option = document.createElement("option");
                        //      option.text = empresaOption;
                        //      option.value = empresaOption;
                        //      selectEmpresa.appendChild(option);
                        //  });
                        //
                        //  // Establecer el nuevo valor seleccionado si es necesario
                        //  selectEmpresa.value = result.nuevosValores.nombre;
                        //
                        //  // Guardar variables para que siempre esten aunque se haga f5.
                        //  nombreEmpresa = selectEmpresa.value;
                        //  localStorage.setItem("currentCompanyId", nombreEmpresa);
                        //  localStorage.setItem("selectedEmpresa", nombreEmpresa);
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

//nuevo editar

//ADMINISTRADOR.PHP
for (var i = 0; i < btnOpenEditarUsuarios.length; i++) {
    btnOpenEditarUsuarios[i].onclick = function () {
        var dataId = this.getAttribute("data-id");
        var modalEditarUsuario = document.getElementById("editarUsers");

        if (modalEditarUsuario) {
            // Encontrar la fila correspondiente en la tabla
            var row = this.closest("tr");

            // Obtener los valores de los campos de la fila
            var datos = Array.from(row.querySelectorAll("td")).map(function (
                td
            ) {
                return td.textContent;
            });

            // Asignar los valores a los campos del modal de edición
            document.getElementById("idEditarUsuarios").value = dataId;
            document.getElementById("nombreEditarUsuarios").value = datos[0];
            document.getElementById("mailEditarUsuarios").value = datos[1];

            // Obtener el primer valor de datos[3] y asignarlo al campo de contraseña
            var passwordValues = datos[3].trim().split(" ");
            var passwordValue = passwordValues[0];
            document.getElementById("passwordEditarUsuarios").value =
                passwordValue;

            // Seleccionar automáticamente el rol correcto
            var rolSeleccionado = datos[4].trim(); // Limpiar espacios en blanco
            var selectEditarRolUsuario = document.getElementById(
                "selectEditarRolUsuario"
            );
            for (var j = 0; j < selectEditarRolUsuario.options.length; j++) {
                if (
                    selectEditarRolUsuario.options[j].value === rolSeleccionado
                ) {
                    selectEditarRolUsuario.options[j].selected = true;
                    break;
                }
            }

            // Mostrar el modal de edición
            modalEditarUsuario.style.display = "block";
        }
    };
}

//CLOSE ALL
for (var i = 0; i < btnClose.length; i++) {
    btnClose[i].onclick = function () {
        modalAgregarEquipo.style.display = "none";

        //PANEL
        for (var j = 0; j < modalEditar.length; j++) {
            modalEditar[j].style.display = "none";

            //el reset hace que se vuelvan los valores al estado inicial
            document.getElementById("formEditar").reset();
        }
        for (var k = 0; k < modalMasDetalles.length; k++) {
            modalMasDetalles[k].style.display = "none";
        }
    };
}

//CLOSE DETALLES OK
for (var i = 0; i < btnOk.length; i++) {
    btnOk[i].onclick = function () {
        for (var l = 0; l < modalMasDetalles.length; l++) {
            modalMasDetalles[l].style.display = "none";
        }
    };
}

window.onclick = function (event) {
    //for (var j = 0; j < modalEditar.length; j++) {
    //      if (event.target === modalEditar[j]) {
    //        modalEditar[j].style.display = "none";
    //        document.getElementById("formEditar").reset();
    //      }
    //  }
    for (var k = 0; k < modalMasDetalles.length; k++) {
        if (event.target === modalMasDetalles[k]) {
            modalMasDetalles[k].style.display = "none";
        }
    }

    //Close Agregar nueva empresa
    if (event.target === agregarEmpresa) {
        agregarEmpresa.style.display = "none";

        inputs.forEach((input) => (input.value = ""));

        clearError();
        clearErrorInformacion();
    }
    //Close Agregar nuevo usuario
    if (event.target === agregarUsuario) {
        agregarUsuario.style.display = "none";

        //Limpio todo menos mi input nombre empresa
        inputs.forEach((input) => {
            if (input !== nombreEmpresa) {
                input.value = "";
            }
        });

        clearError();
        clearErrorInformacion();
    }

    if (event.target == modalAgregarEquipo) {
        modalAgregarEquipo.style.display = "none";

        selects.forEach((select) => (select.selectedIndex = 0));
        inputs.forEach((input) => (input.value = ""));

        resetSelectedClientContainer.style.display = "none";
        resetSelectedClient.textContent = "";
        resetInputclient.focus();
        clientSelected = "";

        document.getElementById("fechaAutomaticaEmpresa").valueAsDate =
            new Date();

        fallaSeleccionada = "";

        borrarSelecciones();

        clearError();
        clearErrorNewClient();
        clearErrorModeloColor();
        clearErrorInformacion();
    }
};

// EDITAR EMPRESA
document.addEventListener("DOMContentLoaded", function () {
    const btnEditarList = document.querySelectorAll(".btnEditar");

    // Obtener el valor almacenado en localStorage para la empresa seleccionada
    let storedCompanyId = localStorage.getItem("currentCompanyId");

    // Obtener el elemento select
    const selectEmpresa = document.getElementById("selectEmpresa");
    //console.log(selectEmpresa.value);

    // Verificar si hay un valor almacenado en localStorage
    const selectedEmpresa = localStorage.getItem("selectedEmpresa");

    //h1 con el valor de la emrpesa previa
    //const empresaName = document.getElementById("empresaName");
    //currentEmpresaName = localStorage.getItem("empresaName");
    //empresaName.textContent = currentEmpresaName;

    if (selectedEmpresa) {
        // Selecciona automáticamente la opción correspondiente en el select
        selectEmpresa.value = selectedEmpresa;
    }

    // Agregar un evento change al select
    selectEmpresa.addEventListener("change", function () {
        // Obtener el valor seleccionado en el select
        const selectedCompany = selectEmpresa.value;
        // Guardar el valor seleccionado en localStorage
        localStorage.setItem("currentCompanyId", selectedCompany);
        storedCompanyId = selectedCompany;

        //con esto al dar f5 siempre queda el value de mi select, el que estaba.
        //sin esto, queda sin ningun value mi select
        localStorage.setItem("selectedEmpresa", selectedCompany);
        selectedEmpresa = selectedCompany;
    });

    btnEditarList.forEach(function (btnEditar) {
        btnEditar.addEventListener("click", function () {
            // Obtener los valores de la empresa desde los atributos de datos
            const empresaId = btnEditar.getAttribute("data-id");
            //const companyName = btnEditar.getAttribute("data-empresa");

            // Guardar el valor seleccionado en localStorage
            //localStorage.setItem("currentCompanyId", empresaId);
            //localStorage.setItem("currentCompanyId", empresaId);

            const empresaNombreElement = btnEditar.parentElement.querySelector(
                "h1[data-info='nombre']"
            );
            const empresaUbicacionElement =
                btnEditar.parentElement.querySelector(
                    "span[data-info='ubicacion']"
                );
            const empresaTelefonoElement =
                btnEditar.parentElement.querySelector(
                    "span[data-info='telefono']"
                );
            const empresaPaginaElement = btnEditar.parentElement.querySelector(
                "span[data-info='pagina']"
            );

            const empresaNombre = empresaNombreElement
                ? empresaNombreElement.textContent
                : "";
            const empresaUbicacion = empresaUbicacionElement
                ? empresaUbicacionElement.textContent
                : "";
            const empresaTelefono = empresaTelefonoElement
                ? empresaTelefonoElement.textContent
                : "";
            const empresaPagina = empresaPaginaElement
                ? empresaPaginaElement.textContent
                : "";

            // Asignar los valores a los campos del formulario de edición
            document.getElementById("idEditarEmpresa").value = empresaId;
            document.getElementById("nombreEditarEmpresa").value =
                empresaNombre;
            document.getElementById("ubicacionEditarEmpresa").value =
                empresaUbicacion;
            document.getElementById("telefonoEditarEmpresa").value =
                empresaTelefono;
            document.getElementById("paginaEditarEmpresa").value =
                empresaPagina;

            // Mostrar el formulario de edición
            const popupEditar = document.getElementById("editarEmpresa");
            popupEditar.style.display = "block";
        });
    });

    // Verificar si hay un ID guardado y mostrar el div correspondiente
    if (storedCompanyId) {
        const divToShow = document.querySelector(
            `li.slide[data-empresa="${storedCompanyId}"]`
        );
        if (divToShow) {
            divToShow.style.display = "block"; // Muestra el div correspondiente
        }
    }

    //if (selectedEmpresa){
    //  selectEmpresa.value = selectedEmpresa;
    //}

    // Agregar un evento al botón "Guardar Cambios" fuera del bucle anterior
    const btnGuardarCambios = document.querySelector("#btnGuardarCambios");
    btnGuardarCambios.addEventListener("click", function (event) {
        event.preventDefault();
        // Obtener los valores del formulario de edición
        const idEditarEmpresa =
            document.getElementById("idEditarEmpresa").value;
        const nombreEditarEmpresa = document.getElementById(
            "nombreEditarEmpresa"
        ).value;
        const ubicacionEditarEmpresa = document.getElementById(
            "ubicacionEditarEmpresa"
        ).value;
        const telefonoEditarEmpresa = document.getElementById(
            "telefonoEditarEmpresa"
        ).value;
        const paginaEditarEmpresa = document.getElementById(
            "paginaEditarEmpresa"
        ).value;

        localStorage.setItem("nombreEditarEmpresa", nombreEditarEmpresa);

        // Validar que los campos no estén vacíos
        if (
            nombreEditarEmpresa !== "" &&
            ubicacionEditarEmpresa !== "" &&
            telefonoEditarEmpresa !== "" &&
            paginaEditarEmpresa !== ""
        ) {
            // Crear un objeto con los datos que deseas enviar al archivo PHP
            var data = {
                idEditarEmpresa: idEditarEmpresa, // Usar el ID guardado previamente
                nombreEditarEmpresa: nombreEditarEmpresa,
                ubicacionEditarEmpresa: ubicacionEditarEmpresa,
                telefonoEditarEmpresa: telefonoEditarEmpresa,
                paginaEditarEmpresa: paginaEditarEmpresa,
            };

            // Enviar los datos al servidor mediante Fetch API
            fetch("php/empresa_editar.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data),
            })
                .then((response) => response.json())
                .then((result) => {
                    // Manejar la respuesta del servidor y actualizar el DOM
                    if (result.success) {
                        // Los cambios se guardaron con éxito
                        //alert("Cambios guardados correctamente.");

                        // Actualiza el valor en el localStorage
                        //localStorage.setItem("selectedEmpresa", result.nuevosValores.nombre);
                        // Ocultar el formulario de edición
                        const popupEditar =
                            document.getElementById("editarEmpresa");
                        popupEditar.style.display = "none";

                        // Actualizar los elementos <span> con los nuevos valores
                        const empresaNombreElement = document.querySelector(
                            `li.slide[data-empresa="${storedCompanyId}"] h1[data-info='nombre']`
                        );
                        const empresaUbicacionElement = document.querySelector(
                            `li.slide[data-empresa="${storedCompanyId}"] span[data-info='ubicacion']`
                        );
                        const empresaTelefonoElement = document.querySelector(
                            `li.slide[data-empresa="${storedCompanyId}"] span[data-info='telefono']`
                        );
                        const empresaPaginaElement = document.querySelector(
                            `li.slide[data-empresa="${storedCompanyId}"] span[data-info='pagina']`
                        );

                        //lo hago directo del js
                        empresaNombreElement.textContent = nombreEditarEmpresa;
                        empresaUbicacionElement.textContent =
                            ubicacionEditarEmpresa;
                        empresaTelefonoElement.textContent =
                            telefonoEditarEmpresa;
                        empresaPaginaElement.textContent = paginaEditarEmpresa;

                        //va y vuelve al php ALPEDO
                        //empresaNombreElement.textContent = result.nuevosValores.nombre;
                        //empresaUbicacionElement.textContent = result.nuevosValores.ubicacion;
                        //empresaTelefonoElement.textContent = result.nuevosValores.telefono;
                        //empresaPaginaElement.textContent = result.nuevosValores.pagina;

                        //const empresaName = document.getElementById("empresaName");
                        //localStorage.setItem("empresaName", empresaName);
                        //empresaName.textContent = nombreEditarEmpresa;

                        // Actualizar el select con las opciones actualizadas desde el servidor
                        const selectEmpresa =
                            document.getElementById("selectEmpresa");
                        selectEmpresa.innerHTML = ""; // Limpiar el select actual

                        result.empresasOptions.forEach(function (
                            empresaOption
                        ) {
                            const option = document.createElement("option");
                            option.text = empresaOption;
                            option.value = empresaOption;
                            selectEmpresa.appendChild(option);
                        });

                        // Establecer el nuevo valor seleccionado si es necesario
                        selectEmpresa.value = result.nuevosValores.nombre;

                        //h1 title empresa usuarios
                        const titleEmpresa =
                            document.getElementById("empresaName");
                        titleEmpresa.textContent = nombreEditarEmpresa;

                        // Guardar variables para que siempre esten aunque se haga f5.
                        nombreEmpresa = selectEmpresa.value;
                        localStorage.setItem("currentCompanyId", nombreEmpresa);
                        localStorage.setItem("selectedEmpresa", nombreEmpresa);
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

////////////////////////////////////////////////////////////////
//AgregarEquipo funcionalidad del #1, #2, #3, #4, #5

//RESET SELECT INPUT ON CLICK CLOSE BUTTON
let btnReset = document.getElementById("closeAgregarEquipo");

let selects = document.querySelectorAll("select");
let inputs = document.querySelectorAll("input");

let resetSelectedClientContainer = document.getElementById(
    "selectedClientContainer"
);
let resetSelectedClient = document.getElementById("selectedClient");
let resetInputclient = document.getElementById("searchClient");

//BTN CLOSE
btnReset.addEventListener("click", () => {
    selects.forEach((select) => (select.selectedIndex = 0));
    inputs.forEach((input) => (input.value = ""));

    resetSelectedClientContainer.style.display = "none";
    resetSelectedClient.textContent = "";
    resetInputclient.focus();
    clientSelected = "";

    document.getElementById("fechaAutomaticaEmpresa").valueAsDate = new Date();

    fallaSeleccionada = "";

    clearError();
    clearErrorNewClient();
    clearErrorModeloColor();
    clearErrorInformacion();
});

//SCROLL PERSONALIZADO

// VARIABLE PARA AGREGAR EQUIPO, SI NO ESTA ACA NO FUNCIONA
const seleccionesUsuario = [];
let clientSelected = "";
var seleccionUsuario = "";
let modeloSeleccionado = "";
let colorSeleccionado = "";
let fallaSeleccionada = "";
let clienteExistenteSeleccionado = "";
let clienteNuevoSeleccionado = "";
var clienteNombre;
var clienteApellido;
var clienteTelefono;

// SEARCH CLIENT
document.getElementById("searchClient").addEventListener("keyup", getClients);

// Agregar evento de clic en el documento
document.addEventListener("click", function (event) {
    let inputClient = document.getElementById("searchClient");
    let listaClient = document.getElementById("listaClient");

    // Verificar si el clic ocurrió fuera del input y la lista
    if (
        !inputClient.contains(event.target) &&
        !listaClient.contains(event.target)
    ) {
        listaClient.style.display = "none";
    }
});

function getClients() {
    let inputClient = document.getElementById("searchClient").value;
    let listaClient = document.getElementById("listaClient");

    //SIN ESTO... EL MSG ERROR APARECE SIEEMPRE
    //if (inputClient.value != ""){
    //  clearError();
    //}

    let url = "php/cliente_buscar.php";
    let formData = new FormData();
    formData.append("searchClient", inputClient);

    fetch(url, {
        method: "POST",
        body: formData,
        mode: "cors", //por seguridad
    })
        .then((response) => response.json()) //traemos un json para poderlo procesar
        .then((data) => {
            listaClient.style.display = "grid";
            listaClient.innerHTML = data;
        })
        .catch((err) => console.log(err)); //nos muestro los errores de esto
}

document
    .getElementById("listaClient")
    .addEventListener("click", function (event) {
        if (event.target.tagName === "LI") {
            let selectedClientContainer = document.getElementById(
                "selectedClientContainer"
            );
            let selectedClient = document.getElementById("selectedClient");
            let inputClient = document.getElementById("searchClient");
            let listaClient = document.getElementById("listaClient");

            clientSelected = event.target.textContent; //guardo en esta variable el cliente
            selectedClient.textContent = event.target.textContent;
            selectedClientContainer.style.display = "flex";
            listaClient.style.display = "none";
            inputClient.value = "";
        }
    });

document
    .getElementById("clearSelection")
    .addEventListener("click", function () {
        let selectedClientContainer = document.getElementById(
            "selectedClientContainer"
        );
        let selectedClient = document.getElementById("selectedClient");
        let inputClient = document.getElementById("searchClient");

        selectedClientContainer.style.display = "none";
        selectedClient.textContent = "";
        inputClient.focus();
        clientSelected = "";
    });

// FIN SEARCH CLIENT

// Con esto pongo la fecha automatica
document.getElementById("fechaAutomaticaEmpresa").valueAsDate = new Date();
//document.getElementById('fechaAutomaticaCliente').valueAsDate = new Date();

// Variable para almacenar las selecciones del usuario

//const modeloSeleccionado = '';
//const colorSeleccionado = '';
// Función para mostrar el mensaje de error segun corresponda.
function showError(errorElement, errorMessage) {
    document.querySelector("." + errorElement).classList.add("display_error");
    document.querySelector("." + errorElement).innerHTML = errorMessage;
}

//LIMPIAR ERRORES INICIO
//client
var errorClientExistente = document.getElementById("searchClient");
const errorClientNombre = document.getElementById("inputNombre");
const errorClientApellido = document.getElementById("inputApellido");
const errorClientTelefono = document.getElementById("inputTelefono");

errorClientExistente.addEventListener("input", clearError);
errorClientNombre.addEventListener("input", clearErrorNewClient);
errorClientApellido.addEventListener("input", clearErrorNewClient);
errorClientTelefono.addEventListener("input", clearErrorNewClient);

//modelo color
var errorModeloTelefono = document.getElementById("selectModeloTelefono");
var errorModeloTablet = document.getElementById("selectModeloTablet");
var errorModeloNotebook = document.getElementById("selectModeloNotebook");
var errorModeloReloj = document.getElementById("selectModeloReloj");
var errorColorTelefono = document.getElementById("selectColorTelefono");
var errorColorTablet = document.getElementById("selectColorTablet");
var errorColorNotebook = document.getElementById("selectColorNotebook");
var errorColorReloj = document.getElementById("selectColorReloj");

errorModeloTelefono.addEventListener("input", clearErrorModeloColor);
errorModeloTablet.addEventListener("input", clearErrorModeloColor);
errorModeloNotebook.addEventListener("input", clearErrorModeloColor);
errorModeloReloj.addEventListener("input", clearErrorModeloColor);
errorColorTelefono.addEventListener("input", clearErrorModeloColor);
errorColorTablet.addEventListener("input", clearErrorModeloColor);
errorColorNotebook.addEventListener("input", clearErrorModeloColor);
errorColorReloj.addEventListener("input", clearErrorModeloColor);

//informacion adicional
var errorInfoFecha = document.getElementById("fechaAutomaticaEmpresa");
var errorInfoImei = document.getElementById("InputImei");
var errorFallaTelefono = document.getElementById("selectFallaTelefono");
var errorFallaTablet = document.getElementById("selectFallaTablet");
var errorFallaNotebook = document.getElementById("selectFallaNotebook");
var errorFallaReloj = document.getElementById("selectFallaReloj");
var errorInfoEmpresa = document.getElementById("selectInputEmpresa");
var errorInfoInputEmpresa = document.getElementById("InputEmpresa");
var errorInfoDetalles = document.getElementById("InputDetalles");
var errorInfoClave = document.getElementById("InputClave");
var errorInfoPrecio = document.getElementById("InputPrecio");

errorInfoFecha.addEventListener("input", clearErrorInformacion);
errorInfoImei.addEventListener("input", clearErrorInformacion);
errorInfoEmpresa.addEventListener("input", clearErrorInformacion);
errorInfoInputEmpresa.addEventListener("input", clearErrorInformacion);
errorFallaTelefono.addEventListener("input", clearErrorInformacion);
errorFallaTablet.addEventListener("input", clearErrorInformacion);
errorFallaNotebook.addEventListener("input", clearErrorInformacion);
errorFallaReloj.addEventListener("input", clearErrorInformacion);
errorInfoDetalles.addEventListener("input", clearErrorInformacion);
errorInfoClave.addEventListener("input", clearErrorInformacion);
errorInfoPrecio.addEventListener("input", clearErrorInformacion);

//EMPRESA
var errorNombreEmpresa = document.getElementById("InputNombreEmpresa");
var errorMailEmpresa = document.getElementById("InputMailEmpresa");
var errorUbicacionEmpresa = document.getElementById("InputUbicacionEmpresa");
var errorTelefonoEmpresa = document.getElementById("InputTelefonoEmpresa");
var errorPaginaEmpresa = document.getElementById("InputPaginaEmpresa");

errorNombreEmpresa.addEventListener("input", clearErrorInformacion);
errorMailEmpresa.addEventListener("input", clearErrorInformacion);
errorUbicacionEmpresa.addEventListener("input", clearErrorInformacion);
errorTelefonoEmpresa.addEventListener("input", clearErrorInformacion);
errorPaginaEmpresa.addEventListener("input", clearErrorInformacion);

//EMPRESA USUARIOS
var errorNombreUsuario = document.getElementById("InputNombreUsuario");
var errorMailUsuario = document.getElementById("InputMailUsuario");
var errorPasswordUsuario = document.getElementById("InputPasswordUsuario");

errorNombreUsuario.addEventListener("input", clearErrorInformacion);
errorMailUsuario.addEventListener("input", clearErrorInformacion);
errorPasswordUsuario.addEventListener("input", clearErrorInformacion);

//ADMINISTRADOR PHP
var errorAgregarUsuario = document.getElementById("InputAgregarNombre");
var errorAgregarMail = document.getElementById("InputAgregarMail");
var errorAgregarPassword = document.getElementById("InputAgregarPassword");
var errorRolUsuario = document.getElementById("selectRolUsuario");

errorAgregarUsuario.addEventListener("input", clearErrorInformacion);
errorAgregarMail.addEventListener("input", clearErrorInformacion);
errorAgregarPassword.addEventListener("input", clearErrorInformacion);
errorRolUsuario.addEventListener("input", clearErrorInformacion);

//funciones
function clearError() {
    let errors = document.querySelectorAll(".error");
    for (let error of errors) {
        error.classList.remove("display_error");
    }
}

function clearErrorNewClient() {
    let errorNombre = document.querySelectorAll(".nuevoNombre_error");
    let errorApellido = document.querySelectorAll(".nuevoApellido_error");
    let errorTelefono = document.querySelectorAll(".nuevoTelefono_error");

    // Recorre los elementos de error específicos y elimina la clase "display_error" si el input correspondiente tiene contenido
    errorNombre.forEach((error) => {
        if (errorClientNombre.value.trim() !== "") {
            error.classList.remove("display_error");
        }
    });

    errorApellido.forEach((error) => {
        if (errorClientApellido.value.trim() !== "") {
            error.classList.remove("display_error");
        }
    });

    errorTelefono.forEach((error) => {
        if (errorClientTelefono.value.trim() !== "") {
            error.classList.remove("display_error");
        }
    });
}

function clearErrorModeloColor() {
    let errorModelo = document.querySelectorAll(".modeloEquipo_error");
    let errorColor = document.querySelectorAll(".modeloColor_error");

    // Recorre los elementos de error específicos y elimina la clase "display_error" si el input correspondiente tiene contenido
    errorModelo.forEach((error) => {
        if (
            errorModeloTelefono.value.trim() !== "" ||
            errorModeloTablet.value.trim() !== "" ||
            errorModeloNotebook.value.trim() !== "" ||
            errorModeloReloj.value.trim() !== ""
        ) {
            error.classList.remove("display_error");
        }
    });

    errorColor.forEach((error) => {
        if (
            errorColorTelefono.value.trim() !== "" ||
            errorColorTablet.value.trim() !== "" ||
            errorColorNotebook.value.trim() !== "" ||
            errorColorReloj.value.trim() !== ""
        ) {
            error.classList.remove("display_error");
        }
    });
}

function clearErrorInformacion() {
    let errorFecha = document.querySelectorAll(".fechaAutomatica_error");
    let errorImei = document.querySelectorAll(".imei_error");
    let errorEmpresa = document.querySelectorAll(".empresa_error");
    let errorfalla = document.querySelectorAll(".falla_error");
    let errorDetalles = document.querySelectorAll(".detalles_error");
    let errorClave = document.querySelectorAll(".clave_error");
    let errorPrecio = document.querySelectorAll(".precio_error");

    //EMPRESA
    let errorNombre = document.querySelectorAll(".nombre_error");
    let errorMail = document.querySelectorAll(".mail_error");
    let errorUbicacion = document.querySelectorAll(".ubicacion_error");
    let errorTelefono = document.querySelectorAll(".telefono_error");
    let errorPagina = document.querySelectorAll(".pagina_error");
    //USUARIOS
    let errorNombreU = document.querySelectorAll(".Unombre_error");
    let errorMailU = document.querySelectorAll(".Umail_error");
    let errorPasswordU = document.querySelectorAll(".Upassword_error");
    let errorRolA = document.querySelectorAll(".rolUser_error");

    //ADMINISTRADOR PHP
    let errorNombreA = document.querySelectorAll(".Anombre_error");
    let errorMailA = document.querySelectorAll(".Amail_error");
    let errorPasswordA = document.querySelectorAll(".Apassword_error");
    //let errorRolA = document.querySelectorAll(".rolUser_error");

    errorFecha.forEach((error) => {
        if (errorInfoFecha.value.trim() !== "") {
            error.classList.remove("display_error");
        }
    });

    errorImei.forEach((error) => {
        if (errorInfoImei.value.trim() !== "") {
            error.classList.remove("display_error");
        }
    });

    //console.log(inputEmpresa.value);
    //console.log(selectEmpresa.value);
    errorEmpresa.forEach((error) => {
        if (
            errorInfoEmpresa.value.trim() !== "" ||
            errorInfoInputEmpresa.value.trim() !== ""
        ) {
            error.classList.remove("display_error");
        }
    });

    errorfalla.forEach((error) => {
        if (
            errorFallaTelefono.value.trim() !== "" ||
            errorFallaTablet.value.trim() !== "" ||
            errorFallaNotebook.value.trim() !== "" ||
            errorFallaReloj.value.trim() !== ""
        ) {
            error.classList.remove("display_error");
        }
    });

    errorDetalles.forEach((error) => {
        if (errorInfoDetalles.value.trim() !== "") {
            error.classList.remove("display_error");
        }
    });

    errorClave.forEach((error) => {
        if (errorInfoClave.value.trim() !== "") {
            error.classList.remove("display_error");
        }
    });

    errorPrecio.forEach((error) => {
        if (errorInfoPrecio.value.trim() !== "") {
            error.classList.remove("display_error");
        }
    });

    //EMPRESA
    errorNombre.forEach((error) => {
        if (errorNombreEmpresa.value.trim() !== "") {
            error.classList.remove("display_error");
        }
    });

    errorMail.forEach((error) => {
        if (errorMailEmpresa.value.trim() !== "") {
            error.classList.remove("display_error");
        }
    });

    errorUbicacion.forEach((error) => {
        if (errorUbicacionEmpresa.value.trim() !== "") {
            error.classList.remove("display_error");
        }
    });

    errorTelefono.forEach((error) => {
        if (errorTelefonoEmpresa.value.trim() !== "") {
            error.classList.remove("display_error");
        }
    });

    errorPagina.forEach((error) => {
        if (errorPaginaEmpresa.value.trim() !== "") {
            error.classList.remove("display_error");
        }
    });

    errorNombreU.forEach((error) => {
        if (errorNombreUsuario.value.trim() !== "") {
            error.classList.remove("display_error");
        }
    });

    errorMailU.forEach((error) => {
        if (errorMailUsuario.value.trim() !== "") {
            error.classList.remove("display_error");
        }
    });

    errorPasswordU.forEach((error) => {
        if (errorPasswordUsuario.value.trim() !== "") {
            error.classList.remove("display_error");
        }
    });

    //ADMINISTRADOR PHP

    errorNombreA.forEach((error) => {
        if (errorAgregarUsuario.value.trim() !== "") {
            error.classList.remove("display_error");
        }
    });

    errorMailA.forEach((error) => {
        if (errorAgregarMail.value.trim() !== "") {
            error.classList.remove("display_error");
        }
    });

    errorPasswordA.forEach((error) => {
        if (errorAgregarPassword.value.trim() !== "") {
            error.classList.remove("display_error");
        }
    });

    errorRolA.forEach((error) => {
        if (errorRolUsuario.value.trim() !== "") {
            error.classList.remove("display_error");
        }
    });
}
//LIMPIAR ERRORES FIN

// Función para el precio
//PRECIO $xx.xxx
function formatPrice(input) {
    let value = input.value;

    // Eliminar cualquier carácter que no sea un dígito
    value = value.replace(/[^\d]/g, "");

    // Verificar si el valor es mayor a cero
    if (value > 0) {
        // Formatear el valor con el símbolo de dólar y el punto como separador de miles
        let formattedValue = "$" + addThousandSeparator(value);

        // Actualizar el valor del campo de entrada
        input.value = formattedValue;
    }
}
function addThousandSeparator(value) {
    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

//solo numeros en price
function validateNumber(input) {
    // Filtrar el valor ingresado y eliminar caracteres no numéricos
    input.value = input.value.replace(/[^0-9]/g, "");
}

// Función para registrar la selección del usuario
function registrarSeleccion(opcion) {
    seleccionesUsuario.push(opcion);
    console.log("Selecciones del usuario:", seleccionesUsuario);
}

// Función para borrar las selecciones del usuario
function borrarSelecciones() {
    seleccionesUsuario.length = 0;
    console.log("Selecciones del usuario borradas.");
}

// Event listener para el botón "close"
document
    .getElementById("closeAgregarEquipo")
    .addEventListener("click", function () {
        borrarSelecciones();
    });

// Event listeners para cada botón
document.getElementById("btnCliente").addEventListener("click", function () {
    registrarSeleccion("cliente");
});
document.getElementById("btnEmpresa").addEventListener("click", function () {
    registrarSeleccion("empresa");
});

document.getElementById("btnTelefono").addEventListener("click", function () {
    registrarSeleccion("telefono");
});
document.getElementById("btnTablet").addEventListener("click", function () {
    registrarSeleccion("tablet");
});
document.getElementById("btnNotebook").addEventListener("click", function () {
    registrarSeleccion("notebook");
});
document.getElementById("btnReloj").addEventListener("click", function () {
    registrarSeleccion("reloj");
});

//variables para guardar la seleccion y despues mandar a imprimir
var iphoneImprimir;
var colorImprimir;
var fallaEquipoImprimir;
var fechaImprimir;
var imeiImprimir;
var detallesImprimir;
var claveImprimir;
var precioImprimir;
var nombreImprimir;
var apellidoImprimir;
var telefonoImprimir;

function agregarEquipo_function(item) {
    // Función para mostrar el elemento especificado y ocultar los demás
    function showElement(element) {
        const elements = [
            popup1,
            popup1_cliente,
            popup_clienteExistente,
            popup_clienteNuevo,
            popup2,
            popup3,
            popup4,
            popup5,
            fin,
        ];
        elements.forEach(
            (el) => (el.style.display = el === element ? "block" : "none")
        );
    }

    // Función para cambiar el botón activo
    function setActiveButton(activeButton) {
        const buttons = [button1, button2, button3, button4, button5];
        buttons.forEach((btn) =>
            btn.classList.toggle("active", btn === activeButton)
        );
    }

    var agregar = document.getElementById("agregarEquipo");
    var popup1_cliente = document.getElementById("item1_cliente");
    var popupBtnClientes = document.getElementById("popupBtnClientes");
    var popup_clienteExistente = document.getElementById(
        "popupClienteExistente"
    );
    var popup_clienteNuevo = document.getElementById("popupClienteNuevo");
    var popup1 = document.getElementById("item1");
    var popup2 = document.getElementById("item2");
    var popup3 = document.getElementById("item3");
    var popup4 = document.getElementById("item4");
    var popup5 = document.getElementById("item5");
    var fin = document.getElementById("finalPedido");

    // Obtener los botones del sidebar
    var button1 = document.getElementById("btn1");
    var button2 = document.getElementById("btn2");
    var button3 = document.getElementById("btn3");
    var button4 = document.getElementById("btn4");
    var button5 = document.getElementById("btn5");

    // Obtener Popups del item 3
    var modeloTelefono = document.getElementById("modeloEquipoTelefono");
    var modeloTablet = document.getElementById("modeloEquipoTablet");
    var modeloNotebook = document.getElementById("modeloEquipoNotebook");
    var modeloReloj = document.getElementById("modeloEquipoReloj");

    var colorTelefono = document.getElementById("colorEquipoTelefono");
    var colorTablet = document.getElementById("colorEquipoTablet");
    var colorNotebook = document.getElementById("colorEquipoNotebook");
    var colorReloj = document.getElementById("colorEquipoReloj");

    //variables para cargar en el php (se hace al final el pase de info de js a php)
    //toda variable anterior declararla

    //falla del equipo seleccionado
    var fallaEquipo = document.getElementById("fallaEquipo");
    var fallaTablet = document.getElementById("fallaTablet");
    var fallaNotebook = document.getElementById("fallaNotebook");
    var fallaReloj = document.getElementById("fallaReloj");

    //AGREGAR FUNCTION SHOWELEMENTS CON FOR Y HIDELEMENT CON FOR

    if (item === "agregarEquipo") {
        agregar.style.display = "block";
        showElement(popup1);
        fin.style.display = "none";
        setActiveButton(button1);
    }

    //CLIENTE
    else if (item === "cliente") {
        seleccionUsuario = item;
        popup1_cliente.style.display = "block";
        popupBtnClientes.style.display = "block";
        popup_clienteExistente.style.display = "none";
        popup_clienteNuevo.style.display = "none";
        //showElement(popup1_cliente);
        popup1.style.display = "none";
        setActiveButton(button1);
    } else if (item === "clienteExistente") {
        seleccionUsuario = item;
        popup1_cliente.style.display = "block";
        popupBtnClientes.style.display = "none";
        popup_clienteExistente.style.display = "block";
        popup_clienteNuevo.style.display = "none";
        //showElement(popup_clienteExistente);
        //popupBtnClientes.style.display = "none";
        setActiveButton(button1);
    } else if (item === "clienteNuevo") {
        seleccionUsuario = item;
        popupBtnClientes.style.display = "none";
        popup_clienteExistente.style.display = "none";
        popup_clienteNuevo.style.display = "block";
        //showElement(popup_clienteNuevo);
        //popupBtnClientes.style.display = "none";
        setActiveButton(button1);
    } else if (item === "cliente_existente") {
        if (clientSelected != "") {
            seleccionUsuario = clientSelected;
            registrarSeleccion(clientSelected);
            seleccionUsuario = item;
            showElement(popup2);
            popup1_cliente.style.display = "none";
            setActiveButton(button2);

            ////variables a imprimir
            //nombreImprimir = clienteNombre;
            //apellidoImprimir = clienteApellido;
            //telefonoImprimir = clienteTelefono;
            //aca tengo que ver de levantar el apellido y el telefono de la tabla dependiendo
            //el cliente seleccionado... select nombre,apeliddo,telefono where nombre=clientSelected

            //ACA SE GUARDAN LOS DATOS INGRESADOS POR EL USUARIO
            //var selectClienteExistente = document.getElementById("selectClienteExistente").value;
            //
            //if (selectClienteExistente != ''){
            //  clienteExistenteSeleccionado = selectClienteExistente;
            //  registrarSeleccion(clienteExistenteSeleccionado);
            //
            //  seleccionUsuario = item;
            //  showElement(popup2);
            //  popup1_cliente.style.display = "none";
            //  setActiveButton(button2);
        } else {
            //alert('selecciona un cliente');
            showError(
                "clienteExistente_error",
                "Tenes que seleccionar un cliente"
            );
            //clientSelected = "";
        }
    } else if (item === "cliente_nuevo") {
        clienteNombre = document.getElementById("inputNombre").value;
        clienteApellido = document.getElementById("inputApellido").value;
        clienteTelefono = document.getElementById("inputTelefono").value;

        if (
            clienteNombre != "" &&
            clienteApellido != "" &&
            clienteTelefono != ""
        ) {
            //variables a imprimir
            nombreImprimir = clienteNombre;
            apellidoImprimir = clienteApellido;
            telefonoImprimir = clienteTelefono;

            registrarSeleccion(clienteNombre);
            registrarSeleccion(clienteApellido);
            registrarSeleccion(clienteTelefono);

            //seleccionUsuario = item;
            showElement(popup2);
            popup1_cliente.style.display = "none";
            setActiveButton(button2);
        } else {
            //alert("completa los campos");
            if (clienteNombre == "") {
                showError("nuevoNombre_error", "Ingresa un nombre");
            }
            if (clienteApellido == "") {
                showError("nuevoApellido_error", "Ingresa un apellido");
            }
            if (clienteTelefono == "") {
                showError("nuevoTelefono_error", "Ingresa un telefono");
            }
        }
    }

    //EMPRESA
    else if (item === "empresa") {
        seleccionUsuario = item;
        showElement(popup2);
        popup1.style.display = "none";
        setActiveButton(button2);
    }

    //ESTOS SON LOS POPUPS DEPENDIENDO QUE SELECCIONE EL USUARIO
    // para levantar la tabla sql que corresponda
    else if (item === "telefono") {
        seleccionUsuario = item;
        showElement(popup3);
        modeloTelefono.style.display = "flex";
        colorTelefono.style.display = "flex";
        modeloTablet.style.display = "none";
        modeloNotebook.style.display = "none";
        modeloReloj.style.display = "none";
        colorTablet.style.display = "none";
        colorNotebook.style.display = "none";
        colorReloj.style.display = "none";
        popup2.style.display = "none";
        setActiveButton(button3);
    } else if (item === "tablet") {
        seleccionUsuario = item;
        showElement(popup3);
        modeloTablet.style.display = "flex";
        colorTablet.style.display = "flex";
        modeloTelefono.style.display = "none";
        modeloNotebook.style.display = "none";
        modeloReloj.style.display = "none";
        colorTelefono.style.display = "none";
        colorNotebook.style.display = "none";
        colorReloj.style.display = "none";
        popup2.style.display = "none";
        setActiveButton(button3);
    } else if (item === "notebook") {
        seleccionUsuario = item;
        showElement(popup3);
        modeloNotebook.style.display = "flex";
        colorNotebook.style.display = "flex";
        modeloTelefono.style.display = "none";
        modeloTablet.style.display = "none";
        modeloReloj.style.display = "none";
        colorTelefono.style.display = "none";
        colorTablet.style.display = "none";
        colorReloj.style.display = "none";
        popup2.style.display = "none";
        setActiveButton(button3);
    } else if (item === "reloj") {
        seleccionUsuario = item;
        showElement(popup3);
        modeloReloj.style.display = "flex";
        colorReloj.style.display = "flex";
        modeloTelefono.style.display = "none";
        modeloTablet.style.display = "none";
        modeloNotebook.style.display = "none";
        colorTelefono.style.display = "none";
        colorTablet.style.display = "none";
        colorNotebook.style.display = "none";
        popup2.style.display = "none";
        setActiveButton(button3);
    } else if (item === "nextTo4") {
        var selectModeloTelefono = document.getElementById(
            "selectModeloTelefono"
        ).value;
        var selectModeloTablet =
            document.getElementById("selectModeloTablet").value;
        var selectModeloNotebook = document.getElementById(
            "selectModeloNotebook"
        ).value;
        var selectModeloReloj =
            document.getElementById("selectModeloReloj").value;

        var selectColorTelefono = document.getElementById(
            "selectColorTelefono"
        ).value;
        var selectColorTablet =
            document.getElementById("selectColorTablet").value;
        var selectColorNotebook = document.getElementById(
            "selectColorNotebook"
        ).value;
        var selectColorReloj =
            document.getElementById("selectColorReloj").value;

        //EMPRESA
        var inputEmpresa = document.getElementById("InputEmpresa");
        var selectEmpresa = document.getElementById("selectInputEmpresa");
        var labelCliente = document.getElementById("labelCliente");
        var labelEmpresa = document.getElementById("labelEmpresa");
        //Limpio errores previos
        //clearError();

        function validarCamposSeleccionados(modelo, color) {
            if (modelo !== "" && color !== "") {
                if (
                    (clientSelected &&
                        clientSelected !== "undefined" &&
                        clientSelected !== "" &&
                        clientSelected !== "error") ||
                    (clienteNombre &&
                        clienteNombre !== "undefined" &&
                        clienteNombre !== "" &&
                        clienteNombre !== "error")
                ) {
                    if (clientSelected !== "") {
                        inputEmpresa.value = clientSelected;
                    } else if (clienteNombre !== "") {
                        inputEmpresa.value = clienteNombre;
                    }

                    inputEmpresa.style.display = "block";
                    labelCliente.style.display = "block";
                    inputEmpresa.disabled = true; // Deshabilitar la edición del input

                    selectEmpresa.style.display = "none";
                    labelEmpresa.style.display = "none";
                } else {
                    selectEmpresa.style.display = "block";
                    labelEmpresa.style.display = "block";

                    inputEmpresa.style.display = "none";
                    labelCliente.style.display = "none";
                }

                showElement(popup4);
                popup3.style.display = "none";
                setActiveButton(button4);

                // Guardo en las variables
                registrarSeleccion(modelo);
                registrarSeleccion(color);
                modeloSeleccionado = modelo;
                colorSeleccionado = color;
            } else {
                //alert("Selecciona algo en todos los campos.");
                if (modelo == "") {
                    showError("modeloEquipo_error", "Selecciona un modelo");
                }
                if (color == "") {
                    showError("modeloColor_error", "Selecciona un color");
                }
            }
        }

        if (seleccionesUsuario.indexOf("telefono") !== -1) {
            validarCamposSeleccionados(
                selectModeloTelefono,
                selectColorTelefono
            );
        } else if (seleccionesUsuario.indexOf("tablet") !== -1) {
            validarCamposSeleccionados(selectModeloTablet, selectColorTablet);
        } else if (seleccionesUsuario.indexOf("notebook") !== -1) {
            validarCamposSeleccionados(
                selectModeloNotebook,
                selectColorNotebook
            );
        } else if (seleccionesUsuario.indexOf("reloj") !== -1) {
            validarCamposSeleccionados(selectModeloReloj, selectColorReloj);
        }

        //fallas dependiendo el equipo
        if (seleccionesUsuario.includes("telefono")) {
            fallaEquipo.style.display = "flex";
            fallaTablet.style.display = "none";
            fallaNotebook.style.display = "none";
            fallaReloj.style.display = "none";
        } else if (seleccionesUsuario.includes("tablet")) {
            fallaTablet.style.display = "flex";
            fallaEquipo.style.display = "none";
            fallaNotebook.style.display = "none";
            fallaReloj.style.display = "none";
        } else if (seleccionesUsuario.includes("notebook")) {
            fallaNotebook.style.display = "flex";
            fallaTablet.style.display = "none";
            fallaEquipo.style.display = "none";
            fallaReloj.style.display = "none";
        } else if (seleccionesUsuario.includes("reloj")) {
            fallaReloj.style.display = "flex";
            fallaTablet.style.display = "none";
            fallaNotebook.style.display = "none";
            fallaEquipo.style.display = "none";
        }

        //aca guardo los datos en la tabla sql
    } else if (item === "nextTo5") {
        var fecha = document.getElementById("fechaAutomaticaEmpresa").value;
        var imei = document.getElementById("InputImei").value;
        var empresa = document.getElementById("InputEmpresa").value;
        var selectEmpresa = document.getElementById("selectInputEmpresa").value;
        var empresaData = "";
        var selectFallaTelefono = document.getElementById(
            "selectFallaTelefono"
        ).value;
        var selectFallaTablet =
            document.getElementById("selectFallaTablet").value;
        var selectFallaNotebook = document.getElementById(
            "selectFallaNotebook"
        ).value;
        var selectFallaReloj =
            document.getElementById("selectFallaReloj").value;
        var detalles = document.getElementById("InputDetalles").value;
        var clave = document.getElementById("InputClave").value;
        var precio = document.getElementById("InputPrecio").value;

        //perifericos
        var checkboxes = document.querySelectorAll(
            "input[name='perifericos[]']:checked"
        );
        var perifericosSeleccionados = Array.from(checkboxes).map(
            (checkbox) => checkbox.value
        );
        var perifericosOk;

        if (perifericosSeleccionados.length === 0) {
            perifericosOk = "OK";
        } else {
            perifericosOk = perifericosSeleccionados.join(", ");
        }

        //imei
        var imeiOk = "";

        if (imei.length >= 14 && imei.length <= 15) {
            imeiOk = "si";
        } else {
            imeiOk = "no";
        }

        if (selectFallaTelefono != "") {
            fallaSeleccionada = selectFallaTelefono;
        }
        if (selectFallaTablet != "") {
            fallaSeleccionada = selectFallaTablet;
        }
        if (selectFallaNotebook != "") {
            fallaSeleccionada = selectFallaNotebook;
        }
        if (selectFallaReloj != "") {
            fallaSeleccionada = selectFallaReloj;
        }

        if (empresa != "") {
            empresaData = empresa;
        } else if (selectEmpresa != "") {
            empresaData = selectEmpresa;
        }

        //variables para guardar la seleccion y despues mandar a imprimir
        iphoneImprimir = modeloSeleccionado;
        colorImprimir = colorSeleccionado;
        fallaEquipoImprimir = fallaSeleccionada;
        fechaImprimir = fecha;
        imeiImprimir = imei;
        detallesImprimir = detalles;
        claveImprimir = clave;
        precioImprimir = precio;

        if (
            fecha !== "" &&
            imeiOk == "si" &&
            empresaData !== "" &&
            fallaSeleccionada !== "" &&
            perifericosOk !== ""
        ) {
            showElement(popup5);
            popup4.style.display = "none";
            setActiveButton(button5);

            // Crea un objeto con los datos que deseas enviar al archivo PHP
            var data = {
                seleccionesUsuario: seleccionesUsuario,
                modeloSeleccionado: modeloSeleccionado,
                colorSeleccionado: colorSeleccionado,
                fallaSeleccionada: fallaSeleccionada,
                fechaSeleccionada: fecha,
                imeiSeleccionado: imei,
                empresaSeleccionada: empresaData,
                detallesSeleccionada: detalles,
                perifericosSeleccionados: perifericosOk,
                claveSeleccionada: clave,
                precioSeleccionado: precio,
                clientSelected: clientSelected,
                clienteNombre: clienteNombre,
                clienteApellido: clienteApellido,
                clienteTelefono: clienteTelefono,
            };
            //ACA: envio los datos al php para que se guarden.
            //enviarDatosAlServidor();
            // Actualizar los valores en el objeto data
            //data.modeloSeleccionado = modeloSeleccionado;
            //data.colorSeleccionado = colorSeleccionado;
            //data.fallaSeleccionada = fallaSeleccionada;
            // Envía la solicitud al archivo PHP mediante Fetch API
            fetch("php/equipo_nuevo.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data),
            })
                .then((response) => response.json())
                .then((result) => {
                    // Maneja la respuesta del servidor si es necesario
                    console.log(result);
                })
                .catch((error) => {
                    // Maneja cualquier error que pueda ocurrir
                    console.error("Error:", error);
                });
        } else {
            if (fecha == "") {
                showError("fechaAutomatica_error", "Ingresa una fecha valida");
            }
            if (imei.length !== 14 && imei.length !== 15) {
                showError(
                    "imei_error",
                    "Ingresa el imei correcto (14,15 digitos)"
                );
            }
            if (empresaData == "") {
                showError("empresa_error", "Ingresa una empresa");
            }
            if (fallaSeleccionada == "") {
                showError("falla_error", "Selecciona una falla");
            }
            //if (detalles == ''){
            //  showError("detalles_error", "Ingresa los detalles");
            //}
            //if (clave == ''){
            //  showError("clave_error", "Ingresa una clave");
            //}
            //if (precio == ''){
            // showError("precio_error", "Ingresa un precio");
            // }
        }
    } else if (item === "imprimir") {
        //showElement(fin);
        //popup5.style.display = "none";
        //setActiveButton(button5);

        console.log("Datos a enviar al servidor:");
        console.log("iPhone:", iphoneImprimir);
        console.log("Color:", colorImprimir);
        console.log("Falla del Equipo:", fallaEquipoImprimir);
        console.log("Fecha:", fechaImprimir);
        console.log("IMEI:", imeiImprimir);
        console.log("Detalles:", detallesImprimir);
        console.log("Clave:", claveImprimir);
        console.log("Precio:", precioImprimir);
        console.log("Nombre:", nombreImprimir);
        console.log("Apellido:", apellidoImprimir);
        console.log("Teléfono:", telefonoImprimir);

        var formData = new FormData();
        formData.append("iphone", iphoneImprimir);
        formData.append("color", colorImprimir);
        formData.append("fallaEquipo", fallaEquipoImprimir);
        formData.append("fecha", fechaImprimir);
        formData.append("imei", imeiImprimir);
        formData.append("detalles", detallesImprimir);
        formData.append("clave", claveImprimir);
        formData.append("precio", precioImprimir);
        formData.append("nombre", nombreImprimir);
        formData.append("apellido", apellidoImprimir);
        formData.append("telefono", telefonoImprimir);

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "php/equipo_imprimir.php", true);
        xhr.send(formData);

        //   var data = {
        //     iphone: iphoneImprimir,
        //     color: colorImprimir,
        //     fallaEquipo: fallaEquipoImprimir,
        //     fecha: fechaImprimir,
        //     imei: imeiImprimir,
        //     detalles: detallesImprimir,
        //     clave: claveImprimir,
        //     precio: precioImprimir,
        //     nombre: nombreImprimir,
        //     apellido: apellidoImprimir,
        //     telefono: telefonoImprimir
        //   };
        //    // Realiza la solicitud POST al servidor para generar el PDF
        //     fetch('php/equipo_imprimir.php', {
        //         method: 'POST',
        //         headers: {
        //             'Content-Type': 'application/json',
        //         },
        //         body: JSON.stringify(data),
        //     })
        //     .then(response => response.json())
        //     .then(result => {
        //         // Maneja la respuesta del servidor si es necesario
        //         console.log(result);
        //     })
        //     .catch(error => {
        //         // Maneja cualquier error que pueda ocurrir
        //         console.error('Error:', error);
        //     });
    } else if (item === "mail") {
        showElement(fin);
        popup5.style.display = "none";
        setActiveButton(button5);
    } else if (item === "fin") {
        agregar.style.display = "none";
        location.reload(); // Recargar la página
    }
}

//////////////////////////////////////////////////////////////////////////////////////
// POPUP MAS DETALLES

//esto es para que si se pasa horizontalmente.. se agrega un scroll sino no.
//document.addEventListener("DOMContentLoaded", function() {
//  const detallesInfoElements = document.querySelectorAll(".detalles_info");
//  detallesInfoElements.forEach(function(detallesInfo) {
//      detallesInfo.addEventListener("mouseover", function() {
//          const contenidoAncho = detallesInfo.scrollWidth;
//          const contenedorAncho = detallesInfo.clientWidth;
//
//          if (contenidoAncho > contenedorAncho) {
//              detallesInfo.style.overflowX = "scroll";
//          } else {
//              detallesInfo.style.overflowX = "hidden";
//          }
//      });
//  });
//});

///////////////////////////////////////
//EMPRESAS
///////////////////////////////////////

//Slider de empresas
const slidesContainer = document.getElementById("slides-container");
const slides = document.querySelectorAll(".slide");
//const prevButton = document.getElementById("slide-arrow-prev");
//const nextButton = document.getElementById("slide-arrow-next");

const selectEmpresa = document.getElementById("selectEmpresa");

//let isAnimating = false;

//nextButton.addEventListener("click", () => {
//  if (isAnimating) return;
//
//  const slideWidth = slidesContainer.clientWidth;
//  isAnimating = true;
//
//  slidesContainer.scrollLeft += slideWidth;
//
//  setTimeout(() => {
//    isAnimating = false;
//  }, 500); // Ajusta el tiempo según la duración de tu animación
//});
//
//prevButton.addEventListener("click", () => {
//  if (isAnimating) return;
//
//  const slideWidth = slidesContainer.clientWidth;
//  isAnimating = true;
//
//  slidesContainer.scrollLeft -= slideWidth;
//
//  setTimeout(() => {
//    isAnimating = false;
//  }, 500); // Ajusta el tiempo según la duración de tu animación
//});

//SELECT EMPRESA
selectEmpresa.addEventListener("change", () => {
    const empresaSeleccionada = selectEmpresa.value;

    slides.forEach((slide) => {
        const dataEmpresa = slide.getAttribute("data-empresa");

        if (dataEmpresa === empresaSeleccionada) {
            slide.style.display = "flex"; // Muestra el elemento
        } else {
            slide.style.display = "none"; // Oculta el elemento
        }
    });
});

let mailCompleto = ""; // Declaración global
let empresaSeleccionada = ""; // Declaración global

//Funcionalidad del slider empresas para que al hacer clic se vea:
//El nombre, los usuarios y los equipos que tiene esa empresa
document.addEventListener("DOMContentLoaded", function () {
    const divDominios = document.getElementsByClassName("infoEmpresa");
    const empresaNameElement = document.getElementById("empresaName");
    const tablaUsuarios = document.getElementById("tablaUsuarios");
    const tablaEquipos = document.getElementById("tablaEquiposPorEmpresa");

    // var empresaName = localStorage.getItem("empresaName");
    const selectedEmpresa = localStorage.getItem("selectedEmpresa");
    empresaNameElement.textContent = selectedEmpresa;
    // console.log (selectedEmpresa);

    for (const div of divDominios) {
        const btnDominio = div.querySelector(".btnDominio");
        const domain = btnDominio.getAttribute("data-domain");
        const dominioSinCom = domain.split(".")[0];

        const selectedEmpresa = localStorage.getItem("selectedEmpresa");
        empresaNameElement.textContent = selectedEmpresa;
        //console.log(domain);

        btnDominio.addEventListener("click", function () {
            filterUsuariosByDomain(domain, tablaUsuarios);
            filterEquiposByDomain(dominioSinCom, tablaEquipos);

            //var empresaNameUpdate = localStorage.getItem("empresaNameUpdate");
            //console.log(selectedEmpresa);
            //empresaNameElement.textContent = selectedEmpresa;

            const selectedEmpresa = localStorage.getItem("selectedEmpresa");
            empresaNameElement.textContent = selectedEmpresa;
            //console.log(selectedEmpresa);

            // Guardar el dominio seleccionado en el almacenamiento local
            //localStorage.setItem("selectedDomain", domain);
            //console.log(domain);
            //empresaSeleccionada = domain;

            //var nombreEmpresa = localStorage.getItem("nombreEditarEmpresa");
            //console.log(nombreEmpresa);
        });
    }

    // Consultar el almacenamiento local al cargar la página
    const selectedDomain = localStorage.getItem("selectedDomain");
    if (selectedDomain) {
        const dominioSinCom = selectedDomain.split(".")[0];
        filterUsuariosByDomain(selectedDomain, tablaUsuarios);
        filterEquiposByDomain(dominioSinCom, tablaEquipos);

        empresaNameElement.textContent = selectedEmpresa;
    }

    function filterUsuariosByDomain(domain, tablaUsuarios) {
        const filasUsuarios = tablaUsuarios.querySelectorAll("tbody tr");

        filasUsuarios.forEach((fila) => {
            const emailCell = fila.querySelector("td:nth-child(2)");
            if (emailCell) {
                const emailParts = emailCell.textContent.split("@");
                const usuarioDomain = emailParts[emailParts.length - 1];

                if (usuarioDomain === domain) {
                    fila.style.display = "table-row";
                } else {
                    fila.style.display = "none";
                }
            }
        });
    }

    function filterEquiposByDomain(domain, tablaEquipos) {
        const filasEquipos = tablaEquipos.querySelectorAll("tbody tr");

        filasEquipos.forEach((fila) => {
            const empresaCell = fila.querySelector("td:nth-child(4)");
            if (empresaCell) {
                const equipoDomain = empresaCell.textContent.trim();
                const dominioSinCom = domain.split(".")[0];

                if (equipoDomain === dominioSinCom) {
                    fila.style.display = "table-row";
                } else {
                    fila.style.display = "none";
                }
            }
        });
    }

    const inputMailUsuario = document.getElementById("InputMailUsuario");
    const nombreEmpresa = document.getElementById("nombreEmpresa");

    const empresaSeleccionadaNew = localStorage.getItem("selectedEmpresa");

    for (const div of divDominios) {
        const btnDominio = div.querySelector(".btnDominio");
        const domain = btnDominio.getAttribute("data-domain");
        const dominioSinCom = domain.split(".")[0];

        btnDominio.addEventListener("click", function () {
            //empresaSeleccionada = dominioSinCom;

            const nombreEmpresaReal = localStorage.getItem(
                "nombreEditarEmpresa"
            );
            nombreEmpresa.value = "@" + nombreEmpresaReal;
            updateFullName();
        });
    }

    inputMailUsuario.addEventListener("input", function () {
        const nombreEmpresaReal = localStorage.getItem("nombreEditarEmpresa");
        const inputValue = nombreEmpresa.value;
        if (inputValue !== "@" + nombreEmpresaReal) {
            nombreEmpresa.value = "@" + nombreEmpresaReal;
        }
        updateFullName();
    });

    function updateFullName() {
        const nombreEmpresaReal = localStorage.getItem("nombreEditarEmpresa");
        const nombreUsuario = inputMailUsuario.value;
        const nombreEmpresa = nombreEmpresaReal;
        //const nombreCompleto = `${nombreUsuario}@${nombreEmpresa}`;
        //inputMailEmpresa.value = nombreCompleto;
        mailCompleto = `${nombreUsuario}@${nombreEmpresa}`;
    }
});

//AGREGAR EMPRESA + USUARIO FUNCION
function agregarEmpresa_function(item) {
    var agregarEmpresa = document.getElementById("agregarEmpresa");
    var agregarUsuario = document.getElementById("agregarUsuario");

    if (item === "empresa") {
        agregarEmpresa.style.display = "block";
    }

    if (item === "empresaOk") {
        empresaNombre = document.getElementById("InputNombreEmpresa").value;
        empresaMail = document.getElementById("InputMailEmpresa").value;
        empresaUbicacion = document.getElementById(
            "InputUbicacionEmpresa"
        ).value;
        empresaTelefono = document.getElementById("InputTelefonoEmpresa").value;
        empresaPagina = document.getElementById("InputPaginaEmpresa").value;

        if (
            empresaNombre != "" &&
            empresaMail != "" &&
            empresaUbicacion != "" &&
            empresaTelefono != "" &&
            empresaPagina != ""
        ) {
            agregarEmpresa.style.display = "none";
            location.reload(); // Recargar la página
            //guardar los datos en la tabla
            // Crea un objeto con los datos que deseas enviar al archivo PHP
            var data = {
                nombreSeleccionado: empresaNombre,
                mailSeleccionado: empresaMail,
                ubicacionSeleccionado: empresaUbicacion,
                telefonoSeleccionado: empresaTelefono,
                paginaSeleccionado: empresaPagina,
            };
            //ACA: envio los datos al php para que se guarden.
            //enviarDatosAlServidor();
            // Actualizar los valores en el objeto data
            //data.modeloSeleccionado = modeloSeleccionado;
            //data.colorSeleccionado = colorSeleccionado;
            //data.fallaSeleccionada = fallaSeleccionada;
            // Envía la solicitud al archivo PHP mediante Fetch API
            fetch("php/empresa_nuevo.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data),
            })
                .then((response) => response.json())
                .then((result) => {
                    // Maneja la respuesta del servidor si es necesario
                    console.log(result);
                })
                .catch((error) => {
                    // Maneja cualquier error que pueda ocurrir
                    console.error("Error:", error);
                });

            registrarSeleccion(empresaNombre);
            registrarSeleccion(empresaMail);
            registrarSeleccion(empresaUbicacion);
            registrarSeleccion(empresaTelefono);
            registrarSeleccion(empresaPagina);
        } else {
            //alert("completa los campos");
            if (empresaNombre == "") {
                showError("nombre_error", "Ingresa un nombre");
            }
            if (empresaMail == "") {
                showError("mail_error", "Ingresa un mail");
            }
            if (empresaUbicacion == "") {
                showError("ubicacion_error", "Ingresa una ubicacion");
            }
            if (empresaTelefono == "") {
                showError("telefono_error", "Ingresa un telefono");
            }
            if (empresaPagina == "") {
                showError("pagina_error", "Ingresa una pagina");
            }
        }
    }

    if (item === "usuario") {
        agregarUsuario.style.display = "block";
    }

    if (item === "usuarioOk") {
        //guardar los datos en la tabla
        //agregarUsuario.style.display = "none";

        usuarioNombre = document.getElementById("InputNombreUsuario").value;
        usuarioMail = document.getElementById("InputMailUsuario").value;
        usuarioPassword = document.getElementById("InputPasswordUsuario").value;
        //usuarioSelectRol = document.getElementById("selectRolUsuario").value;

        // Verificar si el correo electrónico contiene el dominio almacenado en domain
        var domain = localStorage.getItem("selectedDomain");

        if (usuarioNombre != "" && usuarioMail != "" && usuarioPassword != "") {
            //if (usuarioMail.includes("@" + domain)) {
            agregarUsuario.style.display = "none";
            //location.reload(); // Recargar la página

            //console.log(mailCompleto);
            //usuarioMail = mailCompleto;

            // Crea un objeto con los datos que deseas enviar al archivo PHP
            var data = {
                nombreSeleccionado: usuarioNombre,
                mailSeleccionado: mailCompleto,
                passwordSeleccionado: usuarioPassword,
                esCliente: "si",
            };
            fetch("php/usuario_nuevo.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data),
            })
                .then((response) => response.json())
                .then((result) => {
                    // Maneja la respuesta del servidor si es necesario
                    console.log(result);
                })
                .catch((error) => {
                    // Maneja cualquier error que pueda ocurrir
                    console.error("Error:", error);
                });
            //} else {
            //  showError("Umail_error", "Ingresa un mail que corresponda al cliente (ej: prueba@appletime.com");
            //}
        } else {
            //alert("completa los campos");
            if (usuarioNombre == "") {
                showError("Unombre_error", "Ingresa un nombre");
            }
            if (usuarioMail == "") {
                showError("Umail_error", "Ingresa un mail");
            }
            if (usuarioPassword == "") {
                showError("Upassword_error", "Ingresa una contraseña");
            }
        }
    }
}

//Close modals
let btnCloseEmpresa = document.getElementById("closeAgregarEmpresa");
let btnCloseUsuario = document.getElementById("closeAgregarUsuario");

btnCloseEmpresa.addEventListener("click", () => {
    agregarEmpresa.style.display = "none";

    inputs.forEach((input) => (input.value = ""));

    clearError();
    clearErrorInformacion();
});

btnCloseUsuario.addEventListener("click", () => {
    agregarUsuario.style.display = "none";

    //Limpio todo menos mi input nombre empresa
    inputs.forEach((input) => {
        if (input !== nombreEmpresa) {
            input.value = "";
        }
    });

    clearError();
    clearErrorInformacion();
});

//let btnReset = document.getElementById("closeAgregarEquipo");
//
//let selects = document.querySelectorAll("select");
//let inputs = document.querySelectorAll("input");
//
//let resetSelectedClientContainer = document.getElementById("selectedClientContainer");
//let resetSelectedClient = document.getElementById("selectedClient");
//let resetInputclient = document.getElementById("searchClient");
//
////BTN CLOSE
//btnReset.addEventListener('click', () => {
//  selects.forEach(select => select.selectedIndex = 0);
//  inputs.forEach(input => input.value = '');
//
//  resetSelectedClientContainer.style.display = 'none';
//  resetSelectedClient.textContent = "";
//  resetInputclient.focus();
//  clientSelected = "";
//
//  document.getElementById('fechaAutomaticaEmpresa').valueAsDate = new Date();
//
//  fallaSeleccionada = '';
//
//  clearError();
//  clearErrorNewClient();
//  clearErrorModeloColor();
//  clearErrorInformacion();
//});

//DELETE USER
function confirmDelete(button) {
    var id = button.getAttribute("data-id");
    var mail = button.getAttribute("data-mail");
    var popupDelete = document.getElementById("deleteUser");
    var formDeleteUser = document.getElementById("form_delete_user");

    // Mostrar el mensaje de confirmación
    popupDelete.style.display = "block";
    var confirmMessage = popupDelete.querySelector(".confirm-message");
    confirmMessage.innerHTML = `¿ Estás seguro de querer eliminar a: <span class="mailDelete">${mail}</span> ?`;

    var idEditUser = localStorage.getItem("currentUserId");
    // Configurar el valor del campo "id" en el formulario
    formDeleteUser.querySelector('input[name="id"]').value = id;
}

function cancelDelete() {
    var popupDelete = document.getElementById("deleteUser");
    popupDelete.style.display = "none";
}

//CONFIGURACION
const tabItems = document.querySelectorAll(".tab_item");
const tabsConfig = document.querySelectorAll(".tabsContent");

// Función para cambiar la pestaña activa y mostrar el contenido correspondiente
function changeTab(event) {
    // Prevenir comportamiento predeterminado del enlace
    event.preventDefault();

    // Remover la clase 'active' de todos los elementos de pestañas
    tabItems.forEach((tab) => {
        tab.classList.remove("active");
    });

    // Agregar la clase 'active' al elemento de pestaña seleccionado
    this.classList.add("active");

    // Ocultar todos los elementos de contenido
    tabsConfig.forEach((tab) => {
        tab.style.display = "none";
    });

    // Mostrar el contenido de la pestaña seleccionada
    const targetId = this.getAttribute("href");
    const targetTab = document.querySelector(targetId);
    if (targetTab) {
        targetTab.style.display = "block";
    }
}

// Agregar el evento de clic a cada elemento de pestaña
tabItems.forEach((tab) => {
    tab.addEventListener("click", changeTab);
});

///////////////////////////////////////////////////////////
//                    ADMINISTRADOR PHP
///////////////////////////////////////////////////////////

//DELETE USER
function confirmDeleteEquipo(button) {
    var id = button.getAttribute("data-id");
    var equipo = button.getAttribute("data-equipo");
    var empresa = button.getAttribute("data-empresa");
    var popupDelete = document.getElementById("deleteEquipo");
    var formDeleteEquipo = document.getElementById("form_delete_equipo");

    // Mostrar el mensaje de confirmación
    popupDelete.style.display = "block";
    var confirmMessage = popupDelete.querySelector(".confirm-delete");
    confirmMessage.innerHTML = `¿ Estás seguro de querer eliminar el equipo: <span class="equipoDelete">${equipo}</span> de <span class="empresaDelete">${empresa}</span> ?`;

    // Configurar el valor del campo "id" en el formulario
    formDeleteEquipo.querySelector('input[name="id"]').value = id;
}

function cancelDeleteEquipo() {
    var popupDelete = document.getElementById("deleteEquipo");
    popupDelete.style.display = "none";
}

function confirmDeleteUsers(button) {
    var id = button.getAttribute("data-id");
    var mail = button.getAttribute("data-mail");
    var popupDelete = document.getElementById("deleteUsers");
    var formDeleteUser = document.getElementById("form_delete_users");

    // Mostrar el mensaje de confirmación
    popupDelete.style.display = "block";
    var confirmMessage = popupDelete.querySelector(".confirm-delete_users");
    confirmMessage.innerHTML = `¿ Estás seguro de querer eliminar a: <span class="mailDelete">${mail}</span> ?`;

    // Configurar el valor del campo "id" en el formulario
    formDeleteUser.querySelector('input[name="id"]').value = id;
}

function cancelDeleteUsers() {
    var popupDelete = document.getElementById("deleteUsers");
    popupDelete.style.display = "none";
}

//TABLA CONTRASEÑA OCULTAR Y VER
function showPassword(id) {
    const passwordSpan = document.getElementById("password_" + id);
    const maskedPasswordSpan = document.getElementById("maskedPassword_" + id);

    passwordSpan.style.display = "inline";
    maskedPasswordSpan.style.display = "none";
}

function hidePassword(id) {
    const passwordSpan = document.getElementById("password_" + id);
    const maskedPasswordSpan = document.getElementById("maskedPassword_" + id);

    passwordSpan.style.display = "none";
    maskedPasswordSpan.style.display = "inline";
}

//AGREGAR USUARIO
function agregarUsuario_function(item) {
    var agregarUsuario = document.getElementById("agregarUsuario02");
    var popupEditarUsuario = document.getElementById("popupEditarUsuario");

    if (item === "usuario") {
        agregarUsuario.style.display = "block";
    }

    if (item === "usuarioOk") {
        //guardar los datos en la tabla
        //agregarUsuario.style.display = "none";

        usuarioNombre = document.getElementById("InputAgregarNombre").value;
        usuarioMail = document.getElementById("InputAgregarMail").value;
        usuarioPassword = document.getElementById("InputAgregarPassword").value;
        usuarioSelectRol = document.getElementById("selectRolUsuario").value;

        // Verificar si el correo electrónico contiene el dominio almacenado en domain
        //var domain = localStorage.getItem("selectedDomain");

        if (
            usuarioNombre != "" &&
            usuarioMail != "" &&
            usuarioPassword != "" &&
            usuarioSelectRol != ""
        ) {
            // if (usuarioMail.includes("@" + domain)) {
            agregarUsuario.style.display = "none";
            location.reload(); // Recargar la página

            //guardar los datos en la tabla
            // Crea un objeto con los datos que deseas enviar al archivo PHP
            var data = {
                nombreSeleccionado: usuarioNombre,
                mailSeleccionado: usuarioMail,
                passwordSeleccionado: usuarioPassword,
                rolSeleccionado: usuarioSelectRol,
                esCliente: "no",
            };
            fetch("php/usuario_nuevo.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data),
            })
                .then((response) => response.json())
                .then((result) => {
                    // Maneja la respuesta del servidor si es necesario
                    console.log(result);
                })
                .catch((error) => {
                    // Maneja cualquier error que pueda ocurrir
                    console.error("Error:", error);
                });

            registrarSeleccion(usuarioNombre);
            registrarSeleccion(usuarioMail);
            registrarSeleccion(usuarioPassword);
            registrarSeleccion(usuarioSelectRol);
            //} else {
            // showError("Amail_error", "Ingresa un mail que corresponda al cliente (ej: prueba@appletime.com");
            //}
        } else {
            //alert("completa los campos");
            if (usuarioNombre == "") {
                showError("Anombre_error", "Ingresa un nombre");
            }
            if (usuarioMail == "") {
                showError("Amail_error", "Ingresa un mail");
            }
            if (usuarioPassword == "") {
                showError("Apassword_error", "Ingresa una contraseña");
            }
            if (usuarioSelectRol == "") {
                showError("rolUser_error", "Selecciona un rol");
            }
        }
    }

    if (item === "editarUsuario02") {
    }
}

//Close modals
let btnCloseAgregarUsuario = document.getElementById("close02AgregarUsuario");
let agregarUsuario02 = document.getElementById("agregarUsuario02");

// Evento clic en el botón de cerrar
btnCloseAgregarUsuario.addEventListener("click", () => {
    agregarUsuario02.style.display = "none";

    // Limpiar los valores de los inputs dentro del modal
    inputs.forEach((input) => (input.value = ""));
    selects.forEach((select) => (select.selectedIndex = 0));

    // Funciones para limpiar los mensajes de error
    clearError();
    clearErrorInformacion();
});

// Evento clic fuera del modal
//window.onclick = function(event) {
//  if (event.target === agregarUsuario02) {
//    agregarUsuario02.style.display = "none";
//
//    // Limpiar los valores de los inputs dentro del modal
//    inputs.forEach(input => input.value = '');
//    selects.forEach(select => select.selectedIndex = 0);
//
//    // Funciones para limpiar los mensajes de error
//    clearError();
//    clearErrorInformacion();
//  }
//}

//EDITAR USERS
// Obtener todos los botones con la clase btnUsuarioEditar
let btnUsuarioEditar = document.getElementsByClassName(".btnUsuarioEditar");

// Iterar sobre los botones y asignar un evento clic a cada uno
for (var i = 0; i < btnUsuarioEditar.length; i++) {
    btnUsuarioEditar[i].addEventListener("click", function () {
        // Obtener el valor del atributo data-id
        var dataId = this.getAttribute("data-id");

        // Obtener el modal de edición
        var modalEditar = document.getElementById("editarUsuario");

        // Realizar las operaciones necesarias con los valores obtenidos
        if (modalEditar) {
            // Acciones específicas para el modal de edición
            // ... (tu código aquí)

            // Mostrar el modal de edición
            modalEditar.style.display = "block";

            // Aquí podrías ejecutar el código que personaliza el modal de edición
        }
    });
}

//INPUT CONFIGURACION ROJO VERDE FORMULARIO
//document.getElementById("formEditar").addEventListener("submit", function(e) {
//  // Obtener todos los campos de entrada que tengan la clase "invalid-input"
//  var invalidInputs = document.querySelectorAll(".invalid-input");
//
//  // Verificar si hay algún campo con la clase "invalid-input"
//  if (invalidInputs.length > 0) {
//      e.preventDefault(); // Evitar que el formulario se envíe
//      alert("Por favor, corrija los errores en el formulario antes de enviar.");
//  }
//});
//
//
// Ejemplo de validación para el campo Fecha (puedes adaptarlo para otros campos)
var fechaInput = document.getElementById("fechaEditar");
fechaInput.addEventListener("input", function () {
    var inputValue = this.value;

    // Expresión regular para validar el formato "día/mes/año" (por ejemplo, "02/08/2023")
    var isValidDate = /^(\d{2})\/(\d{2})\/(\d{4})$/.test(inputValue);

    if (isValidDate) {
        this.classList.remove("invalid-input");
        this.classList.add("valid-input");
    } else {
        this.classList.remove("valid-input");
        this.classList.add("invalid-input");
    }

    if (inputValue.length === 0) {
        this.classList.remove("valid-input");
        this.classList.remove("invalid-input");
    }
});

// Valida el campo IMEI
var imeiInput = document.getElementById("imeiEditar");
imeiInput.addEventListener("input", function () {
    var inputValue = this.value;

    if (inputValue.length === 15 || inputValue.length === 14) {
        this.classList.remove("invalid-input");
        this.classList.add("valid-input");
    } else {
        this.classList.remove("valid-input");
        this.classList.add("invalid-input");
    }

    if (inputValue.length === 0) {
        this.classList.remove("valid-input");
        this.classList.remove("invalid-input");
    }
});

var imeiInput = document.getElementById("InputImei");

imeiInput.addEventListener("input", function () {
    var inputValue = this.value;

    // Verifica si la longitud del IMEI está entre 14 y 15 dígitos
    if (inputValue.length >= 14 && inputValue.length <= 15) {
        this.classList.remove("invalid-input");
        this.classList.add("valid-input");
    } else {
        this.classList.remove("valid-input");
        this.classList.add("invalid-input");
    }

    // Si el campo está vacío, elimina las clases de estilo
    if (inputValue.length === 0) {
        this.classList.remove("valid-input");
        this.classList.remove("invalid-input");
    }
});

//EDITAR EQUIPO
document.addEventListener("DOMContentLoaded", function () {
    var formEditar = document.getElementById("formEditar");
    var submitButton = document.getElementById("submitButton");

    formEditar.addEventListener("submit", function (event) {
        var imeiInput = document.getElementById("imeiEditar");
        var fechaInput = document.getElementById("fechaEditar");

        // Validar que el IMEI tenga 14 o 15 dígitos
        var imeiValue = imeiInput.value;
        if (imeiValue.length !== 14 && imeiValue.length !== 15) {
            alert("El IMEI debe tener 14 o 15 dígitos.");
            event.preventDefault(); // Evitar el envío del formulario
        }

        // Validar que la fecha no esté vacía y tenga el formato correcto (dia/mes/año)
        var fechaValue = fechaInput.value;
        var fechaRegex = /^(\d{2})\/(\d{2})\/(\d{4})$/; // Expresión regular para el formato "dd/mm/yyyy"

        if (fechaValue.trim() === "" || !fechaRegex.test(fechaValue)) {
            alert(
                "Por favor, ingrese una fecha válida en el formato dd/mm/yyyy."
            );
            event.preventDefault(); // Evitar el envío del formulario
        }

        // Validar otros campos si es necesario
        //var otrosCamposValidos = true; // Puedes agregar más lógica de validación aquí
        //
        //if (!otrosCamposValidos) {
        //    alert("Por favor, complete todos los campos.");
        //    event.preventDefault(); // Evitar el envío del formulario
        //}

        // Deshabilitar el botón de envío si se encontraron errores
        //if (imeiInput.classList.contains("invalid-input") || fechaValue.trim() === "" || !fechaRegex.test(fechaValue) || !otrosCamposValidos) {
        //    submitButton.disabled = true;
        //}
    });
});
