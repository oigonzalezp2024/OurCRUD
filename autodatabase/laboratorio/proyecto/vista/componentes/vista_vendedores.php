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
<h2>vendedores</h2>
</center>
<button class="btn btn-primary navbar-left"
               data-toggle="modal"
               data-target="#modalNuevo">
    Agregar vendedores
    <span class="glyphicon glyphicon-plus"></span>
</button></div>
    <table class="table table-hover table-condensed table-bordered table-responsive">
    <thead>
        <tr>
            <th>id_vendedor</th>
            <th>nombre</th>
            <th>apellido</th>
            <th>direccion</th>
            <th>celular</th>
        </tr>
   </thead>
    <tbody>
    <?php
    $sql = 'SELECT * FROM vendedores';
    $result = mysqli_query($conn, $sql);
    WHILE($fila = mysqli_fetch_assoc($result)){
        $datos = $fila['id_vendedor'] . "||" .
                  $fila['nombre'] . "||" .
                  $fila['apellido'] . "||" .
                  $fila['direccion'] . "||" .
                  $fila['celular'];
    ?>
        <tr>
            <td><?php echo $fila['id_vendedor']; ?></td>
            <td><?php echo $fila['nombre']; ?></td>
            <td><?php echo $fila['apellido']; ?></td>
            <td><?php echo $fila['direccion']; ?></td>
            <td><?php echo $fila['celular']; ?></td>
            <td>
                <button class="btn btn-warning glyphicon glyphicon-pencil"
                               data-toggle="modal"
                               data-target="#modalEdicion"
                               onclick="agregaform('<?php echo $datos; ?>')">
                </button></td>
            <td>
                <button class="btn btn-danger glyphicon glyphicon-remove"
                           onclick="preguntarSiNo('<?php echo $fila['id_vendedor']; ?>')">
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
