<?php
	require_once "includes/function.php";
	session_start();
	verifConnexion();
	verifAdmin();

	$quizId = $_GET['id'];
	
	$recup_quiz = getDb()->prepare('select * from quiz where quiz_id=?');
	$recup_quiz->execute(array($quizId));
	$quiz = $recup_quiz->fetch();
	
	$recup_ques = getDb()->prepare('select * from question where quiz_id=?');
	$recup_ques->execute(array($quizId));
	$questions = $recup_ques->fetchAll();	
?>

<!doctype html>

<html>

	<?php 
		$pageTitle = "Supprimer des quiz";
		require_once "includes/head.php"; 
	?>

	<body>	
	
		<?php include "includes/header.php"; ?>
		
			<div class="conteneurconex2">
			    
			    <?php

    				if(isset($_POST['validation']))
    				{				
    			        $nombreQues=$quiz['nbquestions'];
    			        
    				    if (isset($_POST['choix']))
    				    {
    				        foreach($_POST['choix'] as $choix)
        					{	
        					    $suppr_rep = getDb()->prepare("DELETE FROM reponse WHERE ques_id = ?");
        						$suppr_rep->execute(array($choix));
        						
        						$suppr_ques = getDb()->prepare("DELETE FROM question WHERE ques_id = ?");
        						$suppr_ques->execute(array($choix));
        						
        						$nombreQues=$nombreQues-1;
        					}
        					
        					$actu_nbQues=getDb()->prepare("update quiz set nbquestions=? where quiz_id=?");
        					$actu_nbQues->execute(array($nombreQues,$quizId));
        					
        					header("Location: index_question.php?id=".$quizId);
    				    }
    				    else
    				    {
    				        $erreur="Veuillez sélectionner au moins une question!";
    				    }
    				
    				}
				?>
     
				<form method="post" action="suppr_question.php?id=<?=$quizId?>">

					<div id="connexion">
    					
    					<h1> Quiz : <?=$quiz['quiz_nom']?> </h1>				
    					<fieldset><legend><strong>Supprimer une/plusieurs question(s)</strong></legend><br/> 
    					
    					<?php foreach ($questions as $ques){ ?>
    						<label><input type="checkbox" name="choix[]" value="<?= $ques['ques_id'] ?>"/> <?= $ques['ques_cont'] ?></label><br/>
    					<?php } ?>
    				   
    					<button type="submit" name="validation" class="boutonC"><span class="glyphicon glyphicon-log-in"></span> Valider</button><br/><br/>
    					
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