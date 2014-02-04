<?php
require_once( 'tablas.php' );
require_once( 'db_util.php' );

function listar_estado()
{
	global $t_estado;
	try
	{
		$rs = doQuery( getSelect( $t_estado ) );
		return array( 'estados' => $rs);
	}
	catch ( PDOException $ex )
	{
		show_app_error( $ex );
		die();
	}
}

function guardar_estado( $datos )
{
	global $t_estado;
	if ( isset( $datos['id'] ) and strlen( $datos['id'] ) != 0 )
	{
		return doUpdate( $t_estado, $datos );
	}
	return doInsert( $t_estado, $datos );
}

function borrar_estado( $datos ) 
{
	global $t_estado;
	if ( isset( $datos['id'] ) and strlen( $datos['id'] ) != 0 )
	{
		return doDelete( $t_estado, $datos );
	}
	return array('resultado' => false, 'error' => 'No se puede eliminar el estado');
}

function get_estado( $id )
{
	global $t_estado;
	return doQueryById( $t_estado, array( 'id' => $id ) );
}
?>