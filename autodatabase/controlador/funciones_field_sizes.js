function agregardatos(id_field_size, field_size){
    cadena = "id_field_size=" + id_field_size +
    "&field_size=" + field_size;

    accion = "insertar";
    mensaje_si = "Cliente agregado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}
function agregaform(datos) {
    d = datos.split('||');
    $('#id_field_sizeu').val(d[0]);
    $('#field_sizeu').val(d[1]);
}

function modificarCliente(){
    id_field_size = $('#id_field_sizeu').val();
    field_size = $('#field_sizeu').val();
    cadena = "id_field_size=" + id_field_size +
    "&field_size=" + field_size;

    accion = "modificar";
    mensaje_si = "Cliente modificado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}

function preguntarSiNo(id_field_size) {
    var opcion = confirm("¿Esta seguro de eliminar el registro?");
    if (opcion == true) {
        alert("El registro será eliminado.");
        eliminarDatos(id_field_size);
    } else {
        alert("El proceso de eliminación del registro ha sido cancelado.");
    }
}

function eliminarDatos(id_field_size) {
    cadena = "id_field_size=" + id_field_size;

    accion = "borrar";
    mensaje_si = "Cliente borrado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}

function a_ajax(cadena, accion, mensaje_si, mensaje_no){
    $.ajax({
        type: "POST",
        url: "../modelo/field_sizes_modelo.php?accion="+accion,
        data: cadena,
        success: function (r){
            if (r == 1) {
            $('#tabla').load('../vista/componentes/vista_field_sizes.php');
                alert(mensaje_si);
            } else {
                alert(mensaje_no);
            }
        }
    });
}
