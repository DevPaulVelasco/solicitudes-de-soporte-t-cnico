function validar() {
    // 1. Obtenemos lo que el usuario seleccionó o escribió
    let usuario = document.getElementById("usuario_id").value;
    let equipo = document.getElementById("equipo_id").value;
    let descripcion = document.getElementById("descripcion").value;

    // 2. Validamos que el usuario no esté vacío
    if (usuario == "") {
        alert("Debes seleccionar un usuario");
        return false;
    }

    // 3. Validamos que el equipo no esté vacío
    if (equipo == "") {
        alert("Debes seleccionar un equipo");
        return false;
    }

    // 4. Validamos que la descripción no esté vacía
    if (descripcion == "") {
        alert("Debes escribir una descripción del problema");
        return false;
    }

    // 5. Si todo está completo, permitimos enviar el form
    return true;
}