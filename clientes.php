<?php 
require_once( 'admin.php' );
?>
<!doctype html>
<html lang="es">
	<head>
		<?php include 'basic_css.php' ?>
		<title>Gestión de clientes</title>

		<script id="lista-items-tmpl" type="text/template">
			<div class="list-group">
			{{#clientes}}
				<a id="item-link-{{id}}" href="#" class="list-group-item" onclick="mostrarItem('{{id}}')">{{razon_social}}</a>
			{{/clientes}}
			</div>
		</script>

		<script id="options-estado-tmpl" type="text/template">
			<option value="" label="" selected />
			{{#estados}}
			<option value="{{id}}" label="{{nombre}}" />
			{{/estados}}
		</script>

		<script id="options-municipio-tmpl" type="text/template">
			<option value="" label="" selected />
			{{#municipios}}
			<option value="{{id}}" label="{{nombre}}" />
			{{/municipios}}
		</script>

		<script id="options-localidad-tmpl" type="text/template">
			<option value="" label="" selected />
			{{#localidades}}
			<option value="{{id}}" label="{{nombre}}" />
			{{/localidades}}
		</script>

		<script id="options-rango-tmpl" type="text/template">
			<option value="" label="" selected />
			{{#rangos}}
			<option value="{{id}}" label="{{nombre}}" />
			{{/rangos}}
		</script>

		<script id="options-giro-tmpl" type="text/template">
			<option value="" label="" selected />
			{{#giros}}
			<option value="{{id}}" label="{{nombre}}" />
			{{/giros}}
		</script>
	</head>
	<body>
		<!-- Empieza el encabezado -->
		<?php include 'header.php' ?>
		<!-- Termina el encabezado -->

		<div class="container">
			<h1>Gestión de clientes</h1>
			<div class="row">
				<div class="col-md-3">
					<div class="panel panel-default" >
						<div class="panel-heading">
							<button class="btn btn-default" type="button" onclick="cargarLista()">
								<span class="glyphicon glyphicon-refresh"></span>
							</button> Lista de clientes
						</div>
						<div id="lista-items" class="item-list" >
						</div>
					</div>
				</div>
				<div class="col-md-9">
					<div class="panel panel-default hidden-xs">
						<div class="panel-heading">
							<div class="btn-group">
								<button id="boton-recargar" class="btn btn-default" type="button" 
									onclick="recargarItem()"><span class="glyphicon glyphicon-refresh"></span> Recargar</button>
								<button class="btn btn-default" type="button" 
									onclick="nuevoItem()"><span class="glyphicon glyphicon-plus-sign"></span> Nuevo</button>
								<button class="btn btn-default" type="button"
									onclick="borrarItem()"><span class="glyphicon glyphicon-minus-sign"></span> Eliminar</button>
							</div>
							<div class="btn-group pull-right">
								<button class="btn btn-default" type="button" 
									onclick="guardarItem()"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
								<button class="btn btn-default" type="button"
									onclick="cancelar()"><span class="glyphicon glyphicon-ban-circle"></span> Cancelar</button>
							</div>
						</div>

						<!-- Comienza el formulario -->
						<div class="panel-body item-form">
							<form id="frm-item" class="form-horizontal" role="form">
								<!-- Campos no visibles -->
								<input id="id" name="id" type="hidden" class="form-control" /> 
								<!-- Campos editables -->
								<div class="form-group">
									<label for="razon_social" class="col-lg-3 control-label">Razón social</label>
									<div class="col-lg-9">
										<input id="razon_social" name="razon_social" type="text" class="form-control" required />
									</div>
								</div>
								<div class="form-group">
									<label for="cliente" class="col-lg-3 control-label">Cliente</label>
									<div class="col-lg-9">
										<input id="cliente" name="cliente" type="text" class="form-control" required />
									</div>
								</div>
								<!-- Los combos -->
								<div class="form-group">
									<label for="estado" class="col-lg-3 control-label">Estado</label>
									<div class="col-lg-3">
										<select id="estado" name="estado" class="form-control">
										</select>
									</div>
									<div class="col-lg-3">
										<select id="municipio" name="municipio" class="form-control">
										</select>
									</div>
									<div class="col-lg-3">
										<select id="localidad" name="localidad" class="form-control">
										</select>
									</div>
								</div>
								<!-- terminan un grupo de combos -->
								<div class="form-group">
									<label for="calle" class="col-lg-3 control-label">Calle</label>
									<div class="col-lg-9">
										<input id="calle" name="calle" type="text" class="form-control" required />
									</div>
								</div>
								<div class="form-group">
									<label for="num_int" class="col-lg-3 control-label">Número interior</label>
									<div class="col-lg-9">
										<input id="num_int" name="num_int" type="text" class="form-control" required />
									</div>
								</div>
								<div class="form-group">
									<label for="num_ext" class="col-lg-3 control-label">Número exterior</label>
									<div class="col-lg-9">
										<input id="num_ext" name="num_ext" type="text" class="form-control" required />
									</div>
								</div>
								<div class="form-group">
									<label for="telefono" class="col-lg-3 control-label">Teléfono</label>
									<div class="col-lg-9">
										<input id="telefono" name="telefono" type="text" class="form-control" required />
									</div>
								</div>
								<div class="form-group">
									<label for="fax" class="col-lg-3 control-label">Fax</label>
									<div class="col-lg-9">
										<input id="fax" name="fax" type="text" class="form-control" required />
									</div>
								</div>
								<div class="form-group">
									<label for="email" class="col-lg-3 control-label">Correo electronico</label>
									<div class="col-lg-9">
										<input id="email" name="email" type="text" class="form-control" required />
									</div>
								</div>
								<div class="form-group">
									<label for="fecha_inicio" class="col-lg-3 control-label">Fecha inicio</label>
									<div class="col-lg-9 input-group date" id="dtp_fecha_inicio">
										<input id="fecha_inicio" name="fecha_inicio" type="text" class="form-control" required />
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar" />
										</span>
									</div>
								</div>
								<div class="form-group">
									<label for="rango" class="col-lg-3 control-label">Rango de ventas</label>
									<div class="col-lg-9">
										<select id="rango" name="rango" class="form-control">
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="giro" class="col-lg-3 control-label">Giro comercial</label>
									<div class="col-lg-9">
										<select id="giro" name="giro" class="form-control">
										</select>
									</div>
								</div>
							</form>
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
			// Url del controlador
			var control = 'cliente_controller.php';
			// Accion de la pantalla, ninguna por defecto
			var gblAccion = 'guardar';
			var selId = null;

			$(document).ready(function() {
				// Añadir datepicker
				$('#dtp_fecha_inicio').datetimepicker();

				// Actualizar la lista de clientes
				cargarLista();

				// La lista de estados
				$('#estado').bind('change', function() {
						cargarSelect('municipio', 'id_estado', this.value);
					});
				cargarSelect('estado', null, null);

				$('#municipio').bind('change', function() {
						console.log('Cambio el municipio ' + this.value);
						cargarSelect('localidad', 'id_municipio', this.value);
					});

				cargarSelect('giro', null, null);
				cargarSelect('rango', null, null)
			});

			function cargarSelect(tipo, campo, valor, callback) {
				params = {};
				params['accion'] = campo == null ? 'lista' : 'buscar';
				if (campo != null) {
					params[campo] = valor;
				}
				$.getJSON( tipo + '_controller.php',
					params,
					function(json) {
						$('#' + tipo).html(Mustache.to_html($('#options-' + tipo + '-tmpl').html(), json));
						if (callback != null) callback.call();
					});
			}
			

			function guardarItem() {
				// Tiene que haber una accion definida
				if (gblAccion == null) {
					return; // Do nothing
				}

				if (gblAccion == 'eliminar') {
					$.post(control,
						{accion: 'eliminar', id: selId},
						function(json) {
							if (json.resultado) {
								cargarLista();
								uxSuccessAlert('Cliente eliminado correctamente');
							} else {
								uxErrorAlert('No se pudo eliminar el cliente. ' + json.error );
							}
						});
				} else { // Guardar o actualizar un item
					var params = $('#frm-item').serializeArray();
					params.push( {name: 'accion', value: gblAccion} );

					$.post(control, 
						params,
						function(json) {
							if ( json.resultado ) {
								clearForm();
								cargarLista();
								uxSuccessAlert('El cliente se ha guardado correctamente');
							} else {
								// Mostrar error
								uxErrorAlert('No se pudo guardar el cliente');
							}
						});
				}
			}

			function cargarLista() {
				$.getJSON(control, 
					{accion: 'lista'}, 
					function(json){
						$('#lista-items').html(Mustache.to_html($('#lista-items-tmpl').html(), json));
						nuevoItem();
					});
			}

			function mostrarItem(itemId) {
				$.getJSON(control, 
					{accion: 'item', id: itemId},
					function(json){
						if ( json.resultado ) {
							$('#id').val(json.item.id);
							$('#razon_social').val(json.item.razon_social);
							$('#cliente').val(json.item.cliente);
							$('#estado').val(json.item.estado);
							cargarSelect('municipio', 'id_estado', 
								json.item.estado, 
								function() {
									cargarSelect('localidad', 'id_municipio', 
										json.item.municipio, 
										function() {
											$('#localidad').val(json.item.id_localidad);
											console.log('Termina loc');
										});
									$('#municipio').val(json.item.municipio);
									console.log('Termina mun');
								});

							$('#municipio').val(json.item.id_municipio);
							$('#localidad').val(json.item.id_localidad);
							$('#calle').val(json.item.calle);
							$('#num_int').val(json.item.num_int);
							$('#num_ext').val(json.item.num_ext);
							$('#telefono').val(json.item.telefono);
							$('#fax').val(json.item.fax);
							$('#email').val(json.item.email);
							$('#fecha_inicio').val(json.item.fecha_inicio);
							$('#rango').val(json.item.id_rango);
							$('#giro').val(json.item.id_giro);

							$('#razon_social').focus();

							// Hacer seleccion visible
							$('a[class~=active]').removeClass('active');
							$('#item-link-' + itemId).addClass('active');

							// Accion global: Guardar el item
							gblAccion = 'guardar'; 
							selId = itemId; // Item en vista
						} else {
							// Mostrar error
							gblAccion = null; // No hay accion posible
							selId = null;
							uxErrorAlert('No se encontro el cliente');
						}
					});
			}

			function recargarItem() {
				if (selId != null && selId.length != 0 ){
					mostrarItem(selId);
				} else {
					console.log('No hay que recargar');
				}
			}

			function nuevoItem() {
				$('a[class~=active]').removeClass('active'); // Limpiar seleccion
				
				gblAccion = 'guardar'; // Configurar accion
				selId = null;
				clearForm(); // Limpiar el formulario
				enableForm(true); // Habilitar el formulario
			}

			function borrarItem() {
				if (selId != null) {
					gblAccion = 'eliminar'; 
					enableForm(false);
				} else {
					console.log('No existe selección');
				}
			}

			function cancelar() {
				gblAccion = 'guardar';
				enableForm(true); // 
			}            
		</script>
	</body>
</html>