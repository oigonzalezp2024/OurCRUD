<?php
include_once '../../modelo/conexion.php';
$conn = conexion();
$table_id = $_GET['id'];
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
        <h2 style="margin-top:100px;">myfields table id <?php echo $table_id; ?></h2>
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
                <th>id_field</th>
                <th>field_name</th>
                <th>field type</th>
                <th>field size</th>
                <th>field_index</th>
                <th>field_position</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT id_field as id_field,
                field_name as field_name,
                field_position as field_position,
                field_type_id as field_type_id,
                field_size_id as field_size_id,
                field_index_id as field_index_id,
                table_id as table_id,
                fty.field_type as fty_field_type,
                fsi.field_size as fsi_field_size,
                find.field_index as find_field_index
                FROM myfields as myf,
                field_types as fty,
                field_sizes as fsi,
                field_indexes as find
                WHERE myf.table_id=$table_id
                AND fty.id_field_type = myf.field_type_id
                AND fsi.id_field_size = myf.field_size_id
                AND find.id_field_index = myf.field_index_id
                ORDER BY myf.field_position";
            $result = mysqli_query($conn, $sql);
            while ($fila = mysqli_fetch_assoc($result)) {
                $datos = $fila['id_field'] . "||" .
                    $fila['field_name'] . "||" .
                    $fila['field_type_id'] . "||" .
                    $fila['field_size_id'] . "||" .
                    $fila['field_index_id'] . "||" .
                    $fila['table_id'] . "||" .
                    $fila['field_position'] ;
            ?>
                <tr>
                    <td>
                        <button class="btn glyphicon glyphicon-pencil"
                            data-toggle="modal"
                            data-target="#modalEdicion"
                            onclick="agregaform('<?php echo $datos; ?>')">
                        </button>
                        <button class="btn glyphicon glyphicon-remove"
                            onclick="preguntarSiNo('<?php echo $datos; ?>')">
                        </button>
                    </td>
                    <td><?php echo $fila['id_field']; ?></td>
                    <td><?php echo $fila['field_name']; ?></td>
                    <td><?php echo $fila['fty_field_type']; ?></td>
                    <td><?php echo $fila['fsi_field_size']; ?></td>
                    <td><?php echo $fila['find_field_index']; ?></td>
                    <td><?php echo $fila['field_position']; ?></td>
                    <td>
                        <button class="btn glyphicon glyphicon-pencil"
                            data-toggle="modal"
                            data-target="#modalEdicion"
                            onclick="agregaform('<?php echo $datos; ?>')">
                        </button>
                        <button class="btn glyphicon glyphicon-remove"
                            onclick="preguntarSiNo('<?php echo $datos; ?>')">
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
