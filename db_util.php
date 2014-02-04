<?php
# Gestion de la conexion
require_once( 'config.php' );

# Utilidades para construir las queries
require_once( 'sql_util.php' );

try 
{
    $con = new PDO( 'mysql:host=' . PATH . ';dbname=' . DATABASE, USER, PASSWORD, 
    array( PDO::ATTR_PERSISTENT => true ) );
} 
catch ( PDOException $ex ) 
{
    print "Error!: " . $ex->getMessage();
    die(); # Falló la aplicacion
}

# És inútil, ya veremos
function doQuery( $sentence ) 
{
    global $con;
    error_log('Trying query: ' . $sentence );
    try
    {
		$result_set = $con->query( $sentence );
		return $result_set->fetchAll( PDO::FETCH_ASSOC );
    }
    catch ( PDOException $ex )
    {
    	error_log( $ex->getMessage() );
    	return array();
    }
}

function doQueryOne( $sentence ) {
	$res = doQuery( $sentence );
	if ( count( $res ) != 0 )
	{
		return $res[0];
	}
	return null;
}

function doQueryById( $table, $data )
{
	global $con;
	try 
	{
		$pss = $con->prepare( getSelectByIds( $table ) );

		$bindings = getFNames( $table['fields'], $table['form'] );
		foreach ( $table['ids'] as $fn ) 
		{
			$pss->bindParam( ':' . $bindings[$fn], $data[$bindings[$fn]] );
		}
		$pss->execute();
		$item = $pss->fetch( PDO::FETCH_ASSOC );
		if ( is_array( $item ) )
		{
			$res = array('resultado' => true, 'item' => $item);
		} 
		else
		{
			$res = array('resultado' => false, 'error' => 'Objeto no encontrado');
		}
	}
	catch ( PDOException $ex )
	{
		$res = array('resultado' => false, 
			'error' => 'Error de base de datos: ' . $ex->getMessage());
	}
	//error_log( 'Resultado: '. $res );
	return $res;
}

function doInsert( $table, $data )
{
	global $con;

	# Obtener los nombres de los comodines
	$names = array();
	foreach ( $table['fields'] as $f ) 
	{
		if ( array_key_exists( $f, $table['form'] ) ) 
		{
			$names[] = $table['form'][$f];
		}
		else
		{
			$names[] = $f;
		}
	}

	# Enlazar los comodines con su valor real
	$data['id'] = uniqid( 'usr' );
	$qi = getInsert( $table );
	# error_log( 'Query for insert' . $qi );

	$psi = $con->prepare( getInsert( $table ) );
	foreach ( $names as $ph )
	{
		$psi->bindParam( ':' . $ph, $data[$ph] );
	}

	# Ejecutar la query
	try 
	{
		$ok = $psi->execute(); # Query ejecutada 
		$ok = $ok and ( $psi->rowCount() != 0 ); # Si hubo filas afectadas
		$res = array( 'resultado' => $ok );
	} 
	catch ( PDOException $ex )
	{
		$res = array( 'resultado' => false, 'error' => $ex->getMessage() );
	}
	return $res;
}

function doUpdate( $table, $data ) 
{
	global $con;

	# Obtener los nombres de los campos
	$names = getFNames( $table['fields'], $table['form'] );


	$uq = getUpdate( $table ); # Update query
	error_log( 'Update: ' . $uq );

	# Preparar y vincular la query
	$psu = $con->prepare( $uq );
	foreach ( $names as $fn ) 
	{
		$psu->bindParam( ':' . $fn, $data[$fn] );
	}

	# Ejecutar la query
	try 
	{
		$ok = $psu->execute();
		$ok = $ok and ( $psu->rowCount() != 0 ); # Si hubo filas afectadas
		$res = array('resultado' => $ok );
	}
	catch ( PDOException $ex )
	{
		$res = array( 'resultado' => false, 'error' => $ex->getMessage() );
	}
	return $res;
}

function doDelete( $table, $data )
{
	global $con; # La conexion a bd
	$name = getFNames( $table['fields'], $table['form'] );

	$dq = getDelete( $table );
	error_log('Query delete: ' . $dq);
	$psd = $con->prepare( $dq );
	# Encontrar las claves del arreglo para enlazarlos del $data a la query
	foreach ( $table['ids'] as $pos ) 
	{
		$field = $table['fields'][$pos];
		$form = array_key_exists( $field, $table['form'] ) ? $table['form'][$field] : $field;
		$psd->bindParam( ':' . $field, $data[$form] );
	}

	try 
	{
		$ok = $psd->execute();
		$ok = $ok and ( $psd->rowCount() != 0 );
		$res = array('resultado' => $ok);
	}
	catch ( PDOException $ex )
	{
		$res = array( 'resultado' => false, 'error' => $ex->getMessage() );
	}
	return $res;
}

?>