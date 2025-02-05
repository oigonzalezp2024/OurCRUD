function agregardatos(id_mydatabase, database__name){
    cadena = "id_mydatabase=" + id_mydatabase +
    "&database__name=" + database__name;

    accion = "insertar";
    mensaje_si = "Cliente agregado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}
function agregaform(datos) {
    d = datos.split('||');
    $('#id_mydatabaseu').val(d[0]);
    $('#database__nameu').val(d[1]);
}

function modificarCliente(){
    id_mydatabase = $('#id_mydatabaseu').val();
    database__name = $('#database__nameu').val();
    cadena = "id_mydatabase=" + id_mydatabase +
    "&database__name=" + database__name;

    accion = "modificar";
    mensaje_si = "Cliente modificado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}

function descargarBaseDeDatos(id_mydatabase){
    cadena = "id_mydatabase=" + id_mydatabase;
    accion = "descargar";
    mensaje_si = "Base de datos descargada exitosamente.";
    mensaje_no= "Error al intentar descargar una base de datos.";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}

function crearBaseDeDatos(id_mydatabase){
    cadena = "id_mydatabase=" + id_mydatabase;
    accion = "crear";
    mensaje_si = "Base de datos creada exitosamente.";
    mensaje_no= "Error al intentar crear una base de datos.";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}

function preguntarSiNo(id_mydatabase) {
    var opcion = confirm("¿Esta seguro de eliminar el registro?");
    if (opcion == true) {
        alert("El registro será eliminado.");
        eliminarDatos(id_mydatabase);
    } else {
        alert("El proceso de eliminación del registro ha sido cancelado.");
    }
}

function eliminarDatos(id_mydatabase) {
    cadena = "id_mydatabase=" + id_mydatabase;

    accion = "borrar";
    mensaje_si = "Cliente borrado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}

function a_ajax(cadena, accion, mensaje_si, mensaje_no){
    $.ajax({
        type: "POST",
        url: "../modelo/mydatabases_modelo.php?accion="+accion,
        data: cadena,
        success: function (r){
            if (r == 1) {
            $('#tabla').load('../vista/componentes/vista_mydatabases.php');
                alert(mensaje_si);
            } else {
                alert(mensaje_no);
            }
        }
    });
}
