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
		
		<?php include "includes/header.php"; ?>
		<div class="containeurGlobal">
			
			
			<?php

		//validation du bouton 
		if(isset($_POST['validation']))
		{
			//récupération variables (trim->sécuriser la variable)
			$nb=trim($_POST['nb']);
			
			header("Location: add_question.php?id=".$quizId."&nb=".$nb);
		
		}
		?>
			<div class="infoBase">
				
				<div id="infoBaseInt">
			
				<h1><strong> Quiz : <?=$quizs['quiz_nom'] ?> </strong></h1>
					
					
					<form method="post" action="index_question.php?id=<?=$quizId?>">
						<em>Ajout de questions :</em>
						<input type="text" name="nb" class="formTexte" placeholder="Saisir un nombre" required autofocus>
						<em>... questions</em>
						<button type="submit" name="validation" class="boutonC"><span class="glyphicon glyphicon-log-in"></span> Ajouter</button>           	     
						<a class="option" href="suppr_question.php?id=<?= $quizId ?>">Suppression de questions</a>
					</form>
					
				</div>
			</div>
				
				<?php foreach ($questions as $question) { ?>
				
					<div class="element">
						
						<div id="elementInt">
						
						<strong><?= $question['ques_cont']?></strong> 
						<a class="QuizTitle" href="modif_question.php?id=<?= $quizId?>&num=<?= $question['ques_id']?>">Modifier</a><br/>
						
						<?php
							$stmt4 = getDb()->prepare('select * from reponse where ques_id=?');
							$stmt4->execute(array($question['ques_id']));
							$reponses = $stmt4->fetchAll();
							
							foreach ($reponses as $reponse){ 
								if ($reponse['rep_estVrai']=='vrai')
									echo '<font color=red><strong>'.$reponse['rep_cont'].'</strong></font>';
								else 
									echo $reponse['rep_cont'].'';
								echo ' ';
							}
							?>
							
							
					</div>
					</div>
				<?php } ?>				
				
				
			
		</div>

	<?php require_once "includes/footer.php"; ?>
	<?php require_once "includes/scripts.php"; ?>
	</body>

</html>