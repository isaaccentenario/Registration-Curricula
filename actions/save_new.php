<?php require_once "includes.php"; 

function error( $type, $bool ) {
	echo json_encode( array( $type => $bool ) );
	return true;
}

if( $_SERVER["REQUEST_METHOD"] == "POST" ): 

	extract($_POST);

	$nome = trim($nome);
	$email = trim($email);
	$twitter = trim($twitter);

	if( $nome == '' or $nome == ' ' ):
		error('nome', 'empty' );
	elseif(!preg_match("/^([[:alnum:]_.-]){3,}@([[:lower:][:digit:]_.-]{3,})(.[[:lower:]]{2,3})(.[[:lower:]]{2})?$/", $email)):
		error('email', 'invalid' );
	elseif( $twitter == '' or $twitter == ' ' ): 
		error('twitter', false );
	elseif( $crud->get( 'registrations', array('email'=>$email))->num_rows > 0 ):
		error('email',false);
	elseif($crud->get('registrations',array('name'=>$nome))->num_rows > 0 ):
		error('name',false);
	else:
		$insert = $crud->insert( 'registrations', array("name"=>$nome,"email"=>$email,"twitter"=>$twitter,"contacted"=>0));
		if( $insert ):
			$id = $crud->con->insert_id;
			if( isset($skills) && !empty( $skills )):
				foreach( $skills as $single ):
					$single = json_decode($single);
					$id_skill = $single[0]; 
					$pontuation = empty($single[1]) ? 3 : $single[1];
					$crud->insert( 'skills_rel', array('id_skill'=>$id_skill, 'id_enrollment' => $id, 'pontuation'=>$pontuation));
				endforeach;
			endif;
			error('insert', true);
		else:
			error('insert',false);
		endif;

	endif; 
endif;