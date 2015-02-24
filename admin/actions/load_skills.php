<?php 

require "includes.php"; 

$get = $crud->get('skills'); 

$return = [];
$return['num_rows'] = $get->num_rows;
while( $a = $get->fetch_array() ) :
	$return[] = $a;
endwhile;

echo json_encode($return);