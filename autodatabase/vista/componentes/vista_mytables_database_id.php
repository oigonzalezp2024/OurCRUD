<?php
include_once '../../modelo/conexion.php';
$conn = conexion();
$id = $_GET['id'];
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
        <h2 style="margin-top:100px;">My tables database id <?php echo $id; ?></h2>
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
                <th>database</th>
                <th>table name</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT
myt.id_table as id_table,
myt.table__name as table__name,
myt.mydatabase_id as mydatabase_id,
mdb.database__name as database__name
FROM mytables as myt,
mydatabases as mdb
WHERE mdb.id_mydatabase = myt.mydatabase_id
AND mdb.id_mydatabase = $id";
            $result = mysqli_query($conn, $sql);
            while ($fila = mysqli_fetch_assoc($result)) {
                $datos = $fila['id_table'] . "||" .
                    $fila['table__name'] . "||" .
                    $fila['mydatabase_id'];
            ?>
                <tr>
                    <td style="text-align:right;">
                        <a href="myfield_table_id.php?id=<?php echo $fila['id_table']; ?>"><i class="btn glyphicon glyphicon-eye-open"></i></a>
                        <button class="btn glyphicon glyphicon-pencil"
                            data-toggle="modal"
                            data-target="#modalEdicion"
                            onclick="agregaform('<?php echo $datos; ?>')">
                        </button>
                        <button class="btn glyphicon glyphicon-remove"
                            onclick="preguntarSiNo('<?php echo $datos; ?>')">
                        </button>
                    </td>
                    <td><?php echo $fila['id_table']; ?></td>
                    <td><?php echo $fila['database__name']; ?></td>
                    <td><?php echo $fila['table__name']; ?></td>
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
