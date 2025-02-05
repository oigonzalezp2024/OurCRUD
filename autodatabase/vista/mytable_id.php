<?php
include_once '../modelo/conexion.php';
$conn = conexion();
$id = $_GET['id'];
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Clientes</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<?php
	include('librerias.php');
	?>
	<script src="../controlador/funciones_mytables.js"></script>
</head>

<body id="body">
	<?php
	include 'header_table.php';
	?>
	<div class="container">
		<div id="tabla"></div>
	</div>
	<!-- MODAL PARA INSERTAR REGISTROS -->
	<div class="modal fade" id="modalNuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">Agregar cliente</h4>
				</div>
				<div class="modal-body">
					<label hidden="">id_table</label>
					<input hidden="" id="id_table" >
					<label>Table name:</label>
					<input type="text" name="table__name" id="table__name" class="form-control input-sm" required="">
					<label>Database:</label>

					<select name="mydatabase_id" id="mydatabase_id" class="form-control input-sm" disabled>
						<?php
						$sql = "SELECT * FROM mydatabases WHERE id_mydatabase = $id";
						$result = mysqli_query($conn, $sql);
						while ($fila = mysqli_fetch_assoc($result))
						{
							$id_mydatabase = $fila['id_mydatabase'];
							$table__name = $fila['database__name'];
						?>
							<option value="<?php echo $id_mydatabase; ?>"><?php echo $table__name; ?></option>
						<?php
						}
						?>
					</select>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal" id="guardarnuevo">
						Add
					</button>
				</div>
			</div>
		</div>
	</div>
	<!-- MODAL PARA EDICION DE DATOS-->
	<div class="modal fade" id="modalEdicion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">Actualizar datos</h4>
				</div>
				<div class="modal-body">
					<input type="number" hidden="" id="id_tableu">
					<label>table__name</label>
					<input type="text" name="table__nameu" id="table__nameu" class="form-control input-sm" required="">
					<label>Database:</label>
					<select name="mydatabase_idu" id="mydatabase_idu" class="form-control input-sm" required="">
						<?php
						$sql = 'SELECT * FROM mydatabases';
						$result = mysqli_query($conn, $sql);
						while ($fila = mysqli_fetch_assoc($result))
						{
							$id_mydatabase = $fila['id_mydatabase'];
							$table__name = $fila['database__name'];
						?>
							<option value="<?php echo $id_mydatabase; ?>"><?php echo $table__name; ?></option>
						<?php
						}
						?>
					</select>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn" data-dismiss="modal" id="actualizadatos">
						Update
					</button>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#tabla').load('componentes/vista_mytable_id.php?id=<?php echo $id; ?>');
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#guardarnuevo').click(function() {
				id_table = $('#id_table').val();
				table__name = $('#table__name').val();
				mydatabase_id = $('#mydatabase_id').val();
				agregardatos(id_table, table__name, mydatabase_id);
			});
			$('#actualizadatos').click(function() {
				modificarCliente();
			});
		});
	</script>
	<?php
	include './footer.php';
	?>
</body>

</html>