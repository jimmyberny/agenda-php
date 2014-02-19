<?php 
require_once( 'tablas.php' );
require_once( 'sql_util.php' );
require_once( 'db_util.php' );
require_once( 'constantes.php' );

function guardar_reporte( $datos )
{
	// no importa, dado que no tengo la imagen u_u
	// global $t_reporte;
	global $con;

	try
	{
		session_start();
		$datos['id'] = uniqid('rep');
		$datos['id_usuario'] = $_SESSION['usuario']['id'];

		$qis = 'insert into reporte(id, id_visita, id_supervisor, id_usuario, fecha, id_nota, observaciones) values '.
			' (:id, :id_visita, :id_supervisor, :id_usuario, :fecha, :id_nota, :observaciones)';
		$fs = array('id', 'id_visita', 'id_supervisor', 'id_usuario', 'fecha', 'id_nota', 'observaciones');

		// guardar el reporte
		$psi = $con->prepare( $qis );
		foreach ( $fs as $f ) 
		{
			$psi->bindParam( ':' . $f, $datos[ $f ] );
		}
		$ok = $psi->execute();
		$ok = $ok and ( $psi->rowCount() != 0 );
		
		// cambiar el estado de la visita
		$qu = 'update visita set estado = :estado where id = :id';
		$psu = $con->prepare( $qu );
		// Set params
		$estado = REALIZADA; // El ejemplo de los problemas estructurales de php
		$psu->bindParam( ':estado', $estado );
		$psu->bindParam( ':id', $datos[ 'id_visita' ] );
		// Ejecutar
		$ok = $ok and ( $psu->execute() );
		
		// Solo por curiosidad
		$upds = $psu->rowCount();
		error_log( 'Visitas actualizadas ' . $upds );
		$res = array( 'resultado' => true );
	}
	catch ( PDOException $ex )
	{
		$res = array( 'resultado' => false, 'error' => $ex->getMessage() );
	}
	return $res;
}
?>