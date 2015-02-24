<?php 

### DEFINIÇÕES DO SISTEMA 

$host = "localhost";	 						// host do banco de dados 

$user = "root"; 								// user do banco de dados 

$password = ""; 								// password do banco de dados 

$database = "sistema"; 							// nome do banco de dados 

$base_url = "http://localhost/sistema"; 		// url base para o sistema 

$port = 3306; 									// porta usada pelo banco de dados

header("content-type:text/html; charset=utf8"); // charset

/*
	Cria o Caminho Absoluto para includes
*/

$path = __FILE__; 
$path = str_replace( basename($path), "", $path ); 

define( 'PATH' , $path );