<?php 
// Para guardar la visita, y otras cosas más
require_once( 'tablas.php' );
require_once( 'sql_util.php' );
require_once( 'db_util.php' );
require_once( 'constantes.php' );

function guardar_visita( $datos )
{
	global $t_visita;
	global $con;

	// El hecho de que funcione, no significa que esta bien
	session_start(); // Aparentemente aqui necesito este start... we hope works
	error_log( $_SESSION[ 'usuario' ][ 'id' ] );
	$datos[ 'id_usuario' ] = $_SESSION['usuario']['id']; // overriding usuario
	// id_cliente
	// id_supervisor
	error_log('id_supervisor: ' . $datos['id_supervisor'] );
	$datos[ 'fecha' ] = date("Y-m-d H:i:s"); // fecha, use now() // MySQL format
	// fecha_programada
	// asunto
	$datos[ 'estado' ] = PENDIENTE; // estado

	return doInsert( $t_visita, $datos );
}

function get_visita( $datos )
{
	global $con;
	try
	{
		$query = 'select v.id as id, v.id_usuario as id_usuario, v.id_cliente as id_cliente, '.
				'v.id_supervisor as id_supervisor, v.fecha as fecha, v.fecha_programada as fecha_programada, '.
				'v.asunto as asunto, v.estado as estado, u.nombre as usuario, c.razon_social as cliente, '.
				'c.cliente as contacto, c.telefono as telefono, c.calle as calle, '.
				'c.num_int as interior, c.num_ext as exterior, '.
				'l.nombre as localidad, m.nombre as municipio, e.nombre as estado, '.
				's.nombre as supervisor '. 
				'from visita as v join usuario as u on v.id_usuario = u.id '.
				'join cliente as c on v.id_cliente = c.id '.
				'join localidad as l on c.id_localidad = l.id '.
				'join municipio as m on l.id_municipio = m.id '.
				'join estado as e on m.id_estado = e.id '.
				'join supervisor as s on v.id_supervisor = s.id '.
				'where v.id = :id';

		$pss = $con->prepare( $query );
		$pss->bindParam(':id', $datos[ 'id' ]); // el estado de veracruz, omg!
		$pss->execute();
		$rs = $pss->fetch( PDO::FETCH_ASSOC );

		if ( is_array( $rs ) )
		{
			$res = array( 'resultado' => true, 'item' => $rs );
		}
		else 
		{ // Si no es un arreglo, es un boolean que siempre es falso
			$res = array('resultado' => false, 'error' => 'No se pudo encontrar la visita indicada.' );
		}
	}
	catch ( PDOException $ex )
	{
		$res = array( 'resultado' => false,
			'error' => 'Error al procesar la consulta: ' . $ex->getMessage() );
	}
	return $res;
}

function listar_visita( $datos )
{
	global $con;

	try 
	{
		// Los datos de la query, y los mostrables
		$query = 'select v.id as id, v.id_usuario as id_usuario, v.id_cliente as id_cliente, '.
			'v.id_supervisor as id_supervisor, v.fecha as fecha, v.fecha_programada as fecha_programada, '.
			'v.asunto as asunto, v.estado as estado, u.nombre as usuario, c.razon_social as cliente, '.
			'c.cliente as contacto, c.telefono as telefono, c.calle as calle, '.
			'c.num_int as interior, c.num_ext as exterior, '.
			'l.nombre as localidad, m.nombre as municipio, e.nombre as estado, '.
			's.nombre as supervisor '. 
			'from visita as v join usuario as u on v.id_usuario = u.id '.
			'join cliente as c on v.id_cliente = c.id '.
			'join localidad as l on c.id_localidad = l.id '.
			'join municipio as m on l.id_municipio = m.id '.
			'join estado as e on m.id_estado = e.id '.
			'join supervisor as s on v.id_supervisor = s.id '.
			'where v.fecha_programada < :limite and v.estado = :estado '.
			'order by v.fecha_programada';

		$pss = $con->prepare( $query );
		$pss->bindParam(':limite', $datos[ 'fecha' ]); // el estado de veracruz, omg!
		$pss->bindParam(':estado', $datos[ 'estado' ]); // el estado
		$pss->execute();
		$rs = $pss->fetchAll( PDO::FETCH_ASSOC );

		if ( is_array( $rs ) )
		{
			return array( 'resultado' => true, 'visitas' => $rs );
		}
		else
		{
			return array( 'resultado' => false, 'error' => 'La consulta no se pudo completar' );
		}
	}
	catch ( PDOException $ex )
	{
		show_app_error( $ex );
		die();
	}
}
?>