function agregardatos(id_producto, nombre, proveedor_id){
    cadena = "id_producto=" + id_producto +
    "&nombre=" + nombre +
    "&proveedor_id=" + proveedor_id;

    accion = "insertar";
    mensaje_si = "Cliente agregado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}
function agregaform(datos) {
    d = datos.split('||');
    $('#id_productou').val(d[0]);
    $('#nombreu').val(d[1]);
    $('#proveedor_idu').val(d[2]);
}

function modificarCliente(){
    id_producto = $('#id_productou').val();
    nombre = $('#nombreu').val();
    proveedor_id = $('#proveedor_idu').val();
    cadena = "id_producto=" + id_producto +
    "&nombre=" + nombre +
    "&proveedor_id=" + proveedor_id;

    accion = "modificar";
    mensaje_si = "Cliente modificado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}

function preguntarSiNo(id_producto) {
    var opcion = confirm("¿Esta seguro de eliminar el registro?");
    if (opcion == true) {
        alert("El registro será eliminado.");
        eliminarDatos(id_producto);
    } else {
        alert("El proceso de eliminación del registro ha sido cancelado.");
    }
}

function eliminarDatos(id_producto) {
    cadena = "id_producto=" + id_producto;

    accion = "borrar";
    mensaje_si = "Cliente borrado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}

function a_ajax(cadena, accion, mensaje_si, mensaje_no){
    $.ajax({
        type: "POST",
        url: "../modelo/productos_modelo.php?accion="+accion,
        data: cadena,
        success: function (r){
            if (r == 1) {
            $('#tabla').load('../vista/componentes/vista_productos.php');
                alert(mensaje_si);
            } else {
                alert(mensaje_no);
            }
        }
    });
}
