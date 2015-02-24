<?php 
require_once "../config.php"; 
require_once "../includes/simplecrud.class.php"; 

$crud = new simplecrud( $host, $user, $password, $database ); 

$crud->error and die( 'Ocorreu um erro ao conectar o banco de dados ' . json_encode( array( 'connection'=>false ) ) );