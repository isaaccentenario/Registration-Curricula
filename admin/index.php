<?php require_once "includes.php";
	$login->session_verify() AND header('location:home.php');
?>
<!DOCTYPE HTML>
<html>
<head>

	<meta charset="utf-8" />
	<title> Painel de Administração - Login </title>
	<link rel="stylesheet" href="<?= $base_url ?>/admin/assets/css/login.css" />
	<meta name="robots" content="noindex,nofollow">
	<script src="<?= $base_url ?>/assets/js/jquery.js"></script>

</head>
<div class="login-form-container">
	<div class="response" style='display:none'></div>
	<form class="login-form" action="<?= $base_url ?>/admin/actions/login.php" method="post">
		<h4 style='margin:0'> Painel de Administração </h4>
		<label for="user"> Nome de Usuário </label>
		<input name="user" id="user" class="login-input" type="text" required>
		<label for="password"> Senha </label>
		<input name="password" id="password" class="login-input" type="password" required>
		<button class="form-submit btn btn-default" type="submit" > Entrar </button>
		<div class="clear"></div>
	</form>
</div> 
<style>
body {
	background: #f0f0f0;
}
</style>

<script>
$(function(){
	function rewriteurl() {
		var url = document.URL;
		var url = url.split('/');
		var rt = '';

		for( var i=0; i< url.length -1; i++ ) {
			rt += url[i] + '/';
		}
		window.history.pushState(null, document.title, rt);
	}
	var get = <?= json_encode($_GET) ?>;
	var timeOfAnimation = 5000;
	if( get['r'] && get['r'].length > 0 ) {

		var r = get['r'];

		if(r==1) {
			$(".response").removeClass('responso-green').addClass("response-red")
			.html("Nome de usuário ou senha incorretos")
			.slideDown('fast').delay(timeOfAnimation).slideUp('fast',function(){
				rewriteurl();
			});
		} else if( r==2) {
			$(".response").removeClass('responso-green').addClass("response-red")
			.html("Você precisa entrar primeiro")
			.slideDown('fast').delay(timeOfAnimation).slideUp('fast',function(){
				rewriteurl();
			});
		} else if( r==3 ) {
			$(".response").removeClass('responso-red').addClass("response-green")
			.html("Você saiu com sucesso")
			.slideDown('fast').delay(timeOfAnimation).slideUp('fast',function(){
				rewriteurl();
			});
		}
	}

	$('.login-form').submit(function(event){
		event.preventDefault();
		event.stopPropagation();

		var user = $('#user').val();
		var password = $("#password").val(); 
		var form = $(this); 

		$.post("actions/login.php",{ user:user,password:password,ajax:true}, function(data){
			var data = $.parseJSON(data); 
			if(data.login == false) {
				$(".response").addClass("response-red")
				.html("Nome de usuário ou senha incorretos")
				.slideDown('fast').delay('7000').slideUp('fast');
			} else {
				document.location = "home";
			}
		});
	});
});
</script>