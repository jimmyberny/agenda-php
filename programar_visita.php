<?php 
require_once( 'admin.php' );
?>
<!doctype html>
<html lang="es">
	<head>
		<?php include 'basic_css.php' ?>
		<title>Programación de visitas</title>

		<script id="options-estado-tmpl" type="text/template">
			<option value="" label="Filtrar por estado" default selected >
				Filtrar por estado
			</option>
			{{#estados}}
			<option value="{{id}}" label="{{nombre}}" >
				{{nombre}}
			</option>
			{{/estados}}
		</script>

		<script id="options-municipio-tmpl" type="text/template">
			<option value="" label="Filtrar por municipio" default selected >
				Filtrar por municipio
			</option>
			{{#municipios}}
			<option value="{{id}}" label="{{nombre}}" >
				{{nombre}}
			</option>
			{{/municipios}}
		</script>

		<script id="options-localidad-tmpl" type="text/template">
			<option value="" label="Filtrar por localidad" default selected >
				Filtrar por localidad
			</option>
			{{#localidades}}
			<option value="{{id}}" label="{{nombre}}" >
				{{nombre}}
			</option>
			{{/localidades}}
		</script>

		<script id="options-supervisor-tmpl" type="text/template">
			<option value="" label="Elegir supervisor" default selected >
				Elegir supervisor
			</option>
			{{#supervisores}}
			<option value="{{id}}" label="{{nombre}}" >
				{{nombre}}
			</option>
			{{/supervisores}}
		</script>

		<script id="tabla-clientes-tmpl" type="text/template">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Razón social</th>
						<th>Cliente</th>
						<th></th>
					<tr>
				</thead>
				<tbody>
					{{#clientes}}
					<tr>
						<td>{{razon_social}}</td>
						<td>{{cliente}}</td>
						<td><button class="btn btn-small btn-primary" onclick="agendarVisita('{{id}}', '{{cliente}}')">
						Agendar visita
						</button></td>
					</tr>
					{{/clientes}}
					{{^clientes}}
					<tr><td colspan="3" >No se encontraron clientes.</td></tr>
					{{/clientes}}
				</tbody>
			</table>
		</script>
	</head>
	<body>
		<!-- Empieza el encabezado -->
		<?php include 'header.php' ?>
		<!-- Termina el encabezado -->

		<div class="container">
			<h1>Programación de visitas</h1>
			<div class="row">
				<div class="col-md-3">
					<div class="panel panel-default">
						<div class="panel-heading" > 
							<h3 class="panel-title">Buscar cliente</h3>
						</div>
						<div class="panel-body" >
							<form id="frm-filtro">
								<!-- Datos ocultos -->
								<input id="accion" name="accion" type="hidden" value="filtrar" />
								<!-- Datos visibles -->
								<div class="form-group">
									<label for="cliente">Por nombre</label>
									<input id="cliente" name="cliente" type="text" placeholder="Cliente" class="form-control" />
								</div>
								<div class="form-group">
									<label for="razon_social">Por razón social</label>
									<input id="razon_social" name="razon_social" type="text" placeholder="Razón social" class="form-control" />
								</div>
								<div class="form-group">
									<label for="id_estado">Por estado</label>
									<select id="id_estado" name="id_estado" placeholder="Estado" class="form-control">
									</select>
								</div>
								<div class="form-group">
									<label for="id_municipio">Por municipio</label>
									<select id="id_municipio" name="id_municipio" class="form-control">
									</select>
								</div>
								<div class="form-group">
									<label for="id_localidad">Por localidad</label>
									<select id="id_localidad" name="id_localidad" class="form-control">
									</select>
								</div>
							</form>
							<div >
									<button id="btn-limpiar"class="btn btn-default" type="reset" form="frm-filtro">
										Limpiar
									</button>
									<button id="btn-buscar" class="btn btn-primary" type="button" >
										Buscar
									</button>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-9">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Clientes</h3>
						</div>
						<div id="contenido" class="panel-body">
							<div id="tabla-clientes" >
								<!-- Aqui van los clientes encontrados -->
							</div>
							<div id="form-visita" style="display: none" >
								<form id="frm-visita">
									<!-- Campos ocultos -->
									<input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $_SESSION['usuario']['id']; ?>" />
									<input type="hidden" id="id_cliente" name="id_cliente" value="" />
									<input type="hidden" id="accion" name="accion" value="guardar" />
									<!-- Campos visibles -->
									<div class="row">
										<div class="form-group col-md-8">
											<label for="usuario" class="control-label">Usuario</label>
											<input id="usuario" name="usuario" type="text" class="form-control" 
												disabled value="<?php echo $_SESSION['usuario']['nombre']; ?>" />
										</div>
										<div class="form-group col-md-4">
											<label for="fecha" class="control-label">Fecha</label>
											<!-- cargarla con js -->
											<input id="fecha" name="fecha" type="text" disabled class="form-control" />
										</div>
									</div>
									<div class="row">
										<div class="form-group col-md-8">
											<label for="id_supervisor" class="control-label">Supervisor</label>
											<select id="id_supervisor" name="id_supervisor" class="form-control">
											</select>
										</div>
										<div class="form-group col-md-4">
											<label for="fecha_programada" class="control-label">Fecha programada</label>
											<div class="input-group date" id="dtp_fecha_programada">
												<input id="fecha_programada" name="fecha_programada" 
													data-format="YYYY-MM-DD HH:mm:ss" type="text" class="form-control" 
													required />
												<span class="input-group-addon">
													<span class="glyphicon glyphicon-calendar" />
												</span>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label for="a_cliente" class="control-label">Cliente</label>
										<input id="a_cliente" name="a_cliente" type="text" class="form-control" disabled />
									</div>
									<div class="form-group">
										<label for="asunto" class="control-label">Asunto</label>
										<input id="asunto" name="asunto" type="text" class="form-control"/>
									</div>
								</form>
							</div>
						</div>
						<div id="controles" class="panel-footer" style="display: none">
							<div class="btn-group">
								<button id="boton-cancelar" class="btn btn-default" type="reset" form="frm-visita" >
									<span class="glyphicon glyphicon-refresh"></span> Limpiar
								</button>
							</div>
							<div class="btn-group pull-right">
								<button class="btn btn-default" type="button" onclick="guardar()">
									<span class="glyphicon glyphicon-floppy-disk"></span> Guardar
								</button>
								<button class="btn btn-default" type="button" onclick="cancelar()">
									<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
								</button>
							</div>
						</div>
					</div>
					<!-- Mensajes -->
					<div id="mensajes">
					</div>
				</div>
			</div>
		</div>

		<!-- Empieza el pie -->
		<?php include 'footer.php' ?>
		<!-- Terminal el pie -->
		<!-- Empieza javascript -->
		<?php include 'basic_js.php' ?>
		<script type="text/javascript">
			$(document).ready(function() {
				// Añadir datepicker
				var test = moment().format('YYYY-MM-DD');
				console.log('Fecha: ' + test);
				$('#dtp_fecha_programada').datetimepicker({
					startDate: test,
					defaultDate: moment()
				});

				$('#id_estado').bind('change', function() {
						cargarSelect('id_municipio', 'id_estado', this.value);
					});

				// Llenar el combo de estados
				cargarSelect('id_estado', null, null);

				// Agregar la funcion al combo box
				$('#id_municipio').bind('change', function() {
						cargarSelect('id_localidad', 'id_municipio', this.value);
					});

				// Filtrar resultados bind
				$('#btn-buscar').bind('click', function() {
					var params = $('#frm-filtro').serializeArray();
					$.get('cliente_controller.php',
						params,
						function(json){
							if (json.resultado) {
								$('#tabla-clientes').html(Mustache.to_html($('#tabla-clientes-tmpl').html(), json));
							} else {
								uxErrorAlert(json.error);
							}
						});
				});

			});

			function cargarSelect(tipo, campo, valor, callback) {
				params = {};
				params['accion'] = campo == null ? 'lista' : 'buscar';
				
				if (campo != null) {
					params[campo] = valor;
				}
				$.getJSON(tipo.substring(3) + '_controller.php',
					params,
					function(json) {
						$('#' + tipo).html(Mustache.to_html($('#options-' + tipo.substring(3) + '-tmpl').html(), json));
						if (callback != null) callback.call();
					});
			}

			function agendarVisita(id, cliente) {
				$('#tabla-clientes').hide();
				
				// Set values
				$('#id_cliente').val(id);
				$('#a_cliente').val(cliente);
				$.getJSON('supervisor_controller.php',
					{accion: 'lista'},
					function(json) {
						$('#id_supervisor').html(Mustache.to_html($('#options-supervisor-tmpl').html() , json));
					});

				// Mostrar form
				$('#form-visita').show();
				$('#controles').show();

				// Poner la fecha de ahora
				console.log(moment().format());
				$('#fecha').val(moment().format("DD-MM-YYYY"));
			}

			function cancelar() {
				$('#form-visita').hide();	
				$('#controles').hide();

				$('#tabla-clientes').show();
			}

			function guardar() {
				// no tengo que inyectar la accion, ya va en el form
				var params = $('#frm-visita').serializeArray();
				
				$.post('visita_controller.php',
					params,
					function(json) {
						if ( json.resultado ) {
							$('#frm-visita')[0].reset();
							uxSuccessAlert('Visita agendada correctamente');
						} else {
							uxErrorAlert('No se pudo agendar la visita, intente nuevamente.' + json.error);
						}
					});
			}

		</script>
		<!-- Termina javascript -->
	</body>
</html>