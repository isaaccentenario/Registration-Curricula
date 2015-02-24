<?php

require "includes.php"; 

if( isset( $_POST['id'] ) ) :

	$id = (int)$_POST["id"]; 

	if( $crud->delete( 'registrations', array('id'=>$id ) ) ): 

		echo json_encode(array('delete'=>true));

	else:

		echo json_encode(array('delete'=>false));

	endif;
endif;