<!DOCTYPE html>
<html>
    <head>
	<meta charset="UTF-8">
	<title>Clientes</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<?php
	include('librerias.php');
	?>
	<script src="../controlador/funciones_clientes.js"></script>
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
			<h4 class="modal-title" id="myModalLabel">Agregar cliente</h4>
		    </div>
		    <div class="modal-body">
			<label>id_cliente</label>
			<input type="number" id="id_cliente" class="form-control input-sm" required="">
			<label>nombre</label>
			<textarea id="nombre" rows="4" cols="50"class="form-control input-sm" required=""></textarea>
			<label>apellido</label>
			<textarea id="apellido" rows="4" cols="50"class="form-control input-sm" required=""></textarea>
			<label>direccion</label>
			<textarea id="direccion" rows="4" cols="50"class="form-control input-sm" required=""></textarea>
			<label>celular</label>
			<input type="number" id="celular" class="form-control input-sm" required="">
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
			<h4 class="modal-title" id="myModalLabel">Actualizar datos</h4>
		    </div>
		    <div class="modal-body">
			<input type="number" hidden="" id="id_clienteu">
			<label>nombre</label>
			<textarea id="nombreu" rows="4" cols="50" class="form-control input-sm" required=""></textarea>
			<label>apellido</label>
			<textarea id="apellidou" rows="4" cols="50" class="form-control input-sm" required=""></textarea>
			<label>direccion</label>
			<textarea id="direccionu" rows="4" cols="50" class="form-control input-sm" required=""></textarea>
			<label>celular</label>
			<input type="number" id="celularu" class="form-control input-sm" required="">
			</div>
		    <div class="modal-footer">
			<button type="button" class="btn btn-warning" data-dismiss="modal" id="actualizadatos">
			    Actualizar
			</button>
		    </div>
		</div>
	    </div>
	</div>
	<script type="text/javascript">
	    $(document).ready(function () {
		$('#tabla').load('componentes/vista_clientes.php');
	    });
	</script>
	<script type="text/javascript">
	    $(document).ready(function () {
		$('#guardarnuevo').click(function () {
		    id_cliente = $('#id_cliente').val();
		    nombre = $('#nombre').val();
		    apellido = $('#apellido').val();
		    direccion = $('#direccion').val();
		    celular = $('#celular').val();
		    agregardatos(id_cliente, nombre, apellido, direccion, celular);
		});
		$('#actualizadatos').click(function () {
		    modificarCliente();
		});
	    });
	</script>
	<?php
	include './footer.php';
	?>
    </body>
</html>
