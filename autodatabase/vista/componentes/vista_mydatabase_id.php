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
    <h2 style="text-align:center; margin-top:100px;">My databases</h2>
    <button class="btn navbar-left"
        data-toggle="modal"
        data-target="#modalNuevo">
        <span class="glyphicon glyphicon-plus"></span>
    </button>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th></th>
                    <th>id</th>
                    <th>database name</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM mydatabases WHERE id_mydatabase = $id";
                $result = mysqli_query($conn, $sql);
                while ($fila = mysqli_fetch_assoc($result)) {
                    $datos = $fila['id_mydatabase'] . "||" .
                        $fila['database__name'];
                ?>
                    <tr>
                        <td style="text-align:right;">
                            <a class="btn" href="mytables_database_id.php?id=<?php echo $fila['id_mydatabase']; ?>">
                                <i class="btn glyphicon glyphicon-eye-open"></i>
                            </a>
                            <button class="btn glyphicon glyphicon-pencil"
                                data-toggle="modal"
                                data-target="#modalEdicion"
                                onclick="agregaform('<?php echo $datos; ?>')">
                            </button>
                            <button class="btn glyphicon glyphicon-remove"
                                onclick="preguntarSiNo('<?php echo $fila['id_mydatabase']; ?>')">
                            </button>
                        </td>
                        <td><?php echo $fila['id_mydatabase']; ?></td>
                        <td><?php echo $fila['database__name']; ?></td>
                        <td>
                            <button class="btn glyphicon glyphicon-pencil"
                                data-toggle="modal"
                                data-target="#modalEdicion"
                                onclick="agregaform('<?php echo $datos; ?>')">
                            </button>
                            <button class="btn glyphicon glyphicon-remove"
                                onclick="preguntarSiNo('<?php echo $fila['id_mydatabase']; ?>')">
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
