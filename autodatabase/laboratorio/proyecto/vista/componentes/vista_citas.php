<?php
include_once '../../modelo/conexion.php';
$conn = conexion();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>arreglos</title>
</head>
<div class="row"><br><br><br><br>
    <div>
<center>
<h2>citas</h2>
</center>
<button class="btn btn-primary navbar-left"
               data-toggle="modal"
               data-target="#modalNuevo">
    Agregar citas
    <span class="glyphicon glyphicon-plus"></span>
</button></div>
    <table class="table table-hover table-condensed table-bordered table-responsive">
    <thead>
        <tr>
            <th>id_cita</th>
            <th>producto_id</th>
            <th>vendedor_id</th>
            <th>cliente_id</th>
        </tr>
   </thead>
    <tbody>
    <?php
    $sql = 'SELECT * FROM citas';
    $result = mysqli_query($conn, $sql);
    WHILE($fila = mysqli_fetch_assoc($result)){
        $datos = $fila['id_cita'] . "||" .
                  $fila['producto_id'] . "||" .
                  $fila['vendedor_id'] . "||" .
                  $fila['cliente_id'];
    ?>
        <tr>
            <td><?php echo $fila['id_cita']; ?></td>
            <td><?php echo $fila['producto_id']; ?></td>
            <td><?php echo $fila['vendedor_id']; ?></td>
            <td><?php echo $fila['cliente_id']; ?></td>
            <td>
                <button class="btn btn-warning glyphicon glyphicon-pencil"
                               data-toggle="modal"
                               data-target="#modalEdicion"
                               onclick="agregaform('<?php echo $datos; ?>')">
                </button></td>
            <td>
                <button class="btn btn-danger glyphicon glyphicon-remove"
                           onclick="preguntarSiNo('<?php echo $fila['id_cita']; ?>')">
                </button>
            </td>
        </tr>
    <?php
    }
    ?>
    </tbody>
    </table>
</div>
</body>
</html>
<?php
mysqli_close($conn);
?>
