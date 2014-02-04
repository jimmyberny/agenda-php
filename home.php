<?php 
require_once( 'admin.php' );
?>
<!DOCTYPE html>
<html lang="es">
    <head>
    	<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<!-- <link rel="shortcut icon" href=""> -->
        <link rel="stylesheet" href="res/css/bootstrap.css">
        <link rel="stylesheet" href="res/css/bootstrap-theme.css">
        <link rel="stylesheet" href="res/css/agenda.css">
    </head>
    <body>
    	<!-- Empieza el encabezado -->
    	<?php include 'header.php' ?>
		<!-- Termina el encabezado -->
		<!-- Empieza el contenido de la página -->
    	<div class="container">
            <!-- Aqui va a ir el contenido -->
            <h1>Agenda SIEM</h1>
            En un panel con tabs, mostrar los siguientes aspectos.
            <form>
                <button type="button" class="btn">Programar visita</button>
                <button type="button" class="btn">Últimas visitas</button>
                <button type="button" class="btn">Visitas próximas</button>
            </form>
    	</div>
    	<!-- Termina el contenido -->
    	<!-- Empieza el pie -->
    	<?php include 'footer.php' ?>
    	<!-- Terminal el pie -->
    	<!-- Empieza javascript -->
    	<script src="res/js/jquery-1.10.2.js"></script>
        <script src="res/js/bootstrap.js"></script>
    	<!-- Termina javascript -->
    </body>
</html>
