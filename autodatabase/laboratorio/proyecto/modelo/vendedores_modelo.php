<?php
include 'conexion.php';
$conn = conexion();

$accion = $_GET['accion'];

if($accion == "insertar"){

    $id_vendedor = $_POST['id_vendedor'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $direccion = $_POST['direccion'];
    $celular = $_POST['celular'];

    $sql="INSERT INTO vendedores(
          id_vendedor, nombre, apellido, direccion, celular
          )VALUE(
          '$id_vendedor', '$nombre', '$apellido', '$direccion', '$celular')";

    echo $consulta = mysqli_query($conn, $sql);
}

elseif($accion == "modificar"){

    $id_vendedor = $_POST['id_vendedor'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $direccion = $_POST['direccion'];
    $celular = $_POST['celular'];

    $sql="UPDATE vendedores SET
          nombre = '$nombre', 
          apellido = '$apellido', 
          direccion = '$direccion', 
          celular = '$celular'
          WHERE id_vendedor = '$id_vendedor'";

    echo $consulta = mysqli_query($conn, $sql);
}

elseif($accion == "borrar"){

    $id_vendedor = $_POST['id_vendedor'];

    $sql = "DELETE FROM vendedores
            WHERE id_vendedor = '$id_vendedor'";

    echo $consulta = mysqli_query($conn, $sql);
}


?>