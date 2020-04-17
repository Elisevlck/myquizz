<?php
	require_once "includes/function.php";
	session_start();
	verifConnexion();
	verifAdmin();

	$genreId = $_GET['id'];
	
	$recup_genre = getDb()->prepare('select * from genre where genre_id=?');
	$recup_genre->execute(array($genreId));
	$genre = $recup_genre->fetch();
	
	$recup_themes = getDb()->prepare('select * from theme where genre_id=?');
	$recup_themes->execute(array($genreId));
	$themes = $recup_themes->fetchAll();
	
?>

<!doctype html>

<html>

	<?php 
		$pageTitle = "Supprimer des thèmes";
		require_once "includes/head.php"; 
	?>

	<body>	
	
		<?php require_once "includes/header.php"; ?>
		
		    <?php

    				if(isset($_POST['validation']))
    				{
    				    if(isset($_POST['choix']))
    				    {
    				        foreach($_POST['choix'] as $choix)
            				{	
            					$recup_quiz = getDb()->prepare('select * from quiz where theme_id=?');
        	                    $recup_quiz->execute(array($choix));
        	                    $quizs = $recup_quiz->fetchAll();
        	                   
        	                    foreach($quizs as $quiz)
            				    {  
            				        $suppr_partie = getDb()->prepare("DELETE FROM partie WHERE quiz_id = ?");
            				        $suppr_partie->execute(array($quiz['quiz_id']));
            				        
                    				$recup_ques = getDb()->prepare('select * from question where quiz_id=?');
        	                        $recup_ques->execute(array($quiz['quiz_id']));
        	                        $questions = $recup_ques->fetchAll();
        	                        
        	                        foreach($questions as $question)
        	                        {
        	                            $suppr_reponse = getDb()->prepare("DELETE FROM reponse WHERE ques_id = ?");
            				            $suppr_reponse->execute(array($question['ques_id']));
        	                        }
        	                            
        	                        $suppr_question = getDb()->prepare("DELETE FROM question WHERE quiz_id = ?");
            				        $suppr_question->execute(array($quiz['quiz_id']));
            				        
        	                   }
        	                   
        	                   $suppr_quiz = getDb()->prepare("DELETE FROM quiz WHERE theme_id = ?");
            				   $suppr_quiz->execute(array($choix));
            				   
            				   $suppr_theme = getDb()->prepare("DELETE FROM theme WHERE theme_id = ?");
            				   $suppr_theme->execute(array($choix));
            				}
            				header("Location: index.php");
    				    }
    				    else
        			    {
        					    $erreur="Veuillez sélectionner au moins un thème !";
        				}
    				}
				?>
     
		
			<div class="conteneurconex">
				
				<form method="post" action="suppr_theme.php?id=<?=$genreId?>">

					<div id="connexion">
					
    					<h1> Genre : <?=$genre['genre_nom']?> </h1>				
    					<fieldset><legend><strong>Supprimer un/plusieurs thèmes </strong></legend><br/> 
    					
        					<?php 
        					foreach ($themes as $theme)
        					{ ?>
        						<label><input type="checkbox" name="choix[]" value="<?= $theme['theme_id'] ?>" require/> <?= $theme['theme_nom'] ?></label><br/><?php
        					} ?>
        				   
        					<br/><button type="submit" name="validation" class="boutonC"><span class="glyphicon glyphicon-log-in"></span> Valider</button><br/>
        					
        					<?php
                        	if(isset($erreur))
                        	{
                        		echo '<br/><font color="blue"; text-align:center;>'.$erreur."</font>";
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