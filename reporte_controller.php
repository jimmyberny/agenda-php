<?php
// El controlador de reportes 
require_once( 'catalogo.php' );
require_once( 'dao_reporte.php' );
require_once( 'constantes.php' );

header('Content-Type: json');
if ( is_guardar() )
{
	echo json_encode( guardar_reporte( $_POST ) );
}
else
{
	echo json_encode( array( 'resultado' => false, 'error' => 'Llamada incorrecta' ) );
}

?>