<!DOCTYPE html>


	<?php 
		require_once "includes/function.php";		
		session_start();
		$quizs = getDb()->query('select * from utilisateur'); 	
		include "includes/head.php";
	?>
	
<html>     
	<body>
	
<?php require_once "includes/header.php";
		
	
	$stmt=getDb()->prepare("select * from utilisateur where ut_nom=?");
	$stmt->execute(array($_SESSION['login']));
	$Id = $stmt->fetch(); 
	$utId = $Id['ut_id'];
	
	$stmt2 = getDb()->prepare('select * from partie where ut_id=? order by quiz_nom');
	$stmt2->execute(array($utId));
	$parties = $stmt2->fetchAll();
	
	$stmt3 = getDb()->prepare('select quiz_nom from partie where ut_id =? order by quiz_nom');
	$stmt3->execute(array($utId));
	$quiz = $stmt3->fetchAll();



?>	

<h2><strong>Mon historique :</strong></h2>
<br/><br/>
		
			
			<?php 
			$i=0;
		
			foreach($parties as $partie)
			{		
			$i++;	
			?>
			
				<strong><?=$i?> - partie(s) :</strong><br/>
				<br/>Quiz : <?=$partie['quiz_nom'];?>
				<br/>Date : <?=$partie['part_date'];?>
				<br/>Temps : <?=$partie['part_temps'];?>
				<br/>Score : <?=$partie['part_score']*100 .' %';?>
				<br/><br/>
		
						
						
			<?php 
			} ?>
			
<h2><strong>Mes statistiques :</strong></h2>
<br/><br/>

<?php
		
			echo '<br/>';
			echo "Vous avez joué : ".$i." partie(s) !";
			// echo "Vous avez joué : ".$nbquiz." quiz différent(s) !";
			
		
			$moyenne=0;
			$i=0;
			$j=0;
			$nomquiz='';
			
			//pourcentage réussite totale (moyenne de tout pourcentage)*100
			foreach($parties as $partie)
			{		
			$i++;
			$moyenne=$moyenne+$partie['part_score'];
			
			}
			echo '<br/>';			
			echo "Votre taux de réussite général : ".($moyenne/$i)*100 ." %";
			

			
			$req=getDb()->prepare('select quiz_nom,COUNT(DISTINCT (quiz_nom)) from partie where ut_id=? group by quiz_nom');
			$req->execute(array($utId));
			$nbquiz=$req->fetchAll();
			
	
			echo '<br/>';	
			echo '<br/>';			
			foreach($nbquiz as $row)
			{					
				$nomquiz = $nomquiz.' <br/> '.$row['quiz_nom'];		
				echo '<br/>';
				$j++;
			}
			echo 'Vous avez joué à : '.$j.' quiz(s) !';	
			echo '<br/>';
			echo 'Vous avez joué à : '.$nomquiz;
			
			
			//meilleur résultat
			
			
			
			
			$score=getDb()->prepare("select quiz_nom, MAX(part_score) from partie where ut_id=? ");
			$score->execute(array($utId));
			$bestscore=$score->fetchAll();
			
			
			foreach($bestscore as $result)
			{
				
				foreach($parties as quizzs)
				{
					$resultat=getDb()->prepare("select MAX(part_score),quiz_nom from partie where ut_id=?");
					$resultat->execute(array($utId));
					$score=$resultat->fetch();
					echo '<br/>';
					echo $score['quiz_nom'].' : '.$score['MAX(part_score)']*100 .' %';
				}
			}
	
	
			if(isset($msg))
			{
				echo '<font color="blue"; text-align:center;>'.$msg."</font>";
			}
			include('includes/footer.php'); 
			include('includes/scripts.php'); 
			?>	

	</body>
</html>