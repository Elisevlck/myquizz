<?php
	require_once "includes/function.php";
	session_start();
	
	$quizId = $_GET['id'];
	
	$stmt = getDb()->prepare('select * from quiz where quiz_id=?');
	$stmt->execute(array($quizId));
	$lequiz = $stmt->fetch();
	
	$stmt2 = getDb()->prepare('select * from question where quiz_id=?');
	$stmt2->execute(array($quizId));
	$questions = $stmt2->fetchAll();
?>

<!DOCTYPE html>

<html>

   <?php 
		$pageTitle="Ajout des réponses(s)";
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
				
				$insert_ques = getDb()->prepare("INSERT INTO reponse(rep_cont, ques_id) VALUES(?,?)");
				$insert_ques->execute(array($value,$fieled));

				redirect('page1.php');				
			}
		}	
		
		?>		
		
		
		
		
		<form method="post" action="add_reponse.php?id="<?=$quizId?>">

			<div id="connexion">
			
				<fieldset><legend><strong>Ajouter des réponses </strong></legend><br/>
				
				
				<?php 
				
				$numquestion=1;
				//$numreponse=1;
				
				foreach ($questions as $question)
				{?>				
					<h2><strong>Question n° <?=$numquestion?> : </strong></h2><br/>	
					<h3> Intitulé : <?=$question['ques_cont']?> </h3>
					<h4> Type : <?=$question['ques_type']?></h4>
					
					
										
					<?php if($question['ques_type']=='texte') //QUESTION DE TYPE TEXTE
					{ ?>
						<input type="text" name="<?=$numquestion?>" class="form-control" placeholder="Entrez la réponse correcte :" required autofocus><br/> 
						
					<?php } ?>
					
					
					
					<?php if($question['ques_type']=='unique')//QUESTION DE TYPE choix unique
					{ ?>
						<input type="text" name="<?=$numquestion?>" class="form-control" placeholder="Entrez la réponse correcte :" required autofocus><br/> 
						
						<?php for($k=1; $k<=3; $k++)
						{ ?>								
							<input type="text" name="<?=$numquestion?>" class="form-control" placeholder="Entrez les autres reponses:" required autofocus><br/> 
								
						<?php } 
					} ?>
					
					
					<?php if($question['ques_type']=='multiple')//QUESTION DE TYPE choix multiples
					{ ?>
												
						<?php for($k=1; $k<=4; $k++)
						{ ?>								
							<input type="text" name="<?=$numquestion?>" class="form-control" placeholder="Entrez les autres reponses:" required autofocus><br/> 
								
						<?php } 
					} ?>
					
					
						
					<hr/>
				<?php $numquestion++;
				} ?>
		
				<button type="submit" name="validation" class="boutonC"><span class="glyphicon glyphicon-log-in"></span> Valider</button><br/><br/>
				
			</div>
		</form>
		
		
		<?php include "includes/footer.php";
		include "includes/scripts.php";?>
	 
		<?php
		if(isset($erreur))
		{
			echo '<font color="blue"; text-align:center;>'.$erreur."</font>";
		}?>	
			
	</body>
</html>&