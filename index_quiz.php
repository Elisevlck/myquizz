<?php
	require_once "includes/function.php";
	session_start();

	$themeId = $_GET['id'];
	
	$stmt = getDb()->prepare('select * from quiz where theme_id=?');
	$stmt->execute(array($themeId));
	$quizs = $stmt->fetch(); // Access first (and only) result line
?>

<!doctype html>
<html>

	<?php 
		$pageTitle = $themes['theme_nom'];
		require_once "includes/head.php"; 
	?>

	<body>
	
		<div class="container">
			
			<?php require_once "includes/header.php"; ?>			

				<h1> Liste des quiz pour cette catégorie : </h1>
				
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