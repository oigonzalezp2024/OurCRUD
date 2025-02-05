<?php
include 'conexion.php';
$conn = conexion();

$accion = $_GET['accion'];

if ($accion == "insertar") {

    $consulta = 0;

    $id_field = $_POST['id_field'];
    $field_name = $_POST['field_name'];
    $field_position = $_POST['field_position'];
    $field_type_id = $_POST['field_type_id'];
    $field_size_id = $_POST['field_size_id'];
    $field_index_id = 1;
    $table_id = $_POST['table_id'];

    $sql = "SELECT 
        MAX(field_position) as field_position
        FROM myfields
        WHERE table_id = $table_id;";
    $result = mysqli_query($conn, $sql);
    while ($fila = mysqli_fetch_assoc($result)) {
        $field_position = $fila['field_position'];
        $field_position += 1;

        $sql = "INSERT INTO myfields(
          id_field, field_name, field_position, field_type_id, field_size_id, field_index_id, table_id
          )VALUE(
          '$id_field', '$field_name', '$field_position', '$field_type_id', '$field_size_id', '$field_index_id', '$table_id')";
        $consulta = mysqli_query($conn, $sql);
    }

    echo $consulta;
} elseif ($accion == "modificar") {

    $id_field = $_POST['id_field'];
    $field_name = $_POST['field_name'];
    $field_position = $_POST['field_position'];
    $field_type_id = $_POST['field_type_id'];
    $field_size_id = $_POST['field_size_id'];
    $field_index_id = $_POST['field_index_id'];
    $table_id = $_POST['table_id'];

    $sql = "UPDATE myfields SET
          field_name = '$field_name',
          field_position = '$field_position',  
          field_type_id = '$field_type_id', 
          field_size_id = '$field_size_id', 
          field_index_id = '$field_index_id', 
          table_id = '$table_id'
          WHERE id_field = '$id_field'";

    echo $consulta = mysqli_query($conn, $sql);
} elseif ($accion == "borrar") {

    $id_field = $_POST['id_field'];

    $sql = "DELETE FROM myfields
            WHERE id_field = '$id_field'";

    echo $consulta = mysqli_query($conn, $sql);
}
