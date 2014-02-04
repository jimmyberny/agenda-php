<?php 
require_once( 'tablas.php' );
require_once( 'db_util.php' );

function login( $usr, $pass )
{
	global $con;
	try
	{
		$query = 'select id, nombre, usuario, contrasena '
			.'from usuario where usuario = :usuario and contrasena = :contrasena ';
		$ps = $con->prepare( $query );
		$ps->bindParam( ':usuario', $usr );
		$ps->bindParam( ':contrasena', $pass );
		$ps->execute();
		$res = $ps->fetch( PDO::FETCH_ASSOC );

		if ( is_bool( $res ) or ( is_array( $res )  and count( $res ) == 0 ) )
		{
			$ans = array( 'resultado' => false, 
				'mensaje' => 'Usuario no encontrado');
		}
		else
		{
			$ans = array('resultado' => true, 'usuario' => $res );
		}
	}
	catch ( PDOException $ex )
	{
		$ans = array( 'resultado' => false, 'mensaje' => $ex->getMessage() );
	}
	return $ans;
}

?>