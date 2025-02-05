<?php
include 'conexion.php';
$conn = conexion();

$accion = $_GET['accion'];

if($accion == "insertar"){

    $id_field_size = $_POST['id_field_size'];
    $field_size = $_POST['field_size'];

    $sql="INSERT INTO field_sizes(
          id_field_size, field_size
          )VALUE(
          '$id_field_size', '$field_size')";

    echo $consulta = mysqli_query($conn, $sql);
}

elseif($accion == "modificar"){

    $id_field_size = $_POST['id_field_size'];
    $field_size = $_POST['field_size'];

    $sql="UPDATE field_sizes SET
          field_size = '$field_size'
          WHERE id_field_size = '$id_field_size'";

    echo $consulta = mysqli_query($conn, $sql);
}

elseif($accion == "borrar"){

    $id_field_size = $_POST['id_field_size'];

    $sql = "DELETE FROM field_sizes
            WHERE id_field_size = '$id_field_size'";

    echo $consulta = mysqli_query($conn, $sql);
}


?>