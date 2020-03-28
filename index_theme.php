<?php
	require_once "includes/function.php";
	session_start();
	// Récuperer tous les quiz
	$themes = getDb()->query('select * from theme where genre_nom="Thèmes"');
	$revisions = getDb()->query('select * from theme where genre_nom="Révisions"');
	
?>

<!doctype html>

<html>
	
	<?php 
		$pageTitle="Liste des Thèmes";
		require_once "includes/head.php"; 
	?>

	<body>
	
		<div class="container">
			
			<?php require_once "includes/header.php"; ?>			

				<h1> Les catégories diverses </h1>
				
				<?php foreach ($themes as $theme) { ?>
				
					<article>
						<h3><a class="quizTitle" href="index_quiz.php?id=<?= $theme['theme_id'] ?>"><?= $theme['theme_nom'] ?></a></h3>
						<?php //<p class="quizContent">Thème : <?= $quiz['theme_nom'] ?>
					</article>
				<?php } ?>
						
				<h1> Les révisions </h1>
						
				<?php foreach ($revisions as $revision) { ?>
				
					<article>
						<h3><a class="quizTitle" href="index_quiz.php?id=<?= $revision['theme_id'] ?>"><?= $revision['theme_nom'] ?></a></h3>
						<?php //<p class="quizContent">Thème : <?= $quiz['theme_nom'] ?>
					</article>
				<?php } ?>	
										
			
		</div>

	<?php require_once "includes/footer.php"; ?>
	<?php require_once "includes/scripts.php"; ?>
	</body>
	
</html>