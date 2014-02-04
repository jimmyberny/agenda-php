<?php 
require_once( 'admin.php' );
?>
<!doctype html>
<html lang="es">
	<head>
		<?php include 'basic_css.php' ?>
		<title>Gestión de localidades</title>

		<script id="lista-items-tmpl" type="text/template">
			<div class="list-group">
			{{#localidades}}
				<a id="item-link-{{id}}" href="#" class="list-group-item" onclick="mostrarItem('{{id}}')">{{nombre}}</a>
			{{/localidades}}
			</div>
		</script>

		<script id="options-municipio-tmpl" type="text/template">
			{{#municipios}}
            <option value="{{id}}" label="{{nombre}}" />
            {{/municipios}}
		</script>
	</head>
	<body>
		<!-- Empieza el encabezado -->
		<?php include 'header.php' ?>
		<!-- Termina el encabezado -->

		<div class="container">
			<h1>Gestión de localidades</h1>
			<!-- Nuevo/Editar usuario -->
			<div class="row">
				<div class="col-md-3">
					<div class="panel panel-default" >
						<div class="panel-heading">
							<button class="btn btn-default" type="button" onclick="cargarLista()"><span class="glyphicon glyphicon-refresh"></span></button> Lista de localidades
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
									<label for="municipio" class="col-lg-3 control-label">Municipio</label>
									<div class="col-lg-9">
										<select id="municipio" name="municipio" class="form-control">
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="nombre" class="col-lg-3 control-label">Nombre</label>
									<div class="col-lg-9">
										<input id="nombre" name="nombre" type="text" class="form-control" required />
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
			var control = 'localidad_controller.php';
			// Accion de la pantalla, ninguna por defecto
			var gblAccion = 'guardar';
			var selId = null;

			$(document).ready(function() {
				// Actualizar la lista de estados
				cargarLista();

				// La lista de estados
				$.getJSON('municipio_controller.php',
					{accion: 'lista'},
					function(json) {
						$('#municipio').html(Mustache.to_html($('#options-municipio-tmpl').html(), json));
					});
			});

			

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
								uxSuccessAlert('Localidad eliminada correctamente');
							} else {
								uxErrorAlert('No se pudo eliminar la localidad. ' + json.error );
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
								uxSuccessAlert('La localidad se ha guardado correctamente');
							} else {
								// Mostrar error
								uxErrorAlert('No se pudo guardar la localidad');
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
							$('#municipio').val(json.item.id_municipio);
							$('#nombre').val(json.item.nombre);
							$('#municipio').focus();

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
							uxErrorAlert('No se encontro la localidad');
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