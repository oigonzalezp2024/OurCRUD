<?php
include_once '../../modelo/conexion.php';
$conn = conexion();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <center>
        <h2 style="margin-top:100px;">Field sizes</h2>
    </center>
    <button class="btn navbar-left"
        data-toggle="modal"
        data-target="#modalNuevo">
        <span class="glyphicon glyphicon-plus"></span>
    </button>
    <table class="table table-hover table-responsive">
        <thead>
            <tr>
                <th></th>
                <th>id</th>
                <th>field size</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = 'SELECT * FROM field_sizes';
            $result = mysqli_query($conn, $sql);
            while ($fila = mysqli_fetch_assoc($result)) {
                $datos = $fila['id_field_size'] . "||" .
                    $fila['field_size'];
            ?>
                <tr>
                    <td>
                        <button class="btn glyphicon glyphicon-pencil"
                            data-toggle="modal"
                            data-target="#modalEdicion"
                            onclick="agregaform('<?php echo $datos; ?>')">
                        </button>
                        <button class="btn glyphicon glyphicon-remove"
                            onclick="preguntarSiNo('<?php echo $fila['id_field_size']; ?>')">
                        </button>
                    </td>
                    <td><?php echo $fila['id_field_size']; ?></td>
                    <td><?php echo $fila['field_size']; ?></td>
                    <td>
                        <button class="btn glyphicon glyphicon-pencil"
                            data-toggle="modal"
                            data-target="#modalEdicion"
                            onclick="agregaform('<?php echo $datos; ?>')">
                        </button>
                        <button class="btn glyphicon glyphicon-remove"
                            onclick="preguntarSiNo('<?php echo $fila['id_field_size']; ?>')">
                        </button>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</body>

</html>
<?php
mysqli_close($conn);
