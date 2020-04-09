<?php
	require_once "includes/function.php";
	session_start();

	$quizId = $_GET['id'];
	
	$stmt = getDb()->prepare('select * from quiz where quiz_id=?');
	$stmt->execute(array($quizId));
	$quizs = $stmt->fetch();
	
	$stmt2 = getDb()->prepare('select * from question where quiz_id=?');
	$stmt2->execute(array($quizId));
	$questions = $stmt2->fetchAll();	
?>

<!doctype html>

<html>

	<?php 
		$pageTitle = $quizs['quiz_nom'];
		require_once "includes/head.php"; 
	?>

	<body>	
		<?php include "includes/header.php"; ?>
		
			<div class="conteneurconex">
			<?php

				//validation du bouton 
				if(isset($_POST['validation']))
				{							
					foreach($_POST['choix'] as $choix)
					{		
						$suppr_quiz = getDb()->prepare("DELETE FROM question WHERE ques_id = ?");
						$suppr_quiz->execute(array($choix));
						$erreur = "Votre question a bien été supprimé";
						
						header("Location: index_ques.php?id=".$quizId);
					}
				}
				?>
     
				<form method="post" action="suppr_quiz.php?id=<?=$themeId?>">

					<div id="connexion">
					
					<h1> Quiz : <?=$quizs['quiz_nom']?> </h1>				
					<fieldset><legend><strong>Supprimer une/plusieurs question(s)</strong></legend><br/> 
					
					<?php foreach ($questions as $ques){ ?>
						<label><input type="checkbox" name="choix[]" value=" <?= $ques['ques_id'] ?>"/><?= $ques['ques_cont'] ?></label>
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