<?php
	require_once "includes/function.php";
	session_start();

	$themeId = $_GET['id'];
	
	$stmt = getDb()->prepare('select * from quiz where theme_id=?');
	$stmt->execute(array($themeId));
	$quizs = $stmt->fetchAll();
	
	$stmt2 = getDb()->prepare('select * from theme where theme_id=?');
	$stmt2->execute(array($themeId));
	$themes = $stmt2->fetch();
	$themeNom=$themes['theme_nom'];
?>

<!doctype html>

<html>

	<?php 
		$pageTitle = $themes['theme_nom'];
		require_once "includes/head.php"; 
	?>

	<body>	
		<?php require_once "includes/header.php"; ?>
		
			<div class="conteneurconex">
			
				<?php

				//validation du bouton 
				if(isset($_POST['validation']))
				{
					//récupération variables (trim->sécuriser la variable)
					$nom=trim($_POST['nom']);
					
					foreach($_POST['choix'] as $choix)
					{		
						$suppr_quiz = getDb()->prepare("DELETE FROM quiz WHERE quiz_id = ?");
						$suppr_quiz->execute(array($choix));
						$erreur = "Votre quiz a bien été supprimé";
						
						header("Location: index_quiz.php?id=".$themeId);
					}
				}
				?>
     
				<form method="post" action="suppr_quiz.php?id=<?=$themeId?>">

					<div id="connexion">
					
					<h1> Thème : <?=$themeNom?> </h1>				
					<fieldset><legend><strong>Supprimer un/plusieurs quiz</strong></legend><br/> 
					
					<?php foreach ($quizs as $quiz){ ?>
						<label><input type="checkbox" name="choix[]" value=" <?= $quiz['quiz_id'] ?>"/><?= $quiz['quiz_nom'] ?></label>
					<?php } ?>
				   <br/>
					<button type="submit" name="validation" class="boutonC"><span class="glyphicon glyphicon-log-in"></span> Valider</button>

					
					</div>  


					
					</fieldset> 
				</form>
		</div>

	<?php require_once "includes/footer.php"; ?>
	<?php require_once "includes/scripts.php"; ?>
	</body>

</html>