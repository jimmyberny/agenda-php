<?php
require_once( 'catalogo.php' );
require_once( 'dao_cliente.php' );

header('Content-Type: json');

if ( is_lista() ) 
{
	echo json_encode( listar_cliente() );
}
else if ( is_guardar() )
{
	echo json_encode( guardar_cliente( $_POST ) );
}
else if ( is_borrar() ) 
{
	echo json_encode( borrar_cliente( $_POST ) );
}
else if ( is_item() )
{
	echo json_encode( get_cliente( get_item_id() ) );
}
else if ( is_buscar() )
{
	echo json_encode( listar_cliente_by( $_GET ) );
}

?>