<?php
require_once( 'catalogo.php' );
require_once( 'dao_basico.php' );

header('Content-Type: json');

if ( is_lista() ) 
{
	echo json_encode( listar_rango() );
}
else if ( is_guardar() )
{
	echo json_encode( guardar_rango( $_POST ) );
}
else if ( is_borrar() ) 
{
	echo json_encode( borrar_rango( $_POST ) );
}
else if ( is_item() )
{
	echo json_encode( get_rango( get_item_id() ) );
}

?>