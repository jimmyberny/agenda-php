<?php 
require_once( 'admin.php' );
$usr = $_SESSION['usuario'];
$nom = sprintf( '%s', $usr['nombre']);
?>
<script type="text/javascript">
	function salir(){
		$.post('login.php',
			{accion: 'logout'},
			function(json) {
				if (json.resultado) {
					document.location = 'index.php';
				} else {
					alert('No se puede cerrar la sesión');
				}
			});
	}
</script>
<div id="dlg-salir" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4>¿Desea salir de la aplicación?</h4>
			</div>
			<!-- <div class="modal-body">
				<p><strong>El ticket actual se perderá</strong></p>
			</div> -->
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span> Cancelar</button>
				<button type="button" class="btn btn-primary" onclick="salir()"><span class="glyphicon glyphicon-log-out"></span> Salir</button>
			</div>
		</div>
	</div>
</div>
<div class="navbar navbar-fixed-top navbar-inverse">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
          	</button>
			<a class="navbar-brand" href="#">Agenda</a>
		</div>
		<div class="navbar-collapse collapse">
			<?php include 'menu.php' ?>
			<ul class="nav navbar-nav pull-right">
				<li><a href="#"><span class="glyphicon glyphicon-user"></span> <?php echo $nom; ?></a></li>
				<li><a data-toggle="modal" data-target="#dlg-salir"><span class="glyphicon glyphicon-off"></span></a></li>
			</ul>
		</div>
	</div>
</div>