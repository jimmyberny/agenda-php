<?php 
/**
* Sirve para comparar si dos cadenas son iguales
*/
function match( $cad, $cad2 ) 
{
	return strcasecmp( $cad, $cad2 ) == 0; // Son iguales
}

?>