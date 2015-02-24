<?php require "includes.php"; 

if( isset($_POST["id"] ) ): 

	$id = (int)$_POST["id"]; 

	$del = $crud->delete('skills',array('id'=>$id)); 

	if($del):
		echo json_encode(array('delete'=>true));
	else:
		echo json_encode(array('delete'=>true));
	endif;

endif;
