<?php
	require_once "includes/function.php";
	session_start();
	
	$quizId = $_GET['id'];
	$niveau = $_GET['niv'];
	
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

<html>
	<body>
	
		<?php
		
			foreach ($questions as $question){
				
				echo "<strong>".$question['ques_cont'].'<br/></strong>';
				/*
				if ($question['ques_type']="texte"){
					
					$id=$question['ques_id'];
					$mareponse=$_POST[$id];
					
					$req1 = getDb()->prepare('select * from reponse where ques_id=? AND rep_estVrai="vrai"');//la réponse effectivement vraie
					$req1->execute(array($id));
					$labonnereponse = $req1->fetch();
					
					echo 'Votre réponse '."est : ".$mareponse.'<br/>';
					echo "La bonne réponse était : ".$labonnereponse['rep_cont'].'<br/>';
									
					if ($mareponse==$labonnereponse['rep_cont'])
					{
						echo'bonnereponse!<br/>';
					}						
				}
				
				if ($question['ques_type']="radio"){
					
					$id=$question['ques_id'];
					$mareponse=$_POST[$id];
					
					$req1 = getDb()->prepare('select * from reponse where ques_id=? AND rep_estVrai="vrai"');//la réponse effectivement vraie
					$req1->execute(array($id));
					$labonnereponse = $req1->fetch();
					
					echo 'Votre réponse '."est : ".$mareponse.'<br/>';
					echo "La bonne réponse était : ".$labonnereponse['rep_cont'].'<br/>';
									
					if ($mareponse==$labonnereponse['rep_cont'])
					{
						echo'bonnereponse!<br/>';
					}						
				}*/
							
				
				// LES QUESTIONS MULTIPLES--------------------------------------------------------------------------------------------------------------
			
				if ($question['ques_type']="checkbox"){
					
					$id=$question['ques_id'];
					
					if ($niveau=="facile") {	
						$req = getDb()->prepare('select count(*) AS compteur from reponse where ques_id=? AND rep_estVrai="vrai" AND rep_niveau=?');
						$req->execute(array($id,$niveau));
						$nbVrai = $req->fetch(); 
					}	
					if ($niveau=="moyen") {					
						$req = getDb()->prepare('select count(*) AS compteur from reponse where ques_id=? AND rep_estVrai="vrai" AND (rep_niveau=? OR rep_niveau="facile")');
						$req->execute(array($id,$niveau));
						$nbVrai = $req->fetch(); 
					}	
					if ($niveau=="difficile") {					
						$req = getDb()->prepare('select count(*) AS compteur from reponse where ques_id=? AND rep_estVrai="vrai"');
						$req->execute(array($id));
						$nbVrai = $req->fetch();
					}					
					$nbVrai=$nbVrai['compteur'];			
					echo "nombre de réponses vraies : ".$nbVrai."<br/>";
					
					//$chaine="";
					
					foreach($_POST['reponse'.$id.''] as $fieled=>$value)
					{					
						//echo $fieled." => ".$value."<br/>";
						//$chaine=$chaine." ".$value;
						
						echo $value;
						
						$req1 = getDb()->prepare('select * from reponse where rep_cont=?');
						$req1->execute(array($value));
						$repbdd = $req1->fetch();						
						
						//echo $repbdd['rep_estVrai'];
						
						/*if ($repbdd['rep_estVrai']=="vrai")
							echo 'bonne réponse <br/>';
						else
							echo 'mauvaise réponse <br/>';	*/
						
						/*
						$req1 = getDb()->prepare('select * from reponse where ques_id=? AND rep_estVrai="vrai"');//la réponse effectivement vraie
						$req1->execute(array($fieled));
						$bonnesrep= $req1->fetchAll();
						$bonne=0;
						
						foreach ($bonnesrep as $brep){
							
							if ($value==$brep['rep_cont'])
								$bonne=1; 
						}						
						if ($bonne=1)
							echo "Bonne réponse! <br/>";
						if ($bonne=0)
							echo 'Mauvaise réponse!<br/>';	
						*/
					}
					//echo "Les réponses entrées sont : ".$chaine.'<hr/>';
				}
			}	
		?>
	</body>
</html>	

