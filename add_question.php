<?php
	require_once "includes/function.php";
	session_start();
	
	$quizId = $_GET['id'];
	
	$stmt = getDb()->prepare('select * from quiz where quiz_id=?');
	$stmt->execute(array($quizId));
	$lequiz = $stmt->fetch();
?>

<!DOCTYPE html>

<html>

   <?php 
		$pageTitle="Ajout de question(s)";
		require_once "includes/head.php"; 
	?>
	
	<body>
	
		<?php require_once "includes/header.php"; ?>
		
		<?php

		//validation du bouton 
		if(isset($_POST['validation']))
		{
			foreach ($_POST as $fieled => $value)
			{			
				//echo $fieled.' => '.$value.'<br/>';
				
				$insert_ques = getDb()->prepare("INSERT INTO question(ques_cont, quiz_id) VALUES(?,?)");
				$insert_ques->execute(array($value,$quizId));

				header("Location: add_type.php?id=".$quizId);		
			}
		}
		?>
		
		
		     
		<form method="post" action="add_question.php?id=<?=$quizId?>">

			<div id="connexion">
			
				<fieldset><legend><strong>Ajouter des questions </strong></legend><br/> 
													
					<?php for($numquestion=1; $numquestion<=$lequiz['nbquestions']; $numquestion++) 
					{?>
							
							<h2><strong>Question n° <?=$numquestion?> : </strong></h2><br/>		
							 
							<label for="quiz"><i>Intitulé :</i></label> 
							<input type="text" name="<?=$numquestion?>" class="form-control" placeholder="Entrez l'intitulé de la question :" required autofocus><br/> 
							
							<hr/>
						
					<?php } ?>
						
				</fieldset>
				<button type="submit" name="validation" class="boutonC"><span class="glyphicon glyphicon-log-in"></span> Valider</button><br/><br/>
            </div>             
        </form>
		
	<?php include "includes/footer.php";
	include "includes/scripts.php";?>
 
	</body>
</html>


