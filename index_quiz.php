<?php
	require_once "includes/function.php";
	session_start();

	$themeId = $_GET['id'];
	
	$recup_quizs = getDb()->prepare('select * from quiz where theme_id=?');
	$recup_quizs->execute(array($themeId));
	$quizs = $recup_quizs->fetchAll();
	
	$recup_theme = getDb()->prepare('select * from theme where theme_id=?');
	$recup_theme->execute(array($themeId));
	$theme = $recup_theme->fetch();
?>

<!doctype html>

<html>

	<?php 
		$pageTitle = $theme['theme_nom'];
		require_once "includes/head.php"; 
	?>

	<body>	
		
		<div class="container">
			
			<?php include "includes/header.php"; ?>
			
				<h1> Catégorie : <?=$theme['theme_nom'] ?> </h1>
				<a class="QuizTitle" href="add_quiz.php?id=<?= $themeId?>">Ajout de quiz </a><br/>
				<a class="QuizTitle" href="suppr_quiz.php?id=<?= $themeId ?>">Suppression de quiz</a>
				<br/><br/><br/>
				
				<h3> Liste des quiz associés : </h3>
				
				<?php foreach ($quizs as $quiz) { ?>
				
					<article>
						<strong><?= $quiz['quiz_nom']?></strong>
						<a class="QuizTitle" href="index_question.php?id=<?= $quiz['quiz_id'] ?>">Modifier</a>
						<br/>
						Affichage d'un trait :
						<a class="QuizTitle" href="quiz.php?id=<?= $quiz['quiz_id'] ?>&tId=<?=$themeId?>&niv=facile">Facile </a>
						<a class="QuizTitle" href="quiz.php?id=<?= $quiz['quiz_id'] ?>&tId=<?=$themeId?>&niv=moyen">Moyen </a>
						<a class="QuizTitle" href="quiz.php?id=<?= $quiz['quiz_id'] ?>&tId=<?=$themeId?>&niv=difficile">Difficile</a>
						<br/>
						Affichage question par question :
						<a class="QuizTitle" href="quiz1par1.php?id=<?= $quiz['quiz_id'] ?>&tId=<?=$themeId?>&niv=facile&num=0&score=0">Facile </a>
						<a class="QuizTitle" href="quiz1par1.php?id=<?= $quiz['quiz_id'] ?>&tId=<?=$themeId?>&niv=moyen&num=0&score=0">Moyen </a>
						<a class="QuizTitle" href="quiz1par1.php?id=<?= $quiz['quiz_id'] ?>&tId=<?=$themeId?>&niv=difficile&num=1&score=0">Difficile</a>
						<br/><br/>
					</article>
					
			<?php } //fin du foreach?>	
		</div>

		<?php require_once "includes/footer.php"; ?>
		<?php require_once "includes/scripts.php"; ?>
	</body>

</html>