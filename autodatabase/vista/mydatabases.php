<?php
include_once '../modelo/conexion.php';
$conn = conexion();
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
	<script src="../controlador/funciones_mydatabases.js"></script>
</head>

<body id="body">
	<?php
	include 'header.php';
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
					<h4 class="modal-title" id="myModalLabel">Create database:</h4>
				</div>
				<div class="modal-body">
					<label hidden="">id_mydatabase</label>
					<input hidden="" id="id_mydatabase">
					<label>Database name:</label>
					<input type="text" name="table__name" id="table__name" class="form-control input-sm" required="">
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
					<h4 class="modal-title" id="myModalLabel">Update database:</h4>
				</div>
				<div class="modal-body">
					<input type="number" hidden="" id="id_mydatabaseu">
					<label>Database name:</label>
					<input type="text" name="database__nameu" id="database__nameu" class="form-control input-sm" required="">
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
			$('#tabla').load('componentes/vista_mydatabases.php');
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#guardarnuevo').click(function() {
				id_mydatabase = $('#id_mydatabase').val();
				table__name = $('#table__name').val();
				agregardatos(id_mydatabase, table__name);
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