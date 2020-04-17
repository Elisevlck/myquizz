<?php
	require_once "includes/function.php";
	session_start();
	verifConnexion();
	
	$themeId=$_SESSION['theme'];
    
    $niveau=$_GET['niv'];
    $_SESSION['niveau']=$niveau;
    
    $quizId=$_GET['id'];
    $_SESSION['quiz']=$quizId;

    $_SESSION['score']=0;
    
    $_SESSION['page']=1;
    
    $recup_theme = getDb()->prepare('select * from theme where theme_id=?');
	$recup_theme->execute(array($themeId));
	$theme = $recup_theme->fetch();
    
    $recup_quiz = getDb()->prepare('select * from quiz where quiz_id=?');
	$recup_quiz->execute(array($quizId));
	$quiz = $recup_quiz->fetch();
	
	$recup_ques = getDb()->prepare('select * from question where quiz_id=?');
	$recup_ques->execute(array($quizId));
	$questions = $recup_ques->fetchAll();
?>

<html>

	<?php 
		$pageTitle = $quiz['quiz_nom'];
		require_once "includes/head.php"; 

	?>
	
	<body>
	    
	    <?php require_once "includes/header.php"; ?>
	    
	        <?php
	            
	            $i=1;
	            unset($_SESSION['quesIds']);
	        
	            foreach ($questions as $question)
	            {
	                $_SESSION['quesIds'][$i]=$question['ques_id'];
	                $i++;
	            }
	       
	       ?>
	    
			<div class="containeurGlobal">
				
				<div class="infoBase"><img src="images\chrono.gif" style="float:right;" width="300"></img>
					
					<div id="infoBaseInt">
					
					<h2><strong><?= $quiz['quiz_nom'] ?></strong></h2>
					<em><small>Nombre de questions : <?= $quiz['nbquestions'] ?> questions && Niveau choisi : <?=$niveau?></small></em><br/>
					<em><small>Date de création : <?= $quiz['datecreation'] ?> par <?= $quiz['createur'] ?> </small></em><br/>
					<em><small>Thème : <?= $theme['theme_nom'] ?></small></em><br/>
					<h5><strong>ATTENTION</strong> le temps est compté !</h5>
					<hr/>
					
					<h2> Vous êtes prêts ? C'est parti !</h2>
					
					<a class="option" href="quiz1par1.php">Commencer</a><br/>
					
					</div>
					
				</div>
			
			</div>
	</body>
	
	<?php
	include "includes/footer.php";
	include "includes/scripts.php";
	?>
</html>