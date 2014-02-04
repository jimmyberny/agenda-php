<?php
require_once( '../catalogo.php' );
require_once( '../dao_basico.php' );

header('Content-Type: json');

if ( is_lista() ) 
{
	echo json_encode( listar_estado() );
}
else if ( is_guardar() )
{
	echo json_encode( guardar_estado( $_POST ) );
}
else if ( is_borrar() ) 
{
	echo json_encode( borrar_estado( $_POST ) );
}
else if ( is_item() )
{
	echo json_encode( get_estado( get_item_id() ) );
}

?>