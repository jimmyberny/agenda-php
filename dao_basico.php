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

/* Usuarios */
function listar_usuario()
{
	global $t_usuario;
	try
	{
		$rs = doQuery( getSelect( $t_usuario ) );
		return array( 'usuarios' => $rs );
	}
	catch ( PDOException $ex )
	{
		show_app_error( $ex );
		die();
	}
}

function guardar_usuario( $datos )
{
	global $t_usuario;
	if ( isset( $datos['id'] ) and strlen( $datos['id'] ) != 0 )
	{
		return doUpdate( $t_usuario, $datos );
	}
	return doInsert( $t_usuario, $datos );
}

function borrar_usuario( $datos ) 
{
	global $t_usuario;
	if ( isset( $datos['id'] ) and strlen( $datos['id'] ) != 0 )
	{
		return doDelete( $t_usuario, $datos );
	}
	return array('resultado' => false, 'error' => 'No se puede eliminar el usuario');
}

function get_usuario( $id )
{
	global $t_usuario;
	return doQueryById( $t_usuario, array( 'id' => $id ) );
}

/* Municipios */
function listar_municipio_by( $datos )
{
	global $t_municipio;
	try
	{
		$res = doQueryTo( $t_municipio, array('id_estado'), $datos );
		if ( $res['resultado'] )
		{
			return array( 'resultado' => true, 'municipios' => $res['items'] );
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

function listar_municipio()
{
	global $t_municipio;
	try
	{
		$rs = doQuery( getSelect( $t_municipio ) );
		return array( 'municipios' => $rs );
	}
	catch ( PDOException $ex )
	{
		show_app_error( $ex );
		die();
	}
}

function guardar_municipio( $datos )
{
	global $t_municipio;
	if ( isset( $datos['id'] ) and strlen( $datos['id'] ) != 0 )
	{
		return doUpdate( $t_municipio, $datos );
	}
	return doInsert( $t_municipio, $datos );
}

function borrar_municipio( $datos ) 
{
	global $t_municipio;
	if ( isset( $datos['id'] ) and strlen( $datos['id'] ) != 0 )
	{
		return doDelete( $t_municipio, $datos );
	}
	return array('resultado' => false, 'error' => 'No se puede eliminar el municipio');
}

function get_municipio( $id )
{
	global $t_municipio;
	return doQueryById( $t_municipio, array( 'id' => $id ) );
}

/* localidades */
function listar_localidad_by( $datos )
{
	global $t_localidad;
	try
	{
		$res = doQueryTo( $t_localidad, array('id_municipio'), $datos );
		if ( $res['resultado'] ) 
		{
			return array( 'resultado' => true, 'localidades' => $res['items'] );
		}
		else
		{
			return $res; // la consulta con el error
		}
	}
	catch (PDOException $x) 
	{
		show_app_error( $ex );
		die();
	}
}

function listar_localidad()
{
	global $t_localidad;
	try
	{
		$rs = doQuery( getSelect( $t_localidad ) );
		return array( 'localidades' => $rs );
	}
	catch ( PDOException $ex )
	{
		show_app_error( $ex );
		die();
	}
}

function guardar_localidad( $datos )
{
	global $t_localidad;
	if ( isset( $datos['id'] ) and strlen( $datos['id'] ) != 0 )
	{
		return doUpdate( $t_localidad, $datos );
	}
	return doInsert( $t_localidad, $datos );
}

function borrar_localidad( $datos ) 
{
	global $t_localidad;
	if ( isset( $datos['id'] ) and strlen( $datos['id'] ) != 0 )
	{
		return doDelete( $t_localidad, $datos );
	}
	return array('resultado' => false, 'error' => 'No se puede eliminar la localidad');
}

function get_localidad( $id )
{
	global $t_localidad;
	return doQueryById( $t_localidad, array( 'id' => $id ) );
}

/* Supervisores */
function listar_supervisor()
{
	global $t_supervisor;
	try
	{
		$rs = doQuery( getSelect( $t_supervisor ) );
		return array( 'supervisores' => $rs);
	}
	catch ( PDOException $ex )
	{
		show_app_error( $ex );
		die();
	}
}

function guardar_supervisor( $datos )
{
	global $t_supervisor;
	if ( isset( $datos['id'] ) and strlen( $datos['id'] ) != 0 )
	{
		return doUpdate( $t_supervisor, $datos );
	}
	return doInsert( $t_supervisor, $datos );
}

function borrar_supervisor( $datos ) 
{
	global $t_supervisor;
	if ( isset( $datos['id'] ) and strlen( $datos['id'] ) != 0 )
	{
		return doDelete( $t_supervisor, $datos );
	}
	return array('resultado' => false, 'error' => 'No se puede eliminar el supervisor');
}

function get_supervisor( $id )
{
	global $t_supervisor;
	return doQueryById( $t_supervisor, array( 'id' => $id ) );
}

/* Rangos de venta */
function listar_rango()
{
	global $t_rango;
	try
	{
		$rs = doQuery( getSelect( $t_rango ) );
		return array( 'rangos' => $rs);
	}
	catch ( PDOException $ex )
	{
		show_app_error( $ex );
		die();
	}
}

function guardar_rango( $datos )
{
	global $t_rango;
	if ( isset( $datos['id'] ) and strlen( $datos['id'] ) != 0 )
	{
		return doUpdate( $t_rango, $datos );
	}
	return doInsert( $t_rango, $datos );
}

function borrar_rango( $datos ) 
{
	global $t_rango;
	if ( isset( $datos['id'] ) and strlen( $datos['id'] ) != 0 )
	{
		return doDelete( $t_rango, $datos );
	}
	return array('resultado' => false, 'error' => 'No se puede eliminar el rango');
}

function get_rango( $id )
{
	global $t_rango;
	return doQueryById( $t_rango, array( 'id' => $id ) );
}

/* Giros de negocio */
function listar_giro()
{
	global $t_giro;
	try
	{
		$rs = doQuery( getSelect( $t_giro ) );
		return array( 'giros' => $rs);
	}
	catch ( PDOException $ex )
	{
		show_app_error( $ex );
		die();
	}
}

function guardar_giro( $datos )
{
	global $t_giro;
	if ( isset( $datos['id'] ) and strlen( $datos['id'] ) != 0 )
	{
		return doUpdate( $t_giro, $datos );
	}
	return doInsert( $t_giro, $datos );
}

function borrar_giro( $datos ) 
{
	global $t_giro;
	if ( isset( $datos['id'] ) and strlen( $datos['id'] ) != 0 )
	{
		return doDelete( $t_giro, $datos );
	}
	return array('resultado' => false, 'error' => 'No se puede eliminar el giro');
}

function get_giro( $id )
{
	global $t_giro;
	return doQueryById( $t_giro, array( 'id' => $id ) );
}
/* Notas */
function listar_nota()
{
	global $t_nota;
	try
	{
		$rs = doQuery( getSelect( $t_nota ) );
		return array( 'notas' => $rs);
	}
	catch ( PDOException $ex )
	{
		show_app_error( $ex );
		die();
	}
}

function guardar_nota( $datos )
{
	global $t_nota;
	if ( isset( $datos['id'] ) and strlen( $datos['id'] ) != 0 )
	{
		return doUpdate( $t_nota, $datos );
	}
	return doInsert( $t_nota, $datos );
}

function borrar_nota( $datos ) 
{
	global $t_nota;
	if ( isset( $datos['id'] ) and strlen( $datos['id'] ) != 0 )
	{
		return doDelete( $t_nota, $datos );
	}
	return array('resultado' => false, 'error' => 'No se puede eliminar la nota');
}

function get_nota( $id )
{
	global $t_nota;
	return doQueryById( $t_nota, array( 'id' => $id ) );
}

/* Configuracion de la aplicacion */
function get_configuracion( $id )
{
	global $t_configuracion;
	return doQueryById( $t_configuracion, array( 'id' => $id ) );
}

function guardar_configuracion( $datos )
{
	global $t_configuracion;
	$res = doUpdate( $t_configuracion, $datos );
	if ( !$res['resultado'] ) 
	{
		// no se actualizo con exito,
		// intentar insertar
		$res = doInsert( $t_configuracion, $datos );
	}
	return $res;
}
?>