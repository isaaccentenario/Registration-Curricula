<?php 
ob_start();
session_start();

error_reporting(0);

require str_replace( basename( __FILE__ ), '' , __FILE__ ) . "../config.php"; 

require PATH . "/includes/simplecrud.class.php"; 
require PATH . "/includes/login.class.php"; 

$crud = new simpleCRUD( $host, $user, $password, $database, array('port'=>$port) ); 

$crud->error AND die ('<h1> Ocorreu um erro na conexão com o banco de dados </h1><p> Detalhes: ' . $crud->error );

$login = new login( array('table'=>'admin'), $crud );