function agregardatos(id_proveedor, nombre){
    cadena = "id_proveedor=" + id_proveedor +
    "&nombre=" + nombre;

    accion = "insertar";
    mensaje_si = "Cliente agregado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}
function agregaform(datos) {
    d = datos.split('||');
    $('#id_proveedoru').val(d[0]);
    $('#nombreu').val(d[1]);
}

function modificarCliente(){
    id_proveedor = $('#id_proveedoru').val();
    nombre = $('#nombreu').val();
    cadena = "id_proveedor=" + id_proveedor +
    "&nombre=" + nombre;

    accion = "modificar";
    mensaje_si = "Cliente modificado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}

function preguntarSiNo(id_proveedor) {
    var opcion = confirm("¿Esta seguro de eliminar el registro?");
    if (opcion == true) {
        alert("El registro será eliminado.");
        eliminarDatos(id_proveedor);
    } else {
        alert("El proceso de eliminación del registro ha sido cancelado.");
    }
}

function eliminarDatos(id_proveedor) {
    cadena = "id_proveedor=" + id_proveedor;

    accion = "borrar";
    mensaje_si = "Cliente borrado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}

function a_ajax(cadena, accion, mensaje_si, mensaje_no){
    $.ajax({
        type: "POST",
        url: "../modelo/proveedores_modelo.php?accion="+accion,
        data: cadena,
        success: function (r){
            if (r == 1) {
            $('#tabla').load('../vista/componentes/vista_proveedores.php');
                alert(mensaje_si);
            } else {
                alert(mensaje_no);
            }
        }
    });
}
