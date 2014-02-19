<?php 
require_once( 'admin.php' );
?>
<!doctype html>
<html lang="es">
	<head>
		<?php include 'basic_css.php' ?>
		<title>Reportar visita</title>

		<script id="options-nota-tmpl" type="text/template">
			<option value="" label="Seleccionar nota" selected >
				Seleccionar nota
			</option>
			{{#notas}}
			<option value="{{id}}" label="{{nombre}}" >
			{{nombre}}
			</option>
			{{/notas}}
		</script>

		<script id="options-supervisor-tmpl" type="text/template">
			<option value="" label="Seleccionar supervisor" default selected >
				Elegir supervisor
			</option>
			{{#supervisores}}
			<option value="{{id}}" label="{{nombre}}" >
				{{nombre}}
			</option>
			{{/supervisores}}
		</script>
	</head>
	<body>
		<!-- Empieza el encabezado -->
		<?php include 'header.php' ?>
		<!-- Termina el encabezado -->

		<div class="container">
			<h1>Reportar visita</h1>
			<div class="row">
				<div class="col-md-9">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Reporte</h3>
						</div>
						<div class="panel-body">
							<form id="frm-reporte">
								<!-- hidden fields -->
								<input id="id_visita" name="id_visita" type="hidden" value="" />
								<input id="accion" name="accion" type="hidden" value="guardar" />
								<!-- visible fields -->
								<div class="row">
									<div class="form-group col-md-8">
										<label for="supervisor_programado" class="control-label">Supervisor programado</label>
										<input id="supervisor_programado" name="supervisor_programado" type="text" class="form-control" disabled value="" />
									</div>
									<div class="form-group col-md-4">
										<label for="fecha_programada" class="control-label">Fecha programada</label>
										<!-- cargarla con js -->
										<input id="fecha_programada" name="fecha_programada" type="text" class="form-control" disabled />
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-8">
										<label for="id_supervisor" class="control-label">Supervisor</label>
										<select id="id_supervisor" name="id_supervisor" class="form-control">
										</select>
									</div>
									<div class="form-group col-md-4">
										<label for="fecha" class="control-label">Fecha</label>
										<div class="input-group date" id="dtp_fecha_programada">
											<input id="fecha" name="fecha" 
												data-format="YYYY-MM-DD HH:mm:ss" type="text" class="form-control" required />
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-calendar" />
											</span>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-6">
										<label for="cliente" class="control-label">Cliente</label>
										<input id="cliente" name="cliente" type="text" class="form-control" disabled value="" />
									</div>
									<div class="form-group col-md-6">
										<label for="contacto" class="control-label">Contacto</label>
										<!-- cargarla con js -->
										<input id="contacto" name="contacto" type="text" class="form-control" disabled />
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-8">
										<label for="asunto" class="control-label">Asunto</label>
										<input id="asunto" name="asunto" type="text" class="form-control" disabled />
									</div>
									<div class="form-group col-md-4">
										<label for="id_nota" class="control-label">Nota</label>
										<select id="id_nota" name="id_nota" class="form-control">
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="observaciones" class="control-label">Observaciones</label>
									<textarea id="observaciones" name="observaciones" class="form-control" rows="3"></textarea>
								</div>
							</form>
						</div> <!-- termina panel-body -->
						<div id="controles" class="panel-footer" >
							<div class="btn-group">
								<button id="boton-cancelar" class="btn btn-default" type="reset" form="frm-reporte" >
									<span class="glyphicon glyphicon-refresh"></span> Limpiar
								</button>
							</div>
							<div class="btn-group pull-right">
								<button id="btn-guardar" class="btn btn-primary" type="button" onclick="guardar()">
									<span class="glyphicon glyphicon-floppy-disk"></span> Guardar
								</button>
							</div>
						</div> <!-- termina panel-footer -->
					</div> <!-- terminal panel -->
				</div> <!-- termina col-md-9-->
				<div class="col-md-3">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Tareas</h3>
						</div>
					</div>
					<!-- Mensajes -->
					<div id="mensajes" class="app-mensajes">
					</div>
				</div>
			</div> <!-- termina row -->
		</div> <!-- termina container -->
		<!-- Empieza el pie -->
		<?php include 'footer.php' ?>
		<!-- Terminal el pie -->
		<!-- Empieza javascript -->
		<?php include 'basic_js.php' ?>
		<script type="text/javascript">
			$(document).ready(function() {
				// Añadir datepicker
				$('#dtp_fecha_programada').datetimepicker();

				// Vamos a escribir el id, desde aqui
				// Para cuando se termine de descargar el documento, ya puede ir
				// con un get por la información
				var id_visita = '<?php echo $_GET[ 'id_visita' ] ?>';
				$('#id_visita').val(id_visita); // put on form

				$.getJSON('supervisor_controller.php',
					{accion: 'lista'},
					function(json) {
						$('#id_supervisor').html(Mustache.to_html($('#options-supervisor-tmpl').html(), json));
					});

				$.getJSON('nota_controller.php',
					{accion: 'lista'},
					function(json) {
						$('#id_nota').html(Mustache.to_html($('#options-nota-tmpl').html(), json));
					});

				$.getJSON('visita_controller.php',
					{accion: 'item', id: id_visita},
					function(json) {
						if (json.resultado) {
							$('#supervisor_programado').val(json.item.supervisor);
							$('#fecha_programada').val(json.item.fecha_programada);
							$('#cliente').val(json.item.cliente);
							$('#contacto').val(json.item.contacto);
							$('#asunto').val(json.item.asunto);
							$('#id_supervisor').val(json.item.id_supervisor);
						} else {
							uxErrorAlert(json.error);
						}
					});
			});

			function guardar() {
				var params = $('#frm-reporte').serializeArray();
				$.post('reporte_controller.php',
					params,
					function(json) {
						if (json.resultado) {
							// 
							$('#btn-guardar').attr('disabled', true);
							uxSuccessAlert('Reporte guardado correctamente');
						} else {
							uxErrorAlert('No se pudo guardar el reporte. Error: ' + json.error);
						}
					});
			}
		</script>
	</body>
</html>