<?php
require_once( 'catalogo.php' );
require_once( 'dao_basico.php' );

header('Content-Type: json');

if ( is_lista() ) 
{
	echo json_encode( listar_localidad() );
}
else if ( is_guardar() )
{
	echo json_encode( guardar_localidad( $_POST ) );
}
else if ( is_borrar() ) 
{
	echo json_encode( borrar_localidad( $_POST ) );
}
else if ( is_item() )
{
	echo json_encode( get_localidad( get_item_id() ) );
}

?>