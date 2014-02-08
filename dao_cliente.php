<?php
require_once( 'tablas.php' );
# Utilidades para construir las queries
require_once( 'sql_util.php' );
require_once( 'db_util.php' );

/* Clientes */
function listar_cliente_by( $datos )
{
	global $t_cliente;
	try
	{
		$res = doQueryTo( $t_cliente, array('razon_social'), $datos );
		if ( $res['resultado'] )
		{
			return array( 'resultado' => true, 'clientes' => $res['items'] );
		}
		else
		{
			return $res; // la consulta con el error
		}
	}
	catch ( PDOException $x ) 
	{
		show_app_error( $ex );
		die();
	}
}

function listar_cliente()
{
	global $t_cliente;
	try
	{
		$rs = doQuery( getSelect( $t_cliente ) );
		return array( 'clientes' => $rs );
	}
	catch ( PDOException $ex )
	{
		show_app_error( $ex );
		die();
	}
}

function guardar_cliente( $datos )
{
	global $t_cliente;
	if ( isset( $datos['id'] ) and strlen( $datos['id'] ) != 0 )
	{
		return doUpdate( $t_cliente, $datos );
	}
	return doInsert( $t_cliente, $datos );
}

function borrar_cliente( $datos ) 
{
	global $t_cliente;
	if ( isset( $datos['id'] ) and strlen( $datos['id'] ) != 0 )
	{
		return doDelete( $t_cliente, $datos );
	}
	return array('resultado' => false, 'error' => 'No se puede eliminar el cliente');
}

function get_cliente( $id )
{
	global $t_cliente;
	global $con;

	try
	{

		$query = getSelect( $t_cliente,
			array('id'),  // es búsqueda por id, solo le paso este unico elemento
			'c', // El alias
			'e.id as estado, m.id as municipio', 
			' join localidad as l on c.id_localidad = l.id '
			. 'join municipio as m on l.id_municipio = m.id '
			. 'join estado as e on m.id_estado = e.id');
		error_log( 'Custom query for cliente: ' . $query );
		
		$pss = $con->prepare( $query );
		// Es un solo binding, el id, lo hare manualmente
		$pss->bindParam( ':id', $id );
		$pss->execute();
		$rs = $pss->fetch( PDO::FETCH_ASSOC );
		if ( is_array( $rs ) )
		{
			$res = array( 'resultado' => true, 'item' => $rs );
		}
		else 
		{ // Si no es un arreglo, es un boolean que siempre es falso
			$res = array('resultado' => false, 'error' => 'Objeto no encontrado, en teoría.' );
		}
	}
	catch ( PDOException $ex )
	{
		$res = array( 'resultado' => false,
			'error' => 'Error al procesar la consulta: ' . $ex->getMessage() );
	}
	return $res;
}