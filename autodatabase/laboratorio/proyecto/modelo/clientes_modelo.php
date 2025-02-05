<?php
include 'conexion.php';
$conn = conexion();

$accion = $_GET['accion'];

if($accion == "insertar"){

    $id_cliente = $_POST['id_cliente'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $direccion = $_POST['direccion'];
    $celular = $_POST['celular'];

    $sql="INSERT INTO clientes(
          id_cliente, nombre, apellido, direccion, celular
          )VALUE(
          '$id_cliente', '$nombre', '$apellido', '$direccion', '$celular')";

    echo $consulta = mysqli_query($conn, $sql);
}

elseif($accion == "modificar"){

    $id_cliente = $_POST['id_cliente'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $direccion = $_POST['direccion'];
    $celular = $_POST['celular'];

    $sql="UPDATE clientes SET
          nombre = '$nombre', 
          apellido = '$apellido', 
          direccion = '$direccion', 
          celular = '$celular'
          WHERE id_cliente = '$id_cliente'";

    echo $consulta = mysqli_query($conn, $sql);
}

elseif($accion == "borrar"){

    $id_cliente = $_POST['id_cliente'];

    $sql = "DELETE FROM clientes
            WHERE id_cliente = '$id_cliente'";

    echo $consulta = mysqli_query($conn, $sql);
}


?>