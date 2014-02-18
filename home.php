<?php 
require_once( 'admin.php' );
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<?php include 'basic_css.php' ?>
		<title>Bienvenido</title>

		<script id="visitas-tmpl" type="text/template">
			<ul class="list-group">
				{{#visitas}}
				<li class="list-group-item list-group-item-info">
					<div class="row">
						<div class="col-md-11">
							<div class="row">
								<div class="col-md-2 label-visita">
									Supervisor:
								</div>
								<div class="col-md-4 info-visita">
									{{supervisor}}
								</div>
								<div class="col-md-2 label-visita">
									Fecha:
								</div>
								<div class="col-md-4 info-visita">
									{{fecha_programada}}
								</div>
							</div>
							<div class="row">
								<div class="col-md-2 label-visita">
									Visitar a:
								</div>
								<div class="col-md-4 info-visita">
									{{cliente}}
								</div>
								<div class="col-md-2 label-visita">
									Contacto:
								</div>
								<div class="col-md-4 info-visita">
									{{contacto}}
								</div>
							</div>
							<div class="row">
								<div class="col-md-2 label-visita">
									Domicilio
								</div>
								<div class="col-md-10 info-visita">
									{{calle}}, {{exterior}}, {{interior}}. {{localidad}}, {{municipio}}, {{estado}}
								</div>
							</div>
							<div class="row">
								<div class="col-md-8 col-md-offset-4 label-visita">
									Agendado por: <strong>{{usuario}}</strong> en {{fecha}}
								</div>
							</div>
						</div>
						<div class="col-md-1" style="border-left: 1px solid black">
							<a href="programa_visita.php">
								<span class="glyphicon glyphicon-ok-circle"></span>
							</a>
						</div>
					</div>
				</li>
				{{/visitas}}
			</ul>
		</script>
	</head>
	<body>
		<!-- Empieza el encabezado -->
		<?php include 'header.php' ?>
		<!-- Termina el encabezado -->
		<!-- Empieza el contenido de la página -->
		<div class="container">
			<!-- Aqui va a ir el contenido -->
			<h1>Agenda SIEM</h1>
			<div class="row">
				<div class="col-md-9">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs">
					  <li class="active">
						<a href="#visitas-hoy" data-toggle="tab">
							Visita para hoy <span id="no-visitas-hoy" class="badge"></span> </a>
					</li>
					  <li>
						<a href="#visitas-semana" data-toggle="tab">
							Visitas para la semana <span id="no-visitas-semana" class="badge"></span> </a>
					</li>
					  <li>
						<a href="#visitas-mes" data-toggle="tab">
							Visitas para el mes <span id="no-visitas-mes" class="badge"></span> </a>
					</li>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content">
					  <div class="tab-pane active" id="visitas-hoy"></div>
					  <div class="tab-pane" id="visitas-semana">dame</div>
					  <div class="tab-pane" id="visitas-mes">una</div>
					</div>
					<!-- Mensajes -->
					<div id="mensajes">
					</div>
				</div>
				<div class="col-md-3">
					<div class="panel panel-default">
						<div class="panel-heading">
							Acciones
						</div>
						<div class="panel-body">
							<a href="programar_visita.php">Programar visita</a>
						</div>
					</div>
				</div>
			</div>

		</div>
		<!-- Termina el contenido -->
		<!-- Empieza el pie -->
		<?php include 'footer.php' ?>
		<!-- Terminal el pie -->
		<!-- Empieza javascript -->
		<?php include 'basic_js.php' ?>

		<script type="text/javascript">
			$(document).ready(function(){
				// Obtener  el limite del dia de hoy
				var hoy = moment().endOf('d');
				console.log(hoy.format('YYYY-MM-DD hh:mm:ss'));
				var semana = moment().endOf('w');
				console.log(semana.format('YYYY-MM-DD hh:mm:ss'));
				var mes = moment().endOf('M');
				console.log(mes.format('YYYY-MM-DD hh:mm:ss'));

				// Do calls
				filtrarVisitas(hoy, 'visitas-hoy');
				filtrarVisitas(semana, 'visitas-semana');
				filtrarVisitas(mes, 'visitas-mes');
			});

			function filtrarVisitas(momento, panel) {
				// Do calls
				$.getJSON('visita_controller.php', 
					{accion: 'filtrar', fecha: momento.format('YYYY-MM-DD hh:mm:ss')},
					function(json) {
						if (json.resultado) {
							$('#' + panel).html(Mustache.to_html($('#visitas-tmpl').html() , json));
							$('#no-' + panel).html( json.visitas.length);
						} else {
							uxErrorAlert(json.error);
						}
					});
			}

			function trimFecha(fecha) {
				fecha.seconds(0);
				fecha.minutes(0);
				fecha.hours(0);
				return fecha;
			}
		</script>
		<!-- Termina javascript -->
	</body>
</html>
