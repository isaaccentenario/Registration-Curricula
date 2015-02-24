<?php require "header.php"; 
require PATH . "/includes/pagination.class.php";
?>

<h1>Inscrições</h1>
<p> Aqui você verá a lista de inscrições feitas no site </p>

<?php 

$get = $crud->get('registrations'); 

$rows = $get->num_rows;

if( $rows <= 0 ) : ?>
	<div class="well well-sm">Não foram encontrados registros no sistema</div>
<?php else: 

	$for = [];
	while( $a = $get->fetch_object() ): 
		$for[] = $a;
	endwhile;
	
	$p = new pagination( $for, 3 ); 
	$page = isset( $_GET["p"] ) ? $_GET["p"] : 1; 

	$page = $p->page( $page );
	if( $page == false ) {
		die("Página não existe");
	}

	foreach( $page as $value ):
		$id = $value->id;
		$new_get = $crud->query("SELECT
			*
			FROM skills AS skill
			INNER JOIN skills_rel AS skill_rel
			ON (skill_rel.id_skill = skill.id)
			WHERE skill_rel.id_enrollment IN(SELECT id FROM registrations WHERE id='".$id."')"); 
		?>
		<div class="well well-sm">
			<div class="user">
				<div class="contacted-info <?= $value->contacted == 1 ? 'c-true' : 'c-false'; ?>"></div>
				<div class="col-sm-6">
					<h4 class="nome"><?= $value->name ?></h4>
					<h5 class="email"><?= $value->email ?></h5>
					<p class="twitter"><strong>Twitter:</strong><span><?= $value->twitter ?></span></p>
				</div>

				<div class="col-sm-4">
					<h4 style="width:100%;padding:7px;display:block;text-align:center">Habilidades</h4>
					<?php if( $new_get->num_rows <= 0 ): 
						echo "Não foi selecionado nenhum skill";
					else: 
						while( $a = $new_get->fetch_object() ) : ?>
							
							<div class="skill">
								<?= $a->name ?> - <?= $a->pontuation ?>
							</div>

						<?php endwhile;
					endif ?>
				</div>

				<div class="col-sm-2">
					<button class="btn btn-default contact" data-id="<?= $value->id ?>">Contatar</button>
					<div>  &nbsp</div>
					<button class="btn btn-default delete" data-id="<?= $value->id ?>">Apagar</button>
				</div>

			</div>
		</div>
	<div class="pagination" style="text-align:center; width:100%;">
		<?php endforeach; 

		if( $p->prev() ) : ?>
			
			<a href="?p=<?= $p->prev() ?>"> <<< Página Anterior</a>

		<?php endif; ?> 

		 Página <?= $p->page ?> de <?= $p->pages ?> 

		<?php if( $p->next() ) : ?>
		
			<a href="?p=<?= $p->next() ?>"> Próxima Página >>> </a>

		<?php endif; ?>
	</div>
<?php	endif;