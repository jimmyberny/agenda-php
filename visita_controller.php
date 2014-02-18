<?php 
require_once( 'catalogo.php' );
require_once( 'dao_visita.php' );
require_once( 'constantes.php' );

header('Content-Type: json');
if ( is_guardar() )
{
	// Siempre tiene que llegar por post: accion
	// accion: guardar
	echo json_encode( guardar_visita( $_POST ) );
}
else if ( is_filtrar() )
{
	// Siempre llegara por GET
	// en este caso inyectar el estado... mappear
	$_GET['estado'] = PENDIENTE;
	echo json_encode( listar_visita($_GET) );
}
else
{
	echo json_encode( array('resultado' => false, 'error' => 'Llamada incorrecta') );
}

?>