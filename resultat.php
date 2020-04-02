<?php
	require_once "includes/function.php";
	session_start();
	
	$quizId = $_GET['id'];
	
	$stmt = getDb()->prepare('select * from quiz where quiz_id=?');
	$stmt->execute(array($quizId));
	$quizs = $stmt->fetch(); // Access first (and only) result line
	
	$stmt2 = getDb()->prepare('select * from question where quiz_id=?');
	$stmt2->execute(array($quizId));
	$questions = $stmt2->fetchAll(); // Access first (and only) result line	
	
	$stmt3 = getDb()->prepare('select * from reponse');
	$stmt3->execute(array());
	$reponses = $stmt3->fetchAll(); // Access first (and only) result line	
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
								echo $fieled.'<br/>';
								
								$req = getDb()->prepare('select * from question where ques_id=?');
								$req->execute(array($fieled));
								$laquestion = $req->fetch();
								
								$req1 = getDb()->prepare('select * from reponse where ques_id=? AND rep_estVrai="vrai"');
								$req1->execute(array($fieled));
								$labonnereponse = $req1->fetch();
								
								if ($laquestion['ques_type']=="texte")//texte OK
								{
									echo "<strong>".$i.") ".$laquestion['ques_cont'].'<br/></strong>';
									echo 'Votre réponse '.$fieled.' est : '.$value.'<br/>';
									echo "La bonne réponse était : ".$labonnereponse['rep_cont'].'<br/>';
									
									if ($value==$labonnereponse['rep_cont'])
									{
										$score++;
									}									
								}
								
								if ($laquestion['ques_type']=="unique") //radio OK
								{
									echo "<strong>".$i.") ".$laquestion['ques_cont'].'<br/></strong>';
									echo 'Votre réponse '.$fieled.' est : '.$value.'<br/>';
									echo "La bonne réponse était : ".$labonnereponse['rep_cont'].'<br/>';
									
									if ($value==$labonnereponse['rep_cont'])
									{
										$score++;
									}
								}
								
								echo '<br/>';
								$i++;
							
								// PROBLEME AVEC LE CHECKBOX
							
								/*if ($laquestion['ques_type']=="multiple")
								{
									$checkbox="";
									
									foreach($_POST['rep'] as $rep)
									{					
										$checkbox=$checkbox." ".$rep;
									}
									echo "La chaine contient : ".$checkbox."<br/>";
						
									$choix = explode(" ", $checkbox);
								
									for($i=1;$i<count($choix);$i++)
									{
										echo "Element ".$i."= ".$choix[$i]."<br/>";
									}
								}*/								
							}
							echo "Le score est de : ".$score."/".$quizs['nbquestions'];;
				}
						
						
					echo '<br/>';	
									 
				 ?>
				
			</div>
		</div>
	</body>
</html>
