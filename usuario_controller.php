<?php
require_once( 'catalogo.php' );
require_once( 'dao_basico.php' );

header('Content-Type: json');

if ( is_lista() ) 
{
	echo json_encode( listar_usuario() );
}
else if ( is_guardar() )
{
	echo json_encode( guardar_usuario( $_POST ) );
}
else if ( is_borrar() ) 
{
	echo json_encode( borrar_usuario( $_POST ) );
}
else if ( is_item() )
{
	echo json_encode( get_usuario( get_item_id() ) );
}

?>