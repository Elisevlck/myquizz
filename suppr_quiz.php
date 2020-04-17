<?php
	require_once "includes/function.php";
	session_start();
	verifConnexion();
	verifAdmin();

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
	
		<?php require_once "includes/header.php"; ?>
		
			<div class="conteneurconex">
			
				<?php

    				if(isset($_POST['validation']))
    				{
    				    if (isset($_POST['choix']))
    				    {
        					foreach($_POST['choix'] as $choix)
            				{  
            				    $suppr_parties = getDb()->prepare("DELETE FROM partie WHERE quiz_id = ?");
            				    $suppr_parties->execute(array($choix));
            				    
                    			$recup_ques = getDb()->prepare('select * from question where quiz_id=?');
        	                    $recup_ques->execute(array($choix));
        	                    $questions = $recup_ques->fetchAll();
        	                        
        	                    foreach($questions as $question)
        	                    {
        	                        $suppr_reponses = getDb()->prepare("DELETE FROM reponse WHERE ques_id = ?");
            				        $suppr_reponses->execute(array($question['ques_id']));
        	                    }
        	                        
        	                    $suppr_questions = getDb()->prepare("DELETE FROM question WHERE quiz_id = ?");
            				    $suppr_questions->execute(array($choix));
            				    
            				    $suppr_quiz = getDb()->prepare("DELETE FROM quiz WHERE quiz_id = ?");
            				    $suppr_quiz->execute(array($choix));
        	                    
        	               }
        	               header("Location: index_quiz.php?id=".$themeId);
        	 	    	}   
    				    else
    				    {
    				        $erreur="Veuillez sélectionner au moins un quiz!";
    				    }
    				}
				?>
     
				<form method="post" action="suppr_quiz.php?id=<?=$themeId?>">

					<div id="connexion">
					
    					<h1> Thème : <?=$theme['theme_nom']?> </h1>				
    					<fieldset><legend><strong>Supprimer un/plusieurs quiz</strong></legend><br/> 
    					
    					<?php foreach ($quizs as $quiz){ ?>
    						<label><input type="checkbox" name="choix[]" value="<?= $quiz['quiz_id'] ?>"/> <?= $quiz['quiz_nom'] ?></label><br/>
    					<?php } ?>
    				   
    					<button type="submit" name="validation" class="boutonC"><span class="glyphicon glyphicon-log-in"></span> Valider</button><br/>
    					
    					<?php
                        if(isset($erreur))
                        {
                        	echo '<font color="blue"; text-align:center;>'.$erreur."</font>";
                        }
                        ?>
                        </fieldset> 
					
					</div>  
					
				</form>
				
		    </div>
	</body>

	<?php require_once "includes/footer.php"; ?>
	<?php require_once "includes/scripts.php"; ?>

</html>