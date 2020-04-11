<?php
	require_once "includes/function.php";
	session_start();
	
	$quizId = $_GET['id'];
	$nbquestion = $_GET['nb'];
	
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
			foreach ($questions as $question)
			{	
				$id=$question['ques_id'];
				$num=$question['ques_num'];
			
				if($question['ques_type']=='texte'){
					$insert_repC = getDb()->prepare("INSERT INTO reponse(rep_cont, rep_niveau, rep_estVrai, ques_id) VALUES(?,'facile','vrai',?)");
					$insert_repC->execute(array($_POST[$id.'/'.$num],$id));
				}
				
				if($question['ques_type']=='radio'){
					
					$insert_repC = getDb()->prepare("INSERT INTO reponse(rep_cont, rep_niveau, rep_estVrai, ques_id) VALUES(?,'facile','vrai',?)");
					$insert_repC->execute(array($_POST[$id.'/'.$num.'/V'],$id));
					$insert_repF = getDb()->prepare("INSERT INTO reponse(rep_cont, rep_niveau, rep_estVrai, ques_id) VALUES(?,'facile','faux',?)");
					$insert_repF->execute(array($_POST[$id.'/'.$num.'/F'],$id));
					$insert_repM = getDb()->prepare("INSERT INTO reponse(rep_cont, rep_niveau, rep_estVrai, ques_id) VALUES(?,'moyen','faux',?)");
					$insert_repM->execute(array($_POST[$id.'/'.$num.'/M'],$id));
					$insert_repD = getDb()->prepare("INSERT INTO reponse(rep_cont, rep_niveau, rep_estVrai, ques_id) VALUES(?,'difficile','faux',?)");
					$insert_repD->execute(array($_POST[$id.'/'.$num.'/D'],$id));
				}
				
				if($question['ques_type']=='checkbox'){
					
					for ($k=1;$k<=4;$k++){
					
						$niveau=$_POST[$id.'/'.$num.'/'.$k.'/niveau'];
						$estVrai=$_POST[$id.'/'.$num.'/'.$k.'/estVrai'];
						$cont=$_POST[$id.'/'.$num.'/'.$k];
						
						$insert_rep = getDb()->prepare("INSERT INTO reponse(rep_cont, rep_niveau, rep_estVrai, ques_id) VALUES(?,?,?,?)");
						$insert_rep->execute(array($cont,$niveau,$estVrai,$id));
					
					}					
				}
				redirect('index_question.php?id='.$quizId);				
			}
		}	
		
		?>		
		
		<form method="post" action="add_reponse.php?id=<?=$quizId?>&nb=<?=$nbquestions?>">

			<div id="connexion">
			
				<fieldset><legend><strong>Ajouter des réponses </strong></legend><br/>
				
				<?php 
				foreach ($questions as $question)
				{?>				
					<h2><strong>Question n° <?=$question['ques_num']?> : </strong></h2><br/>	
					<h3> Intitulé : <?=$question['ques_cont']?> </h3>
					<h4> Type : <?=$question['ques_type']?></h4>
					
					<?php 
					$num=$question['ques_num'];
					$id=$question['ques_id'];?>
										
					<?php if($question['ques_type']=='texte') //QUESTION DE TYPE TEXTE
					{ ?>
						<input type="text" name="<?=$id?>/<?=$num?>" class="form-control" placeholder="Entrez la réponse correcte :" required autofocus><br/> 
						
					<?php } ?>
					
					
					
					<?php if($question['ques_type']=='radio')//QUESTION DE TYPE choix unique
					{ ?>
						<input type="text" name="<?=$id?>/<?=$num?>/V" class="form-control" placeholder="Entrez la réponse correcte :" required autofocus><br/> 						
						<input type="text" name="<?=$id?>/<?=$num?>/F" class="form-control" placeholder="Entrez la réponse facile:" required autofocus><br/> 
						<input type="text" name="<?=$id?>/<?=$num?>/M" class="form-control" placeholder="Entrez la réponse moyenne:" required autofocus><br/>
						<input type="text" name="<?=$id?>/<?=$num?>/D" class="form-control" placeholder="Entrez la réponse difficile:" required autofocus><br/>
						
					<?php } ?>
					
					
					<?php if($question['ques_type']=='checkbox')//QUESTION DE TYPE choix multiples
					{ ?>
												
						<?php for($k=1; $k<=4; $k++)
						{ ?>								
							
							<select name="<?=$id?>/<?=$num?>/<?=$k?>/estVrai" size="3" >
								<option value="vrai">Vrai</option>
								<option value="faux">Faux</option>
							</select>
							
							<select name="<?=$id?>/<?=$num?>/<?=$k?>/niveau" size="3" >
								<option value="facile">Facile</option>
								<option value="moyen">Moyen</option>
								<option value="difficile">Difficile</option> 
							</select>
							
							<input type="text" name="<?=$id?>/<?=$num?>/<?=$k?>" class="form-control" placeholder="Entrez une reponse:" required autofocus><br/> 
								
						<?php } 
					} ?>
					
					<hr/>
					
				<?php } ?>
		
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