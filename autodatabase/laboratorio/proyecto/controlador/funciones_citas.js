function agregardatos(id_cita, producto_id, vendedor_id, cliente_id){
    cadena = "id_cita=" + id_cita +
    "&producto_id=" + producto_id +
    "&vendedor_id=" + vendedor_id +
    "&cliente_id=" + cliente_id;

    accion = "insertar";
    mensaje_si = "Cliente agregado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}
function agregaform(datos) {
    d = datos.split('||');
    $('#id_citau').val(d[0]);
    $('#producto_idu').val(d[1]);
    $('#vendedor_idu').val(d[2]);
    $('#cliente_idu').val(d[3]);
}

function modificarCliente(){
    id_cita = $('#id_citau').val();
    producto_id = $('#producto_idu').val();
    vendedor_id = $('#vendedor_idu').val();
    cliente_id = $('#cliente_idu').val();
    cadena = "id_cita=" + id_cita +
    "&producto_id=" + producto_id +
    "&vendedor_id=" + vendedor_id +
    "&cliente_id=" + cliente_id;

    accion = "modificar";
    mensaje_si = "Cliente modificado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}

function preguntarSiNo(id_cita) {
    var opcion = confirm("¿Esta seguro de eliminar el registro?");
    if (opcion == true) {
        alert("El registro será eliminado.");
        eliminarDatos(id_cita);
    } else {
        alert("El proceso de eliminación del registro ha sido cancelado.");
    }
}

function eliminarDatos(id_cita) {
    cadena = "id_cita=" + id_cita;

    accion = "borrar";
    mensaje_si = "Cliente borrado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}

function a_ajax(cadena, accion, mensaje_si, mensaje_no){
    $.ajax({
        type: "POST",
        url: "../modelo/citas_modelo.php?accion="+accion,
        data: cadena,
        success: function (r){
            if (r == 1) {
            $('#tabla').load('../vista/componentes/vista_citas.php');
                alert(mensaje_si);
            } else {
                alert(mensaje_no);
            }
        }
    });
}
