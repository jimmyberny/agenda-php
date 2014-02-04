<!DOCTYPE html>
<html lang="es">
	<!-- Aqui esta el login -->
	<head>
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- <link rel="shortcut icon" href=""> -->
        <link rel="stylesheet" href="res/css/bootstrap.css">
        <link rel="stylesheet" href="res/css/bootstrap-theme.css">
        <link rel="stylesheet" href="res/css/agenda.css">

        <title>Bienvenido</title>
	</head>
	<body class="login">
		<div class="container">
			<h1>Bienvenido</h1>
			<form id="frm-login" class="login">
				<h2>Ingresar al sistema</h2>
				<input id="accion" name="accion" type="hidden" value="login" />
				<input id="usuario" name="usuario" type="text" class="form-control" placeholder="Usuario" />
				<input id="contrasena" name="contrasena" type="password" class="form-control" placeholder="Contraseña" />
				<button id="boton-login" class="btn btn-primary btn-block" type="button">Entrar</button>
				<div id="mensajes" >
				</div>
				<button id="btn-close" class="btn" type="button" onclick="cerrarSesion()">Cerrar</button>
			</form>
		</div>

		<!-- Empieza javascript -->
		<script src="res/js/jquery-1.10.2.js"></script>
        <script src="res/js/bootstrap.js"></script>
        <script src="res/js/mustache.js"></script>
        <script src="res/js/util.js"></script>
        <script type="text/javascript">
        	$(document).ready(function() {
	        	$('#boton-login').bind('click', function() {
	        		var params = $('#frm-login').serializeArray();

	        		$.post('login.php',
	        			params,
	        			function(json) {
	        				if (json.resultado) {
	        					document.location = 'home.php';
	        				} else {
	        					uxErrorAlert( json.mensaje );
	        				}
	        			});
	        	});
        	});

        	function cerrarSesion() {
        		$.post('login.php',
        			{accion: 'logout'});
        	}
        </script>
		<!-- Termina javascript -->
	</body>
</html>