<?php 

$t_usuario = array(
	'name' 		=> 'usuario',
	'fields' 	=> array('id', 'nombre', 'usuario', 'contrasena'),
	'form' 		=> array(),
	'ids'		=> array(0),
	'order'		=> array(1)
	);

$t_estado = array(
	'name' 		=> 'estado',
	'fields' 	=> array('id', 'nombre'),
	'form' 		=> array(),
	'ids'		=> array(0),
	'order'		=> array(1)
	);

$t_municipio = array(
	'name' 		=> 'municipio',
	'fields' 	=> array('id', 'id_estado', 'nombre'),
	'form' 		=> array(
		'id_estado' => 'estado'),
	'ids'		=> array(0),
	'order'		=> array(1, 2)
	);

$t_localidad = array(
	'name' 		=> 'localidad',
	'fields' 	=> array('id', 'id_municipio', 'nombre', 'cp'),
	'form' 		=> array(
		'id_municipio' => 'municipio'),
	'ids'		=> array(0),
	'order'		=> array(1, 2)
	);

$t_supervisor = array(
	'name' 		=> 'supervisor',
	'fields' 	=> array('id', 'nombre', 'email'),
	'form' 		=> array(),
	'ids'		=> array(0),
	'order'		=> array(1)
	);

$t_rango = array(
	'name'		=> 'rango_ventas',
	'fields'	=> array('id', 'nombre'),
	'form'		=> array(),
	'ids'		=> array(0),
	'order'		=> array(1)
	);

$t_giro = array(
	'name'		=> 'giro',
	'fields'	=> array('id', 'nombre'),
	'form'		=> array(),
	'ids'		=> array(0),
	'order'		=> array(1)	
	);

$t_nota = array(
	'name'		=> 'nota',
	'fields'	=> array('id', 'nombre'),
	'form'		=> array(),
	'ids'		=> array(0),
	'order'		=> array(1)	
	);

// Actualmente solo habra un registro con id = 'siem'
$t_configuracion = array(
	'name'		=> 'configuracion',
	'fields'	=> array('id', 'recordatorio', 'smtp_servidor', 'smtp_puerto', 'smtp_usuario', 'smtp_clave'),
	'form'		=> array(),
	'ids'		=> array(0),
	'order'		=> array(0) // No es importante
	);

$t_cliente = array(
	'name'		=> 'cliente',
	'fields'	=> array('id', 'razon_social', 'cliente', 'id_localidad', 'calle',
		'num_int', 'num_ext', 'telefono', 'fax', 'email',
		'fecha_inicio', 'id_rango', 'id_giro'),
	'form'		=> array(
		'id_localidad' 	=> 'localidad',
		'id_rango' 		=> 'rango',
		'id_giro' 		=> 'giro'),
	'ids'		=> array(0),
	'order'		=> array(1, 2)
	);
?>