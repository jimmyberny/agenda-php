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
						<td>{{id}}</td>
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
									<select id="id_municipio" name="id_municipio" placeholder="Municipio" class="form-control">
									</select>
								</div>
								<div class="form-group">
									<label for="id_localidad">Por localidad</label>
									<select id="id_localidad" name="id_localidad" placeholder="Localidad" class="form-control">
									</select>
								</div>
							</form>
							<div >
									<button id="btn-limpiar"class="btn btn-default" type="button" >
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
						<div id="tabla-clientes" class="panel-body">
							<!-- Aqui van los clientes encontrados -->
						</div>
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
				$('#id_estado').bind('change', function() {
						cargarSelect('id_municipio', 'id_estado', this.value);
					});

				// Llenar el combo de estados
				cargarSelect('id_estado', null, null);

				// Agregar la funcion al combo box
				$('#id_municipio').bind('change', function() {
						cargarSelect('id_localidad', 'id_municipio', this.value);
					});

				// Resetear el formulario
				$('#btn-limpiar').bind('click', function() {
					$('#frm-filtro')[0].reset();
				});

				// Filtrar resultados
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


		</script>
		<!-- Termina javascript -->
	</body>
</html>