<?php
	require_once "includes/function.php";
	session_start();
	
	$quizId = $_GET['id'];
	$niveau = $_GET['niv'];
	$themeId=$_GET['tId'];
	
	$stmt = getDb()->prepare('select * from quiz where quiz_id=?'); // récupère toutes les informations du quiz 
	$stmt->execute(array($quizId));
	$quizs = $stmt->fetch(); 
	$quizNom=$quizs['quiz_nom'];
	
	$stmt2 = getDb()->prepare('select * from question where quiz_id=?'); // récupère toutes les questions du quiz
	$stmt2->execute(array($quizId));
	$questions = $stmt2->fetchAll(); 
	
	$stmt3 = getDb()->prepare('select * from theme where theme_id =?');
	$stmt3->execute(array($themeId));
	$themes = $stmt3->fetch(); 
		
	$stmt4 = getDb()->prepare('select * from utilisateur where ut_nom=?');
	$stmt4->execute(array($_SESSION['login']));
	$Id = $stmt4->fetch(); 
	$utId = $Id['ut_id'];
?>

<html>

	<?php 
		$pageTitle = $quizs['quiz_nom']." : Correction";
		require_once "includes/head.php"; 
	?>
	
	<body>
	
			<?php require_once "includes/header.php"; ?>

			<div class="conteneurconex">
		
			<div id="connexion">
			
				<h1> Correction : <?=$quizNom?> </h1>
				
				
		<?php
		
			$score=0;
			$nbQues=0;
		
			foreach ($questions as $question)
			{
				
				$nbQues++;
				$point=0;
				//echo "<strong>".$question['ques_cont'].'<br/></strong>';
				$id=$question['ques_id'];
				
				// LES QUESTIONS TEXTE ET RADIO --------------------------------------------------------------------------------------------------------------
				
				if ($question['ques_type']=="texte" OR $question['ques_type']=="radio"){
					
					$recup_bdd = getDb()->prepare('select * from reponse where ques_id=?');
					$recup_bdd->execute(array($id));
					$bonnerep = $recup_bdd->fetch();
					
					if ($question['ques_type']=="radio")
						$bonnerep['rep_cont']=" ".$bonnerep['rep_cont'];
					
					if ($_POST[$id]==$bonnerep['rep_cont'])
						$point=1;
					//echo "Votre réponse : ".$_POST[$id]." donc ".$point." point(s)<br/>";
				}
								
				// LES QUESTIONS MULTIPLES--------------------------------------------------------------------------------------------------------------
			
				if ($question['ques_type']=="checkbox"){
					
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
					//echo "nombre de réponses vraies : ".$nbVrai."<br/><br/>";
										
					// ------------------------------------------------------------------------------------ 
					
					$nbChoix=0;
					$nbBonneRep=0;
					$chaine="";
					
					foreach($_POST['reponse'.$id.''] as $fieled=>$value)
					{	
						$nbChoix++;
					
						$chaine=$chaine." ".$value;
					
						if ($nbVrai=="1"){
							
							$req1 = getDb()->prepare('select * from reponse where ques_id=? and rep_estVrai="vrai"'); // toutes les réponses associées à la question
							$req1->execute(array($id));
							$repbdd=$req1->fetch();//une seule réponse
							$bonnerep=" ".$repbdd['rep_cont'];
							
								if ($bonnerep==$value)
									$nbBonneRep++;
									
						}
						else {							
							
							$req1 = getDb()->prepare('select * from reponse where ques_id=? and rep_estVrai="vrai"'); // toutes les réponses associées à la question
							$req1->execute(array($id));
							$repbdd=$req1->fetchAll();//plusieurs réponses
							
							foreach ($repbdd as $rep){
								
								$rep['rep_cont']=" ".$rep['rep_cont'];
								if ($rep['rep_cont']==$value)
									$nbBonneRep++;
							}
						}
					}				
					
					if ($nbVrai==$nbChoix && $nbChoix==$nbBonneRep)
						$point=1;
					
					//echo "Votre réponse : ".$chaine." donc ".$point." point(s) (".$nbBonneRep."/".$nbVrai.")<br/>";
					
				}//------------------------FIN DU IF CHECKBOX
				
				
				$score=$score+$point;
			}//--------------------------FIN DU FOREACH QUESTION
			
			//echo "Le score est : ".$score.'/'.$nbQues;
			$rapport_score = $score/$nbQues;
			$nbr = round($rapport_score, 3);
			echo "Taux de réussite : ".$nbr*100 .' %<br/>';
			
			$debut = $_POST['validation'];
			$time = time() - $debut;
			echo  "Chronomètre : ".$time." secondes<br/>";		
			$date = date("Y-m-d");
							
			//insertion resultat partie
			$insert_partie=getDb()->prepare("INSERT INTO partie(part_score, part_temps,part_date,quiz_niveau,quiz_id,ut_id) VALUES(?,?,?,?,?,?)");
			$insert_partie->execute(array($rapport_score,$time,$date,$niveau,$quizId,$utId));
						
			//meilleur résultat
			$resultat=getDb()->prepare("select * from partie where ut_id=? and quiz_id=? order by part_score desc limit 1");
			$resultat->execute(array($utId,$quizId));
			$parties=$resultat->fetch();
			
	
			if($parties['part_score'] == 1.000)
			{				
				//requete chrono min
				$resultat=getDb()->prepare("select * from partie where part_score=? order by part_temps limit 1");
				$resultat->execute(array("1.000"));
				$chrono=$resultat->fetch();
				
				
				echo "Votre meilleur taux de réussite à ce quizz est de : ".$parties['part_score']*100 .' %';
				echo '<br/>';
				echo "Avec pour chronomètre : ".$chrono['part_temps'];
			
			}
			else
			{
				echo "Votre meilleur taux de réussite à ce quizz est de : ".$parties['part_score']*100 .' %';
			}
			
			?>
			<br/><a class="option" href="page1.php">Retour à l'acceuil</a>
			
		
		</div>
		</div>
		
		
	</body>
</html>	

