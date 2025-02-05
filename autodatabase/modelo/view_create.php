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
    <h2 style="text-align:center; margin-top:100px;">citas</h2>
    <button class="btn navbar-left"
        data-toggle="modal"
        data-target="#modalNuevo">
        <span class="glyphicon">+</span>
    </button>
    <div class="table-responsive">
        <table class="table table-hover ">
            <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = 'SELECT
                    citas.id_cita AS id_cita,
                    citas.cliente_id AS cliente_id,
                    citas.vendedor_id AS vendedor_id,
                    clientes.nombre AS cliente_nombre,
                    clientes.apellido AS cliente_apellido,
                    clientes.direccion AS cliente_direccion,
                    clientes.celular AS cliente_celular,
                    vendedores.nombre AS vendedor_nombre,
                    vendedores.apellido AS vendedor_apellido,
                    vendedores.direccion AS vendedor_direccion,
                    vendedores.celular AS vendedor_celular
                    FROM citas, clientes, vendedores
                    WHERE clientes.id_cliente = citas.cliente_id
                    AND vendedores.id_vendedor = citas.vendedor_id';
                $result = mysqli_query($conn, $sql);
                while ($fila = mysqli_fetch_assoc($result)) {
                    $datos = $fila['id_cita'] . "||" .
                        $fila['cliente_id'] . "||" .
                        $fila['vendedor_id'];
                ?>
                    <tr>
                        <td>
                            <button style="margin-bottom:5px;" class="btn glyphicon glyphicon-pencil"
                                data-toggle="modal"
                                data-target="#modalEdicion"
                                onclick="agregaform('<?php echo $datos; ?>')">.
                            </button><br>
                            <button style="margin-bottom:5px;" class="btn glyphicon glyphicon-remove"
                                onclick="preguntarSiNo('<?php echo $fila['id_cita']; ?>')">.
                            </button>
                        </td>
                        <td>
                            <?php echo $fila['id_cita']; ?>
                        </td>
                        <td>
                            <table>
                                <caption style="text-align:center; background-color:#000000;"><b>CLIENTE:</b></caption>
                                <tr>
                                    <td><b>nombre:</b></td>
                                    <td style="text-align:right; min-width:150px"><?php echo $fila['cliente_nombre']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>apellido:</b></td>
                                    <td style="text-align:right;"><?php echo $fila['cliente_apellido']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>dirección:</b></td>
                                    <td style="text-align:right;"><?php echo $fila['cliente_direccion']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>celular:</b></td>
                                    <td style="text-align:right;"><?php echo $fila['cliente_celular']; ?></td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table>
                                <caption style="text-align:center; background-color:#000000;"><b>VENDEDOR:</b></caption>
                                <tr>
                                    <td><b>nombre:</b></td>
                                    <td style="text-align:right;"><?php echo $fila['vendedor_nombre']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>apellido:</b></td>
                                    <td style="text-align:right;"><?php echo $fila['vendedor_apellido']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>dirección:</b></td>
                                    <td style="text-align:right;"><?php echo $fila['vendedor_direccion']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>celular:</b></td>
                                    <td style="text-align:right;"><?php echo $fila['vendedor_celular']; ?></td>
                                </tr>
                            </table>
                        <td>
                        <td>
                            <table>
                                <caption style="text-align:center; background-color:#000000;"><b>VENDEDOR:</b></caption>
                                <tr>
                                    <td><b>nombre:</b></td>
                                    <td style="text-align:right;"><?php echo $fila['vendedor_nombre']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>apellido:</b></td>
                                    <td style="text-align:right;"><?php echo $fila['vendedor_apellido']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>dirección:</b></td>
                                    <td style="text-align:right;"><?php echo $fila['vendedor_direccion']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>celular:</b></td>
                                    <td style="text-align:right;"><?php echo $fila['vendedor_celular']; ?></td>
                                </tr>
                            </table>
                        <td>
                        <td>
                            <table>
                                <caption style="text-align:center; background-color:#000000;"><b>VENDEDOR:</b></caption>
                                <tr>
                                    <td><b>nombre:</b></td>
                                    <td style="text-align:right;"><?php echo $fila['vendedor_nombre']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>apellido:</b></td>
                                    <td style="text-align:right;"><?php echo $fila['vendedor_apellido']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>dirección:</b></td>
                                    <td style="text-align:right;"><?php echo $fila['vendedor_direccion']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>celular:</b></td>
                                    <td style="text-align:right;"><?php echo $fila['vendedor_celular']; ?></td>
                                </tr>
                            </table>
                        <td>
                            <button style="margin-bottom:5px;" class="btn glyphicon glyphicon-pencil"
                                data-toggle="modal"
                                data-target="#modalEdicion"
                                onclick="agregaform('<?php echo $datos; ?>')">.
                            </button><br>
                            <button style="margin-bottom:5px;" class="btn glyphicon glyphicon-remove"
                                onclick="preguntarSiNo('<?php echo $fila['id_cita']; ?>')">.
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
