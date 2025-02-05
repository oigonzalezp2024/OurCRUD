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
	<script src="../controlador/funciones_myfields.js"></script>
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
					<h4 class="modal-title" id="myModalLabel">Add field</h4>
				</div>
				<div class="modal-body">
					<label>table</label>
					<select name="table_id" id="table_id" class="form-control input-sm" disabled>
						<?php
						$sql = "SELECT
							myt.id_table as id_table,
							myt.table__name as table__name,
							myt.mydatabase_id as mydatabase_id,
							mdb.database__name as database__name
							FROM mytables as myt,
							mydatabases as mdb
							WHERE mdb.id_mydatabase = myt.mydatabase_id
							AND myt.id_table = $id";
						$result = mysqli_query($conn, $sql);
						while ($fila = mysqli_fetch_assoc($result)) {
							$datos = $fila['id_table'] . "||" .
								$fila['table__name'] . "||" .
								$fila['mydatabase_id'];
						?>
							<option value="<?php echo $fila['id_table']; ?>"><?php echo  $fila['mydatabase_id'] . " - " . $fila['table__name']; ?></option>
						<?php
						}
						?>
					</select>
					<label hidden="">id_field</label>
					<input hidden="" id="id_field">
					<label>field name</label>
					<input type="text" name="field_name" id="field_name" class="form-control input-sm" required="">
					<label>Field type:</label>
					<select name="field_type_id" id="field_type_id" class="form-control input-sm" required="">
						<?php
						$sql = 'SELECT * FROM field_types';
						$result = mysqli_query($conn, $sql);
						while ($fila = mysqli_fetch_assoc($result)) {
							$id_field_type = $fila['id_field_type'];
							$field_type = $fila['field_type'];
						?>
							<option value="<?php echo $id_field_type; ?>"><?php echo $field_type; ?></option>
						<?php
						}
						?>
					</select>
					<label>Field size:</label>
					<select name="field_size_id" id="field_size_id" class="form-control input-sm" required="">
						<?php
						$sql = 'SELECT * FROM field_sizes';
						$result = mysqli_query($conn, $sql);
						while ($fila = mysqli_fetch_assoc($result)) {
							$id_field_size = $fila['id_field_size'];
							$field_size = $fila['field_size'];
						?>
							<option value="<?php echo $id_field_size; ?>"><?php echo $field_size; ?></option>
						<?php
						}
						?>
					</select>
					<label>field_position</label>
					<input type="number" id="field_position" class="form-control input-sm" required="">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal" id="guardarnuevo">
						Agregar
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
					<h4 class="modal-title" id="myModalLabel">Update field</h4>
				</div>
				<div class="modal-body">
					<label>table</label>
					<select name="table_idu" id="table_idu" class="form-control input-sm" disabled>
						<?php
						$sql = "SELECT
							myt.id_table as id_table,
							myt.table__name as table__name,
							myt.mydatabase_id as mydatabase_id,
							mdb.database__name as database__name
							FROM mytables as myt,
							mydatabases as mdb
							WHERE mdb.id_mydatabase = myt.mydatabase_id
							AND myt.id_table = $id";
						$result = mysqli_query($conn, $sql);
						while ($fila = mysqli_fetch_assoc($result)) {
							$datos = $fila['id_table'] . "||" .
								$fila['table__name'] . "||" .
								$fila['mydatabase_id'];
						?>
							<option value="<?php echo $fila['id_table']; ?>"><?php echo  $fila['mydatabase_id'] . " - " . $fila['table__name']; ?></option>
						<?php
						}
						?>
					</select>
					<input type="number" hidden="" id="id_fieldu">
					<label>field name</label>
					<textarea id="field_nameu" rows="4" cols="50" class="form-control input-sm" required=""></textarea>
					<label>Field type:</label>
					<select name="field_type_idu" id="field_type_idu" class="form-control input-sm" required="">
						<?php
						$sql = 'SELECT * FROM field_types';
						$result = mysqli_query($conn, $sql);
						while ($fila = mysqli_fetch_assoc($result)) {
							$id_field_type = $fila['id_field_type'];
							$field_type = $fila['field_type'];
						?>
							<option value="<?php echo $id_field_type; ?>"><?php echo $field_type; ?></option>
						<?php
						}
						?>
					</select>
					<label>Field size:</label>
					<select name="field_size_idu" id="field_size_idu" class="form-control input-sm" required="">
						<?php
						$sql = 'SELECT * FROM field_sizes';
						$result = mysqli_query($conn, $sql);
						while ($fila = mysqli_fetch_assoc($result)) {
							$id_field_size = $fila['id_field_size'];
							$field_size = $fila['field_size'];
						?>
							<option value="<?php echo $id_field_size; ?>"><?php echo $field_size; ?></option>
						<?php
						}
						?>
					</select>
					<label>Field index:</label>
					<select name="field_index_idu" id="field_index_idu" class="form-control input-sm" required="">
						<option value="1">N/A</option>
						<option value="2">INDEX</option>
						<option value="3">PRIMARY KEY</option>
					</select>
					<label>field_position</label>
					<input type="number" id="field_positionu" class="form-control input-sm" required="">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn" data-dismiss="modal" id="actualizadatos">
						Actualizar
					</button>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#tabla').load('componentes/vista_myfields_table_id.php?id=<?php echo $id; ?>');
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#guardarnuevo').click(function() {
				id_field = $('#id_field').val();
				field_name = $('#field_name').val();
				field_type_id = $('#field_type_id').val();
				field_size_id = $('#field_size_id').val();
				field_position = $('#field_position').val();
				table_id = $('#table_id').val();
				agregardatos(id_field, field_name, field_type_id, field_size_id, field_position, table_id);
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