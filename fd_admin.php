<?php 
# Fuente de datos para usuarios
require_once( 'db_util.php' );

$tbl_usuario = array(
	'name' => 'usuario',
	'fields' => array('id', 'nombre', 'paterno', 'materno', 'usuario', 'contra', 'id_rol'),
	'form' => array(
		'usuario' => 'nusuario', 
		'contra' => 'contrasena',
		'id_rol' => 'rol'),
	'ids' => array(0),
	'order' => array(1, 2, 3)
	);

$t_rol = array(
		'name' => 'rol',
		'fields' => array('id', 'nombre', 'tipo', 'inicio'),
		'form' => array(), 
		'ids' => array(0),
		'order' => array(1)
	);

$tbl_categoria = array('name' =>'categoria' ,
		'fields' => array('id', 'nombre'),
		'form' => array(),
		'ids' => array(0),
		'order' => array(1)	
	 );

$tbl_producto=array('name'=>'producto' ,
		'fields'=>array('id','id_categoria','nombre','codigo','descripcion','existencia','minimo','venta','compra','iva'),
		'form' => array(
			'id_categoria'=>'categoria'),
		'ids' => array(0),
		'order' => array(2,3)
	);

$tbl_cliente=array('name'=>'cliente',
		'fields'=>array('id','rfc','nombre','paterno','materno','proveedor','calle','interior','exterior','colonia','ciudad','estado'),
		'form'=>array(),
		'ids'=>array(0),
		'order'=>array(1)
	);

# sayHi( 'pollo' );

# echo "Call method";
# echo json_encode( listarUsuario() );

function listarUsuarios()
{
	global $tbl_usuario;
	try 
	{
		$rs = doQuery( getSelect( $tbl_usuario ) );
		# var_dump( $rs );
		return array( 'usuarios' => $rs );
	} 
	catch ( PDOException $ex ) 
	{
		show_app_error( $ex );
		die();
	}
}

function guardarUsuario( $datos )
{
	global $tbl_usuario;
	if ( isset( $datos['id'] ) and strlen( $datos['id'] ) != 0 )
	{
		error_log('Must update object');
		return doUpdate( $tbl_usuario, $datos );
	}
	error_log('Insert object');
	return doInsert( $tbl_usuario, $datos );
}

function borrarUsuario( $datos )
{
	global $tbl_usuario;
	if ( isset( $datos['id'] ) and strlen( $datos['id'] ) != 0 )
	{
		return doDelete( $tbl_usuario, $datos );
	}
	return array('resultado' => false, 'error' => 'Identificador para usuario incorrecto.');
}

function getUsuario( $idUsuario ) 
{
	global $tbl_usuario;
	return doQueryById( $tbl_usuario, array('id' => $idUsuario) );
}

function listarRoles()
{
	global $t_rol;
	try {
		return array( 'roles' => doQuery( getSelect( $t_rol ) ) );
	}
	catch ( PDOException $ex )
	{
		return array( 'roles' => array(), 'error' => $ex->getMessage() );
	}
}

function guardarRol ( $data )
{
	global $t_rol;
	if ( isset( $data['id'] ) and strlen( $data['id'] ) != 0 )
	{
		return doUpdate( $t_rol, $data );
	}
	return doInsert( $t_rol, $data );
}

function borrarRol ( $data )
{
	global $t_rol;
	if ( isset( $data['id'] ) and strlen( $data['id'] ) != 0 )
	{
		return doDelete( $t_rol, $data );
	}
	return array('resultado' => false, 'error' => 'Identificador incorrecto' );
}

function getRol ( $id )
{
	global $t_rol;
	return doQueryById( $t_rol, array('id' => $id ) );
}

function listarCategoria(){
	global $tbl_categoria;
	try {
		return array('categorias'=> doQuery(getSelect($tbl_categoria)));
	} catch (PDOException $ex) {
		return array('categorias' => array(),'error'=> $ex->getMessage() );
	}
}

function guardarCategoria($datos)
{
	global $tbl_categoria;
	if(isset($datos['id']) and strlen($datos['id']) != 0 )
	{
		error_log('Mustt update object');
		return doUpdate($tbl_categoria,$datos);
	}
	error_log('Isert Object');
	return doInsert($tbl_categoria,$datos);
}

