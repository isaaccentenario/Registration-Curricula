<?php
require "includes.php";

if( $_SERVER["REQUEST_METHOD"] == "POST" ): 

	extract($_POST);

	function false( $nome ) {
		return json_encode(array($nome =>false));
	}

	function true( $nome ) {
		return json_encode(array($nome=>true));
	}

	extract($_POST); 
	
	$conta = "^[a-zA-Z0-9\._-]+@";
	$domino = "[a-zA-Z0-9\._-]+.";
	$extensao = "([a-zA-Z]{2,4})$";
	$pattern = $conta.$domino.$extensao;

	if( !ereg( $pattern, $email ) ) {
		echo false('email');
	} elseif( $mensagem == '' or $mensagem == ' ') {
		echo false('mensagem');
	} else {

		$contato = "
			Assunto: <strong>" . $assunto . "</strong><br />
			Mensagem: <strong>" . $mensagem . "</strong>";
		$email_remetente = $email;
		$headers = "MIME-Version: 1.1\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "From: $email\n"; // remetente
		$headers .= "Return-Path: $email\n"; // return-path
		$headers .= "Reply-To: $email\n"; // Endereço (devidamente validado) que o seu usuário informou no contato
		$envio = mail($email, $assunto, $contato, $headers, "-f$email");

		if( $envio ) {
			echo true('mail');
			$crud->update('registrations',array('contacted'=>1),array('id'=>$id));
		} else {
			echo false('mail');
		}
	}
else:
	
endif;