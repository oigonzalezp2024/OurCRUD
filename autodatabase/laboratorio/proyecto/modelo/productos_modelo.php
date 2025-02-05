<?php
include 'conexion.php';
$conn = conexion();

$accion = $_GET['accion'];

if($accion == "insertar"){

    $id_producto = $_POST['id_producto'];
    $nombre = $_POST['nombre'];
    $proveedor_id = $_POST['proveedor_id'];

    $sql="INSERT INTO productos(
          id_producto, nombre, proveedor_id
          )VALUE(
          '$id_producto', '$nombre', '$proveedor_id')";

    echo $consulta = mysqli_query($conn, $sql);
}

elseif($accion == "modificar"){

    $id_producto = $_POST['id_producto'];
    $nombre = $_POST['nombre'];
    $proveedor_id = $_POST['proveedor_id'];

    $sql="UPDATE productos SET
          nombre = '$nombre', 
          proveedor_id = '$proveedor_id'
          WHERE id_producto = '$id_producto'";

    echo $consulta = mysqli_query($conn, $sql);
}

elseif($accion == "borrar"){

    $id_producto = $_POST['id_producto'];

    $sql = "DELETE FROM productos
            WHERE id_producto = '$id_producto'";

    echo $consulta = mysqli_query($conn, $sql);
}


?>