function borrarCategoria($datos)
{
	global $tbl_categoria;
	if( isset($datos['id']) and strlen($datos['id']) != 0 )
	{
		return doDelete($tbl_categoria,$datos);
	}
	return array('resultado'=>false,'error'=>'Identificador para categoria incorrecto');
}

function getCategoria($idCategoria)
{
	global $tbl_categoria;
	return doQueryById($tbl_categoria,array('id'=>$idCategoria));
}

function listarProducto(){
	global $tbl_producto;
	try {
		$rs = doQuery( getSelect($tbl_producto) );
		return array( 'producto' => $rs );
	} catch (PDOException $ex) {
		show_app_error($ex)	;
		die();
	}
}

function guardarProducto($datos)
{
	global $tbl_producto;
	if(isset($datos['id']) and strlen($datos['id']) != 0 )
	{
		error_log('Mustt update object');
		return doUpdate($tbl_producto,$datos);
	}
	error_log('Insert Object');
	return doInsert($tbl_producto,$datos);
}

function borrarProducto($datos)
{
	global $tbl_producto;
	if( isset($datos['id']) and strlen($datos['id']) != 0 )
	{
		return doDelete($tbl_producto,$datos);
	}
	return array('resultado'=>false,'error'=>'Identificador para producto incorrecto');
}

function getProducto($idProducto)
{
	global $tbl_producto;
	return doQueryById($tbl_producto,array('id'=>$idProducto));
}

function listarCliente()
{
	global $tbl_cliente;
	try {
		$rs=doQuery(getSelect($tbl_cliente));
		return array('clientes'=>$rs );
	} catch (PDOException $ex) {
		show_app_error($ex)	;
		die();
	}
}

function guardarCliente($datos)
{
	global $tbl_cliente;
	if(isset($datos['id']) and strlen($datos['id']) != 0 )
	{
		error_log('Mustt update object');
		return doUpdate($tbl_cliente,$datos);
	}
	error_log('Insert Object');
	return doInsert($tbl_cliente,$datos);
}

function borrarCliente($datos)
{
	global $tbl_cliente;
	if( isset($datos['id']) and strlen($datos['id']) != 0 )
	{
		return doDelete($tbl_cliente,$datos);
	}
	return array('resultado'=>false,'error'=>'Identificador para cliente incorrecto');
}

function getCliente($idCliente)
{
	global $tbl_cliente;
	return doQueryById( $tbl_cliente, array('id'=>$idCliente) );
}

function login($usuario, $password)
{
	global $con;
	try 
	{
		$ql = "select * from usuario where usuario = :usuario and contra = :contra";
		$ps = $con->prepare($ql);
		$ps->bindParam(':usuario', $usuario);
		$ps->bindParam(':contra', $password);
		$ps->execute();
		$res = $ps->fetch( PDO::FETCH_ASSOC );

		if ( is_bool( $res ) or ( is_array( $res ) and count( $res ) == 0 ) )
		{ // is false or an empty array
			$ans = array( 'resultado' => false, 'mensaje' => 'Usuario no encontrado');
		}
		else 
		{
			$ans = array( 'resultado' => true, 'usuario' => $res);
		}
	}
	catch ( PDOException $ex )
	{
		$ans = array('resultado' => false, 'mensaje' => $ex->getMessage() );
	}
	return $ans;
}

function obtenerCaja()
{
	global $con;
	$caja = null;
	try {
		$qc = 'select id, inicio, fin from caja where fin is null';
		$ps = $con->prepare( $qc );
		$ps->execute();
		$caja = $ps->fetch( PDO::FETCH_ASSOC );
		if ( is_bool( $caja ) ) // La caja no existe
		{
			//
			$qci = 'insert into caja(id, inicio, fin) values(:id, now(), null)';
			$psi = $con->prepare( $qci );
			$id = uniqid('caja');
			$psi->bindParam(':id', $id);
			$ok = $psi->execute();
			if ( $ok and ( $psi->rowCount() != 0 ) )
			{
				// Volver a buscar
				$psa = $con->prepare( $qc );
				$psa->execute();
				$caja = $psa->fetch( PDO::FETCH_ASSOC );
			}
		}
	}
	catch ( PDOException $ex )
	{
		// Mal
		die('No se encontro la caja');
	}
	return $caja;
}

