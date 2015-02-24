<?php 

require "includes.php"; 

$get = $crud->get( 'skills', null, array("select"=>"name,id,description") );

if( $get->num_rows <= 0 ): 
	echo json_encode( array( 'numrows' => 0 ) );
else:
	$return = [];
	
	$count = 0;
	while( $a = $get->fetch_array() ):
		$return[$count]['id'] = $a['id'];
		$return[$count]['name'] = $a['name'];
		$return[$count]['description'] = $a['description'];
		$count++;
	endwhile;

	$return['num_rows'] = $get->num_rows;

	echo json_encode( $return );

endif;