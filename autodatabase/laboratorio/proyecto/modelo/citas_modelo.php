<?php
include 'conexion.php';
$conn = conexion();

$accion = $_GET['accion'];

if($accion == "insertar"){

    $id_cita = $_POST['id_cita'];
    $producto_id = $_POST['producto_id'];
    $vendedor_id = $_POST['vendedor_id'];
    $cliente_id = $_POST['cliente_id'];

    $sql="INSERT INTO citas(
          id_cita, producto_id, vendedor_id, cliente_id
          )VALUE(
          '$id_cita', '$producto_id', '$vendedor_id', '$cliente_id')";

    echo $consulta = mysqli_query($conn, $sql);
}

elseif($accion == "modificar"){

    $id_cita = $_POST['id_cita'];
    $producto_id = $_POST['producto_id'];
    $vendedor_id = $_POST['vendedor_id'];
    $cliente_id = $_POST['cliente_id'];

    $sql="UPDATE citas SET
          producto_id = '$producto_id', 
          vendedor_id = '$vendedor_id', 
          cliente_id = '$cliente_id'
          WHERE id_cita = '$id_cita'";

    echo $consulta = mysqli_query($conn, $sql);
}

elseif($accion == "borrar"){

    $id_cita = $_POST['id_cita'];

    $sql = "DELETE FROM citas
            WHERE id_cita = '$id_cita'";

    echo $consulta = mysqli_query($conn, $sql);
}


?>