function guardarTicket($ticket, $pago, $lineas)
{
	global $con;

	try 
	{
		// Comienza la transaccion
		$con->beginTransaction();

		$qt = 'insert into ticket values(:id, :caja, :usr, :clt, :fecha)';
		$pit = $con->prepare( $qt );
		$id_ticket = uniqid( 'tic' );
		$fecha = date('Y-m-d H:i:s');
		$pit->bindParam( ':id', $id_ticket );
		$pit->bindParam( ':caja', $ticket['id_caja'] );
		$pit->bindParam( ':usr', $ticket['id_usuario'] );
		$pit->bindParam( ':clt', $ticket['id_cliente'] );
		$pit->bindParam( ':fecha', $fecha );
		$pit->execute(); // Ticket insertado

		$qp = 'insert into pago values(:id, :tic, :imp, :rec)';
		$pip = $con->prepare( $qp );
		$id_pago = uniqid( 'pag' );
		$pip->bindParam( ':id', $id_pago );
		$pip->bindParam( ':tic', $id_ticket );
		$pip->bindParam( ':imp', $pago['importe'] );
		$pip->bindParam( ':rec', $pago['recibido'] );
		$pip->execute(); // Pago insertado

		$qlt = 'insert into linea_ticket values(:id, :tic, :ord, :pdt, :cant, :pre, :imp)';

		$ord = 0;
		foreach ($lineas as $lin) 
		{
			$pil = $con->prepare($qlt);
			// 
			$pil->bindParam( ':id', uniqid('lin') );
			$pil->bindParam( ':tic', $id_ticket );
			$pil->bindParam( ':ord', $ord );
			$pil->bindParam( ':pdt', $lin['id_producto'] );
			$pil->bindParam( ':cant', $lin['cantidad'] );
			$pil->bindParam( ':pre', $lin['precio'] );
			$pil->bindParam( ':imp', $lin['impuesto'] );
			$pil->execute(); 
			$ord++;
		}

		// Termina la transaccion
		$con->commit();
		$res = array('resultado' => true, 'mensaje' => 'Venta guardada exitosamente.', 'ticket' => $id_ticket );
	}
	catch ( PDOException $ex )
	{
		$con->rollBack();
		$res = array('resultado' => false, 'error' => $ex->getMessage());
	}
	return $res;
}

function listarCaja( $caja )
{
	global $con;
	try
	{
		// Información de la caja
		$qc = 'select id, inicio, fin from caja where id = :caja';
		$psc = $con->prepare( $qc );
		$psc->bindParam( ':caja', $caja );
		$ok = $psc->execute(); // Must be ok,
		$cc = $psc->fetch( PDO::FETCH_ASSOC );

		// Total de caja
		$qlc = 'select count(*) as ventas, sum(p.importe) as total from caja as c join ticket as t on c.id = t.id_caja join pago as p on t.id = p.id_ticket';
		$qlc .= ' where c.id = :caja';

		$ps = $con->prepare( $qlc );
		$ps->bindParam( ':caja', $caja);
		$ok = $ps->execute();
		$total = $ps->fetch( PDO::FETCH_ASSOC );

		// Formar la respuesta
		$res = array( 'resultado' => true,
				'inicio' => $cc['inicio'], // 1er query
				'fin' => $cc['fin'], // 1er query
				'ventas' => $total['ventas'], // 2da query
				'total' => $total['total'] // 2da query 
			);
	}
	catch ( PDOException $ex )
	{
		$res = array( 'resultado' => false, 'mensaje' => $ex->getMessage() );
	}
	return $res;
}

