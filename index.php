<?php require_once("config.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Cadastro</title>
	
	<link rel="stylesheet" href="assets/css/style.css">

	<script src="assets/js/jquery.js"></script>
	<script src="assets/js/script.js"></script>

</head>
<body data-url="<?= $base_url ?>">
	<header class="site-section header">
		<div class="grid">

			<div class="container">
				<h1> Cadastro </h1>
				<h2> Cadastre-se aqui para a vaga de emprego </h2>
			</div>
		
		</div>
	</header>

	<section class="site-section content">
		
		<div class="grid">
			<h1>Entre com seus dados</h1>

			<div class="form-container">
				<form action="" class="registration-form">
					
					<label for="name">Nome *</label>
					<input type="text" class="form-input nome" name="Nome" placeholder="Nome completo, por favor" required>

					<label for="email">E-Mail *</label>
					<input type="email" class="form-input email" name="email" placeholder="ex: nome@servidor.com" required>
					
					<label for="twitter">Twitter *</label>
					<input type="text" class="form-input twitter" name="twitter" placeholder="ex: seu_nome_no_twitter (sem o @)" required>
				
					<label for="habilidades"> Marque aqui sua habilidades (seja sincero ;) ) </label>
					<div class="skills-container"></div>

					<button class="submit-form" type="submit">Enviar</button>

				</form>
			</div>

		</div>

	</section>
</body>
</html>