function agregardatos(id_field_type, field_type){
    cadena = "id_field_type=" + id_field_type +
    "&field_type=" + field_type;

    accion = "insertar";
    mensaje_si = "Cliente agregado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}
function agregaform(datos) {
    d = datos.split('||');
    $('#id_field_typeu').val(d[0]);
    $('#field_typeu').val(d[1]);
}

function modificarCliente(){
    id_field_type = $('#id_field_typeu').val();
    field_type = $('#field_typeu').val();
    cadena = "id_field_type=" + id_field_type +
    "&field_type=" + field_type;

    accion = "modificar";
    mensaje_si = "Cliente modificado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}

function preguntarSiNo(id_field_type) {
    var opcion = confirm("¿Esta seguro de eliminar el registro?");
    if (opcion == true) {
        alert("El registro será eliminado.");
        eliminarDatos(id_field_type);
    } else {
        alert("El proceso de eliminación del registro ha sido cancelado.");
    }
}

function eliminarDatos(id_field_type) {
    cadena = "id_field_type=" + id_field_type;

    accion = "borrar";
    mensaje_si = "Cliente borrado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}

function a_ajax(cadena, accion, mensaje_si, mensaje_no){
    $.ajax({
        type: "POST",
        url: "../modelo/field_types_modelo.php?accion="+accion,
        data: cadena,
        success: function (r){
            if (r == 1) {
            $('#tabla').load('../vista/componentes/vista_field_types.php');
                alert(mensaje_si);
            } else {
                alert(mensaje_no);
            }
        }
    });
}
