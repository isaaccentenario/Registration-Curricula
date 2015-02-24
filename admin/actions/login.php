<?php 

require "../includes.php";

if( $_SERVER["REQUEST_METHOD"] == "POST" ): 

	$user = $_POST["user"];
	$password = $_POST["password"]; 
	$ajax = isset( $_POST["ajax"] ) ? true : false;
	$true = json_encode( array('login'=>true) );
	$false = json_encode( array('login'=>false) );

	if( $login->login( $user, $password ) ) : 
		echo $ajax ? $true : header("location:../home.php");
	else:
		echo $ajax ? $false : header("location:../index.php?r=1");
	endif;

else:

endif;

?>