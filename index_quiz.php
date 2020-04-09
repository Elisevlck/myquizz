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
?>

<!doctype html>

<html>

	<?php 
		$pageTitle = $themes['theme_nom'];
		require_once "includes/head.php"; 
	?>

	<body>	
		
		<div class="container">
			
			<?php include "includes/header.php"; ?>
			
				<h1> Catégorie : <?=$themes['theme_nom'] ?> </h1>
				<a class="QuizTitle" href="add_quiz.php?id=<?= $themeId?>">Ajout de quiz </a><br/>
					<a class="QuizTitle" href="suppr_quiz.php?id=<?= $themeId ?>">Suppression de quiz</a>
				<br/><br/><br/>
				
				<h3> Liste des quiz associés : </h3>
				
				<?php foreach ($quizs as $quiz) { ?>
				
					<article>
						<strong><?= $quiz['quiz_nom']?></strong>
						<a class="QuizTitle" href="quiz.php?id=<?= $quiz['quiz_id'] ?>&tId=<?=$themeId?>&niv=facile">Facile </a>
						<a class="QuizTitle" href="quiz.php?id=<?= $quiz['quiz_id'] ?>&tId=<?=$themeId?>&niv=moyen">Moyen </a>
						<a class="QuizTitle" href="quiz.php?id=<?= $quiz['quiz_id'] ?>&tId=<?=$themeId?>&niv=difficile">Difficile</a>
						<a class="QuizTitle" href="index_question.php?id=<?= $quiz['quiz_id'] ?>">Modifier</a>
					</article>
				<?php } ?>				
				
				
			
		</div>

	<?php require_once "includes/footer.php"; ?>
	<?php require_once "includes/scripts.php"; ?>
	</body>

</html>