function agregardatos(id_vendedor, nombre, apellido, direccion, celular){
    cadena = "id_vendedor=" + id_vendedor +
    "&nombre=" + nombre +
    "&apellido=" + apellido +
    "&direccion=" + direccion +
    "&celular=" + celular;

    accion = "insertar";
    mensaje_si = "Cliente agregado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}
function agregaform(datos) {
    d = datos.split('||');
    $('#id_vendedoru').val(d[0]);
    $('#nombreu').val(d[1]);
    $('#apellidou').val(d[2]);
    $('#direccionu').val(d[3]);
    $('#celularu').val(d[4]);
}

function modificarCliente(){
    id_vendedor = $('#id_vendedoru').val();
    nombre = $('#nombreu').val();
    apellido = $('#apellidou').val();
    direccion = $('#direccionu').val();
    celular = $('#celularu').val();
    cadena = "id_vendedor=" + id_vendedor +
    "&nombre=" + nombre +
    "&apellido=" + apellido +
    "&direccion=" + direccion +
    "&celular=" + celular;

    accion = "modificar";
    mensaje_si = "Cliente modificado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}

function preguntarSiNo(id_vendedor) {
    var opcion = confirm("¿Esta seguro de eliminar el registro?");
    if (opcion == true) {
        alert("El registro será eliminado.");
        eliminarDatos(id_vendedor);
    } else {
        alert("El proceso de eliminación del registro ha sido cancelado.");
    }
}

function eliminarDatos(id_vendedor) {
    cadena = "id_vendedor=" + id_vendedor;

    accion = "borrar";
    mensaje_si = "Cliente borrado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}

function a_ajax(cadena, accion, mensaje_si, mensaje_no){
    $.ajax({
        type: "POST",
        url: "../modelo/vendedores_modelo.php?accion="+accion,
        data: cadena,
        success: function (r){
            if (r == 1) {
            $('#tabla').load('../vista/componentes/vista_vendedores.php');
                alert(mensaje_si);
            } else {
                alert(mensaje_no);
            }
        }
    });
}
