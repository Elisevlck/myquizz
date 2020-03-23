<?php
	require_once "includes/function.php";
	session_start();
	// Récuperer tous les quiz
	$quizs = getDb()->query('select * from quiz'); 
?>

<!doctype html>

<html>
	
	<?php 
		$pageTitle="Ajouter un thème";
		require_once "includes/head.php"; 
	?>

	<body>
	
		<div class="container">
			
			<?php require_once "includes/header.php"; ?>
			
			<h2 class="text-center">Ajout d'un thème</h2>
			
			<div class="well">
			
			<form class="form-horizontal" role="form" enctype="multipart/form-data" action="add_theme.php" method="post">
            <!--<input type="hidden" name="id" value="<?= $quizId ?>">-->
			  
				<div class="form-group">			
					<label class="col-sm-4 control-label">Nom du thème : </label>                
					<div class="col-sm-6">					
						<input type="text" name="title" value="<?= $quizTitle ?>" class="form-control" placeholder="Entrez le nom du thème" required>
					</div>	
				</div>
			</form>
			</div>
		</div>
		
		<?php include "includes/footer.php";?>
		<?php include "includes/scripts.php";?>
	</body>
</html>
				
				
				
				