<?php
require "includes.php";
if( $_SERVER["REQUEST_METHOD"] == "POST" ): 

	extract($_POST);

	$insert = $crud->insert('skills',array('name'=>$title,'description'=>$content)); 

	if( $insert ):
		echo json_encode(array('save'=>true));
	else:
		echo json_encode(array('save'=>false));
	endif;
endif;
