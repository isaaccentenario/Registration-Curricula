<?php 
	require_once "includes.php"; 
	require_once "includes/functions.php"; 

	(! $login->session_verify() ) AND header('location:index.php?r=2');

	function active($nav=null) {
		$active = basename($_SERVER["REQUEST_URI"]); 
		echo $nav == $active ? " class='active' " : '';
	}
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Painel de Administração</title>
	
	<link rel="stylesheet" href="<?= $base_url ?>/admin/assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= $base_url ?>/admin/assets/css/style.css">
	
	<script src="<?= $base_url ?>/assets/js/jquery.js"></script>
	<script src="<?= $base_url ?>/admin/assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?= $base_url ?>/admin/assets/js/script.js"></script>

</head>

<body data-url="<?= $base_url ?>">

<section class="site-section navtop">
	<div class="container">
		<h3> Administração </h3>
	</div>
</section>

<!-- PopUp -->
<div class="pp-fade"></div>

<div class="popup-container">
	<div class="cnt"></div>
</div>
<!-- / PopUp -->

<section class="site-section">
	<div class="container">
		<div class="col-md-3">
			<div class="menu-container">
				<ul class="nav nav-pills nav-stacked admin-menu admin-menu">
					
					<li <?= active('home') ?>><a href="home"><i class="glyphicon glyphicon-home"></i> Início </a></li>
					<li  <?= active('inscricoes') ?>><a href="inscricoes"><i class="glyphicon glyphicon-list-alt"></i> Inscrições </a></li>
					<li  <?= active('skills') ?>><a href="skills"><i class="glyphicon glyphicon-thumbs-up"></i> Skills </a></li>
					<li><a href="logoff"><i class="glyphicon glyphicon-log-out"></i> Sair </a></li>
				</ul>
			</div>
		</div>
		<div class="col-md-9">
			<div class="content-container">
			