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
                $sql = 'SELECT * FROM mydatabases';
                $result = mysqli_query($conn, $sql);
                while ($fila = mysqli_fetch_assoc($result)) {
                    $datos = $fila['id_mydatabase'] . "||" .
                        $fila['database__name'];
                ?>
                    <tr>
                        <td>
                            <button class="btn btn-sm glyphicon glyphicon-pencil"
                                data-toggle="modal"
                                data-target="#modalEdicion"
                                onclick="agregaform('<?php echo $datos; ?>')">
                            </button>
                            <button class="btn btn-sm glyphicon glyphicon-remove"
                                onclick="preguntarSiNo('<?php echo $fila['id_mydatabase']; ?>')">
                            </button>
                        </td>
                        <td><?php echo $fila['id_mydatabase']; ?></td>
                        <td><?php echo $fila['database__name']; ?></td>
                        <td style="text-align:right;">
                            <a class="btn btn-sm" href="mytables_database_id.php?id=<?php echo $fila['id_mydatabase']; ?>"><i class="glyphicon glyphicon-eye-open"></i></a>
                            <button class="btn btn-sm"
                                onclick="crearBaseDeDatos('<?php echo $fila['id_mydatabase']; ?>')">Create <i class="glyphicon glyphicon-play"></i>
                            </button>
                            <a class="btn btn-sm" href="/phpmyadmin/index.php?route=/database/designer&db=<?php echo $fila['database__name']; ?>" target="_blank">Designer</a>
                            <a class="btn btn-sm" href="../modelo/mydatabases_modelo.php?accion=descargar&database=<?php echo $fila['id_mydatabase']; ?>">SQL <i class="glyphicon glyphicon-download-alt"></i></a>
                            <form action="../laboratorio/crear_proyecto.php" style="display:inline-block">
                                <input hidden="" type="text" name="base" id="base" value="<?php echo $fila['database__name']; ?>">
                                <input style="display:inline-block" class="btn btn-sm" type="submit" value="Display">
                            </form>
                            <a class="btn btn-sm" href="../modelo/crear_zip.php?base=<?php echo $fila['database__name']; ?>">Proyect <i class="glyphicon glyphicon-download-alt"></i></a>
                            <form action="../labpdo/crear_proyecto.php" style="display:inline-block">
                                <input hidden="" type="text" name="base" id="base" value="<?php echo $fila['database__name']; ?>">
                                <input style="display:inline-block" class="btn btn-sm" type="submit" value="Display PDO">
                            </form>
                            <a class="btn btn-sm" href="../modelo/crear_zip.php?base=<?php echo $fila['database__name']; ?>_pdo">Proyect PDO<i class="glyphicon glyphicon-download-alt"></i></a>
                        </td>
                        <td>
                            <button class="btn btn-sm glyphicon glyphicon-pencil"
                                data-toggle="modal"
                                data-target="#modalEdicion"
                                onclick="agregaform('<?php echo $datos; ?>')">
                            </button>
                            <button class="btn btn-sm glyphicon glyphicon-remove"
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
