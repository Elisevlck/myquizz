<?php
	require_once "includes/function.php";
	session_start();

	$quizId = $_GET['id'];
	$niveau = $_GET['niv'];
	$themeId=$_GET['tId'];
	$numQues=$_GET['num'];
	$scoreActu=$_GET['score'];
	
	$stmt = getDb()->prepare('select * from quiz where quiz_id=?');
	$stmt->execute(array($quizId));
	$quizs = $stmt->fetch(); 
	$quizNom=$quizs['quiz_nom'];
	
	$stmt2= getDb()->prepare('select * from utilisateur where ut_nom=?');
	$stmt2->execute(array($_SESSION['login']));
	$Id = $stmt2->fetch(); 
	$utId = $Id['ut_id'];
?>

<html>

	<?php 
		$pageTitle = $quizs['quiz_nom'];
		require_once "includes/head.php"; 
	?>
	
	<body>
	
		<?php require_once "includes/header.php"; ?>
		
		<div class="conteneurconex">
		
			<div id="connexion">
			
				<h1> Correction : <?=$quizs['quiz_nom']?> </h1>
				
			<?php
			
			//echo "Le score est : ".$scoreActu.'/'.$quizs['nbquestions'];
			echo '<br/>';
			$rapport_score = $scoreActu/$quizs['nbquestions'];
			echo '<br/>';
			$nbr = round($rapport_score, 3);
			echo "Taux de réussite : ".$nbr*100 .' %';

			echo '<br/>';
			$debut = $_GET['tps'];			
			$time=time()- $debut;
			echo  "Chronomètre : ".$time." secondes\n";				
			echo '<br/>';
		
			$date = date("Y-m-d");
			
			//insertion resultat partie
			$insert_partie=getDb()->prepare("INSERT INTO partie(part_score, part_temps,part_date,quiz_id,ut_id,quiz_niveau) VALUES(?,?,?,?,?,?)");
			$insert_partie->execute(array($rapport_score,$time,$date,$quizId,$utId,$niveau));
						
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
			
			<br/>
			<a class="option" href="page1.php">Retour à l'acceuil</a>
				
			</div>
		</div>
		<?php include "includes/footer.php";
		include 'includes/scripts.php';?>
	</body>
</html>