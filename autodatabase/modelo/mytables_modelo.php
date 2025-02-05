<?php
include 'conexion.php';
$conn = conexion();

$accion = $_GET['accion'];

if($accion == "insertar"){

    $id_table = $_POST['id_table'];
    $table__name = $_POST['table__name'];
    $mydatabase_id = $_POST['mydatabase_id'];

    $sql="INSERT INTO mytables(
          id_table, table__name, mydatabase_id
          )VALUE(
          '$id_table', '$table__name', '$mydatabase_id')";

    echo $consulta = mysqli_query($conn, $sql);
}

elseif($accion == "modificar"){

    $id_table = $_POST['id_table'];
    $table__name = $_POST['table__name'];
    $mydatabase_id = $_POST['mydatabase_id'];

    $sql="UPDATE mytables SET
          table__name = '$table__name', 
          mydatabase_id = '$mydatabase_id'
          WHERE id_table = '$id_table'";

    echo $consulta = mysqli_query($conn, $sql);
}

elseif($accion == "borrar"){

    $id_table = $_POST['id_table'];

    $sql = "DELETE FROM mytables
            WHERE id_table = '$id_table'";

    echo $consulta = mysqli_query($conn, $sql);
}


?>