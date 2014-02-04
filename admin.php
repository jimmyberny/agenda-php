<?php
session_start();

if ( !isset( $_SESSION['sid'] ))
{
	header( 'Location: index.php' );
}
?>