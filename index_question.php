<?php
	require_once "includes/function.php";
	session_start();

	$quizId = $_GET['id'];
	
	$stmt = getDb()->prepare('select * from quiz where quiz_id=?');
	$stmt->execute(array($quizId));
	$quizs = $stmt->fetch();
	
	$stmt3 = getDb()->prepare('select * from question where quiz_id=?');
	$stmt3->execute(array($quizId));
	$questions = $stmt3->fetchAll();
	
?>

<!doctype html>

<html>

	<?php 
		$pageTitle = $quizs['quiz_nom'];
		require_once "includes/head.php"; 
	?>

	<body>	
		
		<div class="container">
			
			<?php include "includes/header.php"; ?>
			
			<?php

		//validation du bouton 
		if(isset($_POST['validation']))
		{
			//récupération variables (trim->sécuriser la variable)
			$nb=trim($_POST['nb']);
			
			header("Location: add_question.php?id=".$quizId."&nb=".$nb);
		
		}
		?>
			
			
				<h1> Quiz : <?=$quizs['quiz_nom'] ?> </h1>
					<em>Ajout de questions </em><br/>
					
					<form method="post" action="index_question.php?id=<?=$quizId?>">
						<input type="text" name="nb" class="form-control" placeholder="Entrez le nombre de questions" required autofocus>
						<button type="submit" name="validation" class="boutonC"><span class="glyphicon glyphicon-log-in"></span> Ajouter</button>
					</form>
					
					<a class="QuizTitle" href="suppr_question.php?id=<?= $quizId ?>">Suppression de questions</a>
				<br/><br/><br/>
				
				<h3> Liste des questions associés : </h3>
				
				<?php foreach ($questions as $question) { ?>
				
					<article>
						<p><em><?= $question['ques_cont']?></em> <a class="QuizTitle" href="modif_question.php?id=<?= $quiz['quiz_id'] ?>">Modifier</a><br/>
						
						<?php
							$stmt4 = getDb()->prepare('select * from reponse where ques_id=?');
							$stmt4->execute(array($question['ques_id']));
							$reponses = $stmt4->fetchAll();
							
							foreach ($reponses as $reponse){ 
								if ($reponse['rep_estVrai']=='vrai')
									echo '<strong>'.$reponse['rep_cont'].'</strong>';
								else 
									echo $reponse['rep_cont'].'';
								echo ' ';
							}
							?>
							
							</p>
					</article>
				<?php } ?>				
				
				
			
		</div>

	<?php require_once "includes/footer.php"; ?>
	<?php require_once "includes/scripts.php"; ?>
	</body>

</html>