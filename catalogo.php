<?php
require_once( 'app_util.php' );

function get_action() 
{
	return isset( $_GET['accion'] ) ? $_GET['accion'] : 
		( isset( $_POST['accion'] ) ? $_POST['accion'] : null ) ;
}

function compare_action( $accion )
{
	return strcasecmp( $accion, get_action() ) == 0;
}

function is_lista()
{
	return compare_action( 'lista' );
}

function is_buscar()
{
	return compare_action( 'buscar' );
}

function is_guardar() 
{
	return compare_action( 'guardar' );
}

function is_borrar()
{
	return compare_action( 'eliminar' );
}

function is_item()
{
	return compare_action( 'item' );
}

function is_filtrar() 
{
	return compare_action( 'filtrar' );
}

function get_item_id( $key = 'id', $array = array() )
{
	if ( count($array) == 0 )
	{
		if ( isset( $_GET[ $key ] ) )
		{
			$array = $_GET;
		}
		else
		{
			$array = $_POST;
		}

	}
	return $array[ $key ];
}
?>