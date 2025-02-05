<?php
function conexion(){
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'aa_ventas_prueba';
    $conn = mysqli_connect($host, $user, $password, $database);
    return $conn;
}
?>
