<?php
include 'conexion.php';
$conn = conexion();

$accion = $_GET['accion'];

if($accion == "insertar"){

    $id_proveedor = $_POST['id_proveedor'];
    $nombre = $_POST['nombre'];

    $sql="INSERT INTO proveedores(
          id_proveedor, nombre
          )VALUE(
          '$id_proveedor', '$nombre')";

    echo $consulta = mysqli_query($conn, $sql);
}

elseif($accion == "modificar"){

    $id_proveedor = $_POST['id_proveedor'];
    $nombre = $_POST['nombre'];

    $sql="UPDATE proveedores SET
          nombre = '$nombre'
          WHERE id_proveedor = '$id_proveedor'";

    echo $consulta = mysqli_query($conn, $sql);
}

elseif($accion == "borrar"){

    $id_proveedor = $_POST['id_proveedor'];

    $sql = "DELETE FROM proveedores
            WHERE id_proveedor = '$id_proveedor'";

    echo $consulta = mysqli_query($conn, $sql);
}


?>