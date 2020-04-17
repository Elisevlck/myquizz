<?php
	require_once "includes/function.php";
	session_start();
	verifConnexion();

	$themeId = $_GET['id'];
	$_SESSION['theme']=$themeId;
	
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
		<?php include "includes/header.php"; ?>
		
		<div class="containeurGlobal">
		
			<div class="infoBase">
				<div id="infoBaseInt">
					<strong><FONT size="7"><?=$pageTitle; ?></font></strong>   
					<?php if(isAdmin()) { ?> <a class="option" href="add_quiz.php?id=<?= $themeId?>">Ajout de quiz</a>  <?php } ?>
				    <?php if(isAdmin()) { ?> <a class="option" href="suppr_quiz.php?id=<?= $themeId ?>">Suppression de quiz</a>		<?php } ?>		
				</div>
				 
			</div>
			
				<?php foreach ($quizs as $quiz) { ?>
				
					<div class="element">
						
						<div id="elementInt">
						    
    						<strong><FONT size="6"><?= $quiz['quiz_nom']?></font></strong>
    						<?php if(isAdmin()) { ?><a class="option" href="index_question.php?id=<?= $quiz['quiz_id'] ?>">Modifier</a> <?php } ?><br/><br/>
    						
    						Affichage d'un trait :
    						<a class="option" href="quiz.php?id=<?= $quiz['quiz_id'] ?>&niv=facile">Facile</a>   
    						<a class="option" href="quiz.php?id=<?= $quiz['quiz_id'] ?>&niv=moyen">Moyen</a>      
    						<a class="option" href="quiz.php?id=<?= $quiz['quiz_id'] ?>&niv=difficile">Difficile</a>
    						<br/><br/>
    						Affichage question par question :
    						<a class="option" href="quiz1par1_init.php?id=<?= $quiz['quiz_id'] ?>&niv=facile">Facile</a>      
    						<a class="option" href="quiz1par1_init.php?id=<?= $quiz['quiz_id'] ?>&niv=moyen?>">Moyen</a>      
    						<a class="option" href="quiz1par1_init.php?id=<?= $quiz['quiz_id'] ?>&niv=difficile?>">Difficile</a>
    						<br/><br/>
						
						</div>
						
					</div>
					
			<?php } //fin du foreach?>	
		</div>

		<?php require_once "includes/footer.php"; ?>
		<?php require_once "includes/scripts.php"; ?>
	</body>

</html>