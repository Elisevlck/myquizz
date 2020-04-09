<?php
	require_once "includes/function.php";
	session_start();
	
	$quizId = $_GET['id'];
	
	$stmt = getDb()->prepare('select * from quiz where quiz_id=?'); // récupère toutes les informations du quiz 
	$stmt->execute(array($quizId));
	$quizs = $stmt->fetch(); 
	$quizNom=$quizs['quiz_nom'];
	
	$stmt2 = getDb()->prepare('select * from question where quiz_id=?'); // récupère toutes les questions du quiz
	$stmt2->execute(array($quizId));
	$questions = $stmt2->fetchAll(); 
	
	$stmt3 = getDb()->prepare('select * from reponse');//récupère toutes les réponses
	$stmt3->execute(array());
	$reponses = $stmt3->fetchAll(); 
?>

<!doctype html>

<html>

	<?php 
		$pageTitle = $quizs['quiz_nom'];
		require_once "includes/head.php"; 
	?>
	
	<body>
	
		<div class="container">
		
			<?php require_once "includes/header.php"; ?>		
			<div class="jumbotron">
				
				<?php if(isset($_POST['validation'])) //validation du bouton 
				{?>				
				
				<h2><strong>Correction : </strong></h2><br/>
								
					<?php $i=1;
							$score=0;
						
							foreach ($_POST as $fieled => $value)
							{		
								/*print_r($fieled);
								var_dump($fieled);
								print_r($value);
								echo $fieled.' = '.$value.'<br/>';*/
								
								$req = getDb()->prepare('select * from question where ques_id=?');//je récupère les info de chaque question
								$req->execute(array($fieled));
								$laquestion = $req->fetch();
								
								$req1 = getDb()->prepare('select * from reponse where ques_id=? AND rep_estVrai="vrai"');//la réponse effectivement vraie
								$req1->execute(array($fieled));
								$labonnereponse = $req1->fetch();	
									
								if ($laquestion['ques_type']=="texte" OR $laquestion['ques_type']=="radio"){
									echo "<strong>".$i.") ".$laquestion['ques_cont'].'<br/></strong>';
									echo 'Votre réponse est : '.$value.'<br/>';
									echo "La bonne réponse était : ".$labonnereponse['rep_cont'].'<br/>';
									
									if ($value==$labonnereponse['rep_cont'])
									{
										$score++;
									}	
								}	
								$i++;
							}	
						
									
				}
							echo "Le score est de : ".$score."/".$quizs['nbquestions']."<br/>";
							/*
							$insert_partie = getDb()->prepare("INSERT INTO partie(part_score, quiz_id) VALUES(?,?)");
							$insert_partie->execute(array($score,$quizId));*/
					
				 ?>
				
			</div>
		</div>
	</body>
</html>
