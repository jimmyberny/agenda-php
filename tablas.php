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
	'fields' 	=> array('id', 'id_municipio', 'nombre'),
	'form' 		=> array(
		'id_municipio' => 'municipio'),
	'ids'		=> array(0),
	'order'		=> array(1, 2)
	);

$t_supervisor = array(
	'name' 		=> 'supervisor',
	'fields' 	=> array('id', 'nombre'),
	'form' 		=> array(),
	'ids'		=> array(0),
	'order'		=> array(1)
	);

?>