function cerrarCaja( $idCaja )
{
	// Falta corroborar que se cerrará una caja 
	// que tiene ventas, por si se saltan la validación
	// que se hizo en el front-end (debe haber ventas para que
	// tenga sentido cerrar la caja)
	global $con;
	try
	{
		$con->beginTransaction(); // Transaccion empezada
		// Cerrar la caja
		$qc = 'update caja set fin = now() where id = :caja';
		$ps = $con->prepare( $qc );
		$ps->bindParam( ':caja', $idCaja );
		$ok = $ps->execute();

		// Insertar nueva caja
		$nc = 'insert into caja(id, inicio, fin) values(:id, now(), null)';
		$id = uniqid('caja');
		$psi = $con->prepare( $nc );
		$psi->bindParam(':id', $id);
		$ok = $psi->execute();

		// Info sobre la ultima caja
		$qoc = 'select id, inicio, fin from caja where id = :id';
		$psc = $con->prepare( $qoc );
		$psc->bindParam( ':id', $idCaja );
		$ok = $psc->execute();
		$cajaCerrada = $psc->fetch( PDO::FETCH_ASSOC );

		// Respuesta
		$res = array('resultado' => true, 'caja' => $id, 'fin' => $cajaCerrada['fin'], 
			'mensaje' => 'Caja cerrada exitosamente');
		$con->commit(); // Termina transaccion
	}
	catch ( PDOException $ex )
	{
		$res = array( 'resultado' => false, 'error' => $ex->getMessage() );
	}
	return $res;
}

function reportarVentas( $inicio = null, $fin = null )
{
	global $con;
	try
	{
		// Parsear fechas, deben existir siempre
		$where = ' where ';
		$lim_ini = false;
		$lim_fin = false;
		if ( !is_null( $inicio ) ) // Fecha inicial
		{
			$inicio = date_format( date_create( $inicio ), 'Y-m-d H:i:s' );
			$where .= 't.fecha = :ini ';
			$lim_ini = true;
		} 
		else {
			$where .= ' 1 = 1 ';
		}
		if ( !is_null( $fin ) ) // Fecha final
		{
			$fin = date_format( date_create( $fin ), 'Y-m-d H:i:s' );
			$where = ' and t.fecha = :fin ';
			$lim_fin;
		}
		else
		{
			$sfin = ' and 1 = 1 ';
		}

		$qr = 'select t.fecha as fecha, p.importe as importe from ticket as t join pago as p on t.id = p.id_ticket ' . $where;
		error_log( 'Reporte venta: ' . $qr );
		$ps = $con->prepare( $qr );
		if ( $lim_ini )
			$ps->bindParam( ':ini', $inicio );
		if ( $lim_fin )
			$ps->bindParam( ':fin', $fin );
		$ok = $ps->execute();
		$rvs = $ps->fetchAll( PDO::FETCH_ASSOC );
		return $rvs;
	}
	catch ( PDOException $ex )
	{
		// No se si hacer los errores recuperables o no... Es triste.
		die('Bad, bad, bad');
	}
}

function obtenerTicket( $idTicket )
{
	global $con;
	try
	{
		$qt = 'select * from ticket where id = :id';
		$pst = $con->prepare( $qt );
		$pst->bindParam(':id', $idTicket );
		$ok = $pst->execute();
		$ticket = $pst->fetch( PDO::FETCH_ASSOC );

		// Lineas
		$ql = 'select p.nombre as producto, lt.cantidad as cantidad, lt.precio as precio, lt.cantidad * lt.precio as total, lt.impuesto as impuesto from linea_ticket as lt ';
		$ql .= 'join producto as p on lt.id_producto = p.id ';
		$ql .= 'where lt.id_ticket = :id order by lt.orden';

		$psl = $con->prepare( $ql );
		$psl->bindParam( ':id', $idTicket );
		$ok = $psl->execute();
		$lineas = $psl->fetchAll( PDO::FETCH_ASSOC );

		// pago
		$qp = 'select importe, recibido from pago where id_ticket = :id';
		$psp = $con->prepare( $qp );
		$psp->bindParam( ':id', $idTicket );
		$ok = $psp->execute();
		$pago = $psp->fetch( PDO::FETCH_ASSOC );

		return array('ticket' => $ticket, 'lineas' => $lineas, 'pago' => $pago );
	}
	catch ( PDOException $ex )
	{
		return null;
		// die('No se pudo encontrar el ticket');
	}
}
?>
