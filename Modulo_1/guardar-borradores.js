function guardarBorrador(formulario, clave) {
    var borrador = {};

    for (var i = 0; i < formulario.elements.length; i++) {
        var campo = formulario.elements[i];
        if (campo.name) {
            borrador[campo.name] = campo.value;
        }
    }

    sessionStorage.setItem(clave, JSON.stringify(borrador));
}

function cargarBorrador(formulario, clave) {
    var textoBorrador = sessionStorage.getItem(clave);

    if (textoBorrador === null) {
        return;
    }

    var borrador = JSON.parse(textoBorrador);

    for (var i = 0; i < formulario.elements.length; i++) {
        var campo = formulario.elements[i];
        if (campo.name && borrador[campo.name] !== undefined) {
            campo.value = borrador[campo.name];
        }
    }
}

document.addEventListener("DOMContentLoaded", function () {
    var formularioUsuario = document.getElementById("form-usuario");
    var formularioEquipo = document.getElementById("form-equipo");
    var guardado = window.location.search;

    if (guardado.indexOf("guardado=usuario") !== -1) {
        sessionStorage.removeItem("borradorUsuario");
    }
    if (guardado.indexOf("guardado=equipo") !== -1) {
        sessionStorage.removeItem("borradorEquipo");
    }

    cargarBorrador(formularioUsuario, "borradorUsuario");
    cargarBorrador(formularioEquipo, "borradorEquipo");

    formularioUsuario.addEventListener("input", function () {
        guardarBorrador(formularioUsuario, "borradorUsuario");
    });
    formularioUsuario.addEventListener("submit", function () {
        guardarBorrador(formularioUsuario, "borradorUsuario");
    });

    formularioEquipo.addEventListener("input", function () {
        guardarBorrador(formularioEquipo, "borradorEquipo");
    });
    formularioEquipo.addEventListener("submit", function () {
        guardarBorrador(formularioEquipo, "borradorEquipo");
    });
});
