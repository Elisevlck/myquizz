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
		$pageTitle="Ajout de(s) type(s)";
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
				
				$insert_ques = getDb()->prepare("UPDATE question SET ques_type=? WHERE ques_id=? ");
				$insert_ques->execute(array($value,$fieled));

				header("Location: add_reponse.php?id=".$quizid);				
			}
		}
		?>
		
		
		
		<form method="post" action="add_type.php?id=<?=$quizId?>">

			<div id="connexion">
			
				<fieldset><legend><strong>Ajouter des types </strong></legend><br/> 
								
				
				<?php 
				
				$numquestion=1;
				
				foreach ($questions as $question)
				{?>				
					<h2><strong>Question n° <?=$numquestion?> : </strong></h2><br/>	
					<h3> <?=$question['ques_cont']?> </h3>
					
					<label for="quiz"><i> Type :</i></label> <br/>
					
					<input type="radio" name="<?=$question['ques_id']?>" value="texte"/><label for="type">Question ouverte</label><br/>
					<input type="radio" name="<?=$question['ques_id']?>" value="unique"/><label for="type">Réponse unique</label><br/>
					<input type="radio" name="<?=$question['ques_id']?>" value="multiple"/><label for="type">Choix multiples</label><br/>
					<hr/>
				<?php $numquestion++;
				} ?>
		
		<button type="submit" name="validation" class="boutonC"><span class="glyphicon glyphicon-log-in"></span> Valider</button><br/><br/>
		
		<?php include "includes/footer.php";
		include "includes/scripts.php";?>
	 
		<?php
		if(isset($erreur))
		{
			echo '<font color="blue"; text-align:center;>'.$erreur."</font>";
		}?>	
			
	</body>
</html>