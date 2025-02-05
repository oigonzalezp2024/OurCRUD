<?php
include 'conexion.php';
$conn = conexion();

$accion = $_GET['accion'];

if($accion == "insertar"){

    $id_field_type = $_POST['id_field_type'];
    $field_type = $_POST['field_type'];

    $sql="INSERT INTO field_types(
          id_field_type, field_type
          )VALUE(
          '$id_field_type', '$field_type')";

    echo $consulta = mysqli_query($conn, $sql);
}

elseif($accion == "modificar"){

    $id_field_type = $_POST['id_field_type'];
    $field_type = $_POST['field_type'];

    $sql="UPDATE field_types SET
          field_type = '$field_type'
          WHERE id_field_type = '$id_field_type'";

    echo $consulta = mysqli_query($conn, $sql);
}

elseif($accion == "borrar"){

    $id_field_type = $_POST['id_field_type'];

    $sql = "DELETE FROM field_types
            WHERE id_field_type = '$id_field_type'";

    echo $consulta = mysqli_query($conn, $sql);
}


?>