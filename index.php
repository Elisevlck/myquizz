<?php
	require_once "includes/function.php";
	session_start();

	// Récuperer tous les quiz
	$quizs = getDb()->query('select * from quiz'); 
?>

<!doctype html>

<html>

	<?php require_once "includes/head.php"; ?>

	<body>
		<div class="container">
			
			<?php require_once "includes/header.php"; ?>

			<?php foreach ($quizs as $quiz) { ?>
				
				<article>
					<h3><a class="quizTitle" href="quiz.php?quiz_id=<?= $quiz['quiz_id'] ?>"><?= $quiz['quiz_intitule'] ?></a></h3>
					<p class="quizContent">Thème : <?= $quiz['theme_nom'] ?></p>
				</article>
				
				<!--echo "  <form method=get action =\"page2.php\">" ;
				echo "<input type=\"submit\" value=\"Commencer\"><br />";//Commencement du quizz sur click du bouton
				
			<?php } ?>

			<?php require_once "includes/footer.php"; ?>
		</div>

		<!-- <?php require_once "includes/scripts.php"; ?>-->
	</body>

</html>