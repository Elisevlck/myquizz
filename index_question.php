<?php
	require_once "includes/function.php";
	session_start();
	verifConnexion();
	verifAdmin();

	$quizId = $_GET['id'];
	$_SESSION['quiz']=$quizId;
	
	$recup_quiz = getDb()->prepare('select * from quiz where quiz_id=?');
	$recup_quiz->execute(array($quizId));
	$quizs = $recup_quiz->fetch();
	
	$recup_ques = getDb()->prepare('select * from question where quiz_id=?');
	$recup_ques->execute(array($quizId));
	$questions = $recup_ques->fetchAll();
?>

<!doctype html>

<html>

	<?php 
		$pageTitle = $quizs['quiz_nom'];
		require_once "includes/head.php"; 
	?>

	<body>	
		
		<?php include "includes/header.php"; ?>
		
		<?php

    		if(isset($_POST['validation']))
    		{
    		    $nb=trim($_POST['nb']);
    		    
    		    if((preg_match('/^[0-9\-]+$/i',$nb)))
    		    {
    		        header("Location: add_question.php?id=".$quizId."&nb=".$nb);
    		    }
    		    else
    		    {
    		        $erreur="Veuillez saisir un nombre entier !";
    		    }
    		}
		?>
		
		<div class="containeurGlobal">
		    
			<div class="infoBase">
				
				<div id="infoBaseInt">
			
				    <h1><strong> Quiz : <?=$quizs['quiz_nom'] ?> </strong></h1>
					
					<form method="post" action="index_question.php?id=<?=$quizId?>">
						<em>Ajout de questions :</em>
						<input type="text" name="nb" class="formTexte" placeholder="Saisir un nombre" size=2 style="width:20%" required autofocus>
						<button type="submit" name="validation" class="boutonC"><span class="glyphicon glyphicon-log-in"></span> Ajouter</button><br/><br/>
						<a class="option" href="suppr_question.php?id=<?= $quizId ?>">Suppression de questions</a>
						
						<?php
						if (isset($erreur))
						    echo '<br/><font color="blue"; text-align:center;>'.$erreur."</font>";
						?>
						
					</form>
					
				</div>
				
			</div>
				
			<?php 
			foreach ($questions as $question) { ?>
			
				<div class="element">
						
					<div id="elementInt">
						
			    		<strong><?= $question['ques_cont']?></strong> 
						<a class="option" href="modif_question.php?id=<?=$question['ques_id']?>">Modifier</a>
						<br/><br/>
						
						<?php 
						
    					$extension=strrchr($question['ques_media'],'.');
    					$extensionsImg = array('.jpg', '.JPG','.jpeg','.JPEG', '.gif', '.GIF', '.PNG', '.png');	
                			 
                	    if(in_array($extension, $extensionsImg)) 
    	                {
    					    echo '<img class="imgQues" src="'.$question['ques_media'].'" alt="photopays" title="Nommez ce pays"/><br/><br/>';
    					}
    					if (($extension=='.mp4') OR ($extension=='.MP4'))
    					{
    					    echo '<video src='.$question['ques_media']." controls width="."400"."></video><br/>";
    					}
    					if (($extension=='.mp3') OR ($extension=='.MP3'))
    					{
    					   echo '<audio src='.$question['ques_media']." controls width="."400"."></audio><br/>";
    					}
    						
						
						$recup_reponses = getDb()->prepare('select * from reponse where ques_id=?');
						$recup_reponses->execute(array($question['ques_id']));
						$reponses = $recup_reponses->fetchAll();
						
						echo '  | ';
							
						foreach ($reponses as $reponse)
						{ 
								
							if ($reponse['rep_estVrai']=='vrai')
								echo '<font color=red><strong>'.ucwords($reponse['rep_cont']).' </strong></font>';
							else 
								echo ucwords($reponse['rep_cont']).'';
							echo '  | ';
						}
						?>
							
							
					</div>
				</div>
					
			<?php } ?>				
				
	    </div>
	    
    </body>
    
	<?php require_once "includes/footer.php"; ?>
	<?php require_once "includes/scripts.php"; ?>
	
</html>