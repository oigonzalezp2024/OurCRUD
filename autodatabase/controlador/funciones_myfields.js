function agregardatos(id_field, field_name, field_type_id, field_size_id, field_position, table_id){
    cadena = "id_field=" + id_field +
    "&field_name=" + field_name +
    "&field_type_id=" + field_type_id +
    "&field_size_id=" + field_size_id +
    "&field_position=" + field_position +
    "&table_id=" + table_id;

    $('#table_idu').val(table_id);

    accion = "insertar";
    mensaje_si = "Cliente agregado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}

function agregaform(datos) {
    d = datos.split('||');
    $('#id_fieldu').val(d[0]);
    $('#field_nameu').val(d[1]);
    $('#field_type_idu').val(d[2]);
    $('#field_size_idu').val(d[3]);
    $('#field_index_idu').val(d[4]);
    $('#table_idu').val(d[5]);
    $('#field_positionu').val(d[6]);
}

function modificarCliente()
{
    id_field = $('#id_fieldu').val();
    field_name = $('#field_nameu').val();
    field_position = $('#field_positionu').val();
    field_type_id = $('#field_type_idu').val();
    field_size_id = $('#field_size_idu').val();
    field_index_id = $('#field_index_idu').val();
    table_id = $('#table_idu').val();
    cadena = "id_field=" + id_field +
    "&field_name=" + field_name +
    "&field_position=" + field_position +
    "&field_type_id=" + field_type_id +
    "&field_size_id=" + field_size_id +
    "&field_index_id=" + field_index_id +
    "&table_id=" + table_id;

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
    $('#table_idu').val(d[5]);
    id_field = d[0];

    cadena = "id_field=" + id_field;
    accion = "borrar";
    mensaje_si = "Cliente borrado con exito";
    mensaje_no= "Error de registro";
    a_ajax(cadena, accion, mensaje_si, mensaje_no);
}

function a_ajax(cadena, accion, mensaje_si, mensaje_no)
{
    table_id = $('#table_idu').val();
    $.ajax({
        type: "POST",
        url: "../modelo/myfields_modelo.php?accion="+accion,
        data: cadena,
        success: function (r){
            if (r == 1) {
            $('#tabla').load("../vista/componentes/vista_myfields_table_id.php?id=" + table_id);
                alert(mensaje_si);
            } else {
                alert(mensaje_no);
            }
        }
    });
}
