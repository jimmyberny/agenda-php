<?php
require_once( 'catalogo.php' );
require_once( 'util.php');
require_once( 'dao_basico.php' );

header('Content-Type: json');

$accion = get_action();


if ( match( 'obtener', $accion ) )
{
	echo json_encode( get_configuracion( 'siem' ) );
}
else if ( match('guardar', $accion) )
{
	$_POST['id'] = 'siem'; // sobrecargar el id de la configuracion
	echo json_encode( guardar_configuracion( ) );
} 
else 
{
	$res = array('resultado' => false,
		'error' => 'Petición incorrecta',
		'peticion' => $accion);
	echo json_encode( $res );
}

?>