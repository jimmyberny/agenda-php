<?php
// Session start
require_once( 'dao_aplicacion.php' );

// Utils
require_once( 'util.php' );

// siempre se llegará por post
// Para entrar como para salir
$accion = $_POST['accion'];
error_log( $accion );
// 'login' y 'logout'
if ( match('login', $accion) )
{
	$res = login( $_POST['usuario'], $_POST['contrasena'] );
	if ( $res['resultado'] )
	{
		session_start();
		$_SESSION['sid'] = uniqid();
		$_SESSION['usuario'] = $res['usuario'];
		// Login exitoso
	}
}
else if ( match('logout', $accion) )
{
	// Logout
	session_start();
	error_log('Cerrando sesion');
	session_destroy();
	$res = array('resultado' => true);
}
else
{
	$res = array( 'resultado' => false );
}

header( 'Content-Type: json' );
echo json_encode( $res )
?>