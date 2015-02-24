<?php require "header.php" ?>

<div class="col-sm-6">
	<h1>Skills</h1>

	<div class="skills-container"></div>
	
</div>
<div class="col-sm-6">
	<h1>Novo Skill</h1>
	<div class="well well-sm">
		<form action="" class="skill-new">
			<label for="titulo">Título do Skill</label>
			<input type="text" class="form-control titulo" name="titulo">
			<label for="descricao">Descrição</label>
			<textarea name="descricao" id="" class="form-control descricao"></textarea>
			<div class="clear"></div>
			<button class="btn btn-default" type="submit">Salvar</button>
		</form>
	</div>
</div>