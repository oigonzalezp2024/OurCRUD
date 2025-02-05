function agregardatos(id_table, table__name, mydatabase_id)
{
    cadena = "id_table=" + id_table +
    "&table__name=" + table__name +
    "&mydatabase_id=" + mydatabase_id;

    $('#mydatabase_idu').val(mydatabase_id);

    accion = "insertar";
    mensaje_si = "Cliente agregado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}

function agregaform(datos) {
    d = datos.split('||');
    $('#id_tableu').val(d[0]);
    $('#table__nameu').val(d[1]);
    $('#mydatabase_idu').val(d[2]);
}

function modificarCliente()
{
    id_table = $('#id_tableu').val();
    table__name = $('#table__nameu').val();
    mydatabase_id = $('#mydatabase_idu').val();
    cadena = "id_table=" + id_table +
    "&table__name=" + table__name +
    "&mydatabase_id=" + mydatabase_id;

    accion = "modificar";
    mensaje_si = "Cliente modificado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}

function preguntarSiNo(datos) {
    var opcion = confirm("¿Esta seguro de eliminar el registro?");
    if (opcion == true) {
        alert("El registro será eliminado.");
        eliminarDatos(datos);
    } else {
        alert("El proceso de eliminación del registro ha sido cancelado.");
    }
}

function eliminarDatos(datos)
{
    d = datos.split('||');
    id_table = d[0];
    $('#mydatabase_idu').val(d[2]);
    
    cadena = "id_table=" + id_table;
    accion = "borrar";
    mensaje_si = "Cliente borrado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}

function a_ajax(cadena, accion, mensaje_si, mensaje_no)
{
    mydatabase_id = $('#mydatabase_idu').val();
    $.ajax({
        type: "POST",
        url: "../modelo/mytables_modelo.php?accion="+accion,
        data: cadena,
        success: function (r){
            if (r == 1) {
            $('#tabla').load("../vista/componentes/vista_mytables_database_id.php?id="+mydatabase_id);
                alert(mensaje_si);
            } else {
                alert(mensaje_no);
            }
        }
    });
}
