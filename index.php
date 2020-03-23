<?php
	require_once "includes/function.php";
	session_start();
	// Récuperer tous les quiz
	$quizs = getDb()->query('select * from quiz'); 
?>

<!doctype html>

<html>
	
	<?php 
		$pageTitle="Liste des Quiz";
		require_once "includes/head.php"; 
	?>

	<body>
	
		<div class="container">
			
			<?php require_once "includes/header.php"; ?>

			<?php foreach ($quizs as $quiz) { ?>
				
				<article>
					<h3><a class="quizTitle" href="quiz.php?quiz_id=<?= $quiz['quiz_id'] ?>"><?= $quiz['quiz_nom'] ?></a></h3>
					<!--<p class="quizContent">Thème : <?= $quiz['theme_nom'] ?></p>-->
				</article>
				
			<?php } ?>
			
		</div>

	<?php require_once "includes/footer.php"; ?>
	<?php require_once "includes/scripts.php"; ?>
	</body>
	
</html>