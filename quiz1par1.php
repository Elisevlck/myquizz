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
	
	$stmt2 = getDb()->prepare('select * from question where quiz_id=? and ques_num=?'); // je récupère la question
	$stmt2->execute(array($quizId,$numQues));
	$question = $stmt2->fetch();
	
	if ($niveau=="facile") {
	
	$stmt3 = getDb()->prepare('select * from reponse where rep_niveau=?');
	$stmt3->execute(array($niveau));
	$reponses = $stmt3->fetchAll(); 
	}	
	if ($niveau=="moyen") {
	
	$stmt3 = getDb()->prepare('select * from reponse where rep_niveau=? OR rep_niveau="facile"');
	$stmt3->execute(array($niveau));
	$reponses = $stmt3->fetchAll(); 
	}	
	if ($niveau=="difficile") {
	
	$stmt3 = getDb()->prepare('select * from reponse');
	$stmt3->execute(array());
	$reponses = $stmt3->fetchAll();
	}
	$stmt4 = getDb()->prepare('select * from theme where theme_id =?');
	$stmt4->execute(array($themeId));
	$themes = $stmt4->fetch(); 	
?>

<html>

	<?php 
		$pageTitle = $quizs['quiz_nom'];
		require_once "includes/head.php"; 
	?>
	
	<body>
	<?php
		//validation du bouton 
		if(isset($_POST['validation']))
		{	
			$id=$question['ques_id'];
			
			if ($question['ques_type']=="texte" OR $question['ques_type']=="radio"){
				
					$rep=trim($_POST['rep']); //trim->sécuriser la variable
					
					$recup_bdd = getDb()->prepare('select * from reponse where ques_id=?');
					$recup_bdd->execute(array($id));
					$bonnerep = $recup_bdd->fetch();
					
					/*if ($question['ques_type']=="radio")
						$bonnerep['rep_cont']=" ".$bonnerep['rep_cont'];*/
					
					if ($rep==$bonnerep['rep_cont'])
						$point=1;
			}
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
					
					$nbChoix=0;
					$nbBonneRep=0;
					$chaine="";
					
					foreach($_POST['rep'] as $fieled=>$value)
					{	
						$nbChoix++;
					
						$chaine=$chaine." ".$value;
					
						if ($nbVrai=="1"){
							
							$req1 = getDb()->prepare('select * from reponse where ques_id=? and rep_estVrai="vrai"'); // toutes les réponses associées à la question
							$req1->execute(array($id));
							$repbdd=$req1->fetch();//une seule réponse
							//$bonnerep=" ".$repbdd['rep_cont'];
							
								if ($repbdd['rep_cont']==$value)
									$nbBonneRep++;
									
						}
						else {							
							
							$req1 = getDb()->prepare('select * from reponse where ques_id=? and rep_estVrai="vrai"'); // toutes les réponses associées à la question
							$req1->execute(array($id));
							$repbdd=$req1->fetchAll();//plusieurs réponses
							
							foreach ($repbdd as $rep){
								
								//$rep['rep_cont']=" ".$rep['rep_cont'];
								if ($rep['rep_cont']==$value)
									$nbBonneRep++;
							}
						}
					}				
					
					if ($nbVrai==$nbChoix && $nbChoix==$nbBonneRep)
						$point=1;
					
			}
			$scoreActu=$scoreActu+$point;
			$numQues=$numQues+1;
						
			redirect('quiz1par1.php?id='.$quizId.'&tId='.$themeId.'&niv='.$niveau.'&num='.$numQues.'&score='.$scoreActu);
		}
	?>
	
		<?php 
			
			if ($numQues>$quizs['nbquestions']){
				redirect('resultat1par1.php?id='.$quizId.'&tId='.$themeId.'&niv='.$niveau.'&num='.$numQues.'&score='.$scoreActu);
			}
			
			else{			
			?>
		
			<div class="container">
				<?php require_once "includes/header.php"; ?>
				
				<div class="jumbotron">
					
					<h2><strong><?= $quizs['quiz_nom'] ?></strong></h2>
					<p><em>Nombre de questions : <?= $quizs['nbquestions'] ?> questions</em></p>
					<p><em>Thème : <?= $themes['theme_nom'] ?></em></p>
					<p><em><small>Date de création : <?= $quizs['datecreation'] ?></small></em></p>
					<p><em>Niveau choisi : <?=$niveau?></em></p>
					<hr/>
					
					<form action="quiz1par1.php?id=<?= $quizId ?>&tId=<?=$themeId?>&niv=<?=$niveau?>&num=<?=$numQues?>&score=<?=$scoreActu?>" Method="POST">
				
						<strong>Question <?=$numQues?> : <?=$question['ques_cont']?></strong><br/>
						
						<?php 
						
						//type texte
						if ($question['ques_type']=="texte"){?>
							<input type="text" name='rep' size="17" /><br/>
						<?php }							
										
						// type radio					
						if ($question['ques_type']=="radio"){
									
							foreach ($reponses as $reponse) { 
									
									if ($reponse['ques_id']==$question['ques_id']){ ?>
										
										<label><input type="radio" name='rep' value="<?= $reponse['rep_cont'] ?>"/> <?= $reponse['rep_cont'] ?></label><br/><?php
						} } }
						
						// type checkbox					
						if ($question['ques_type']=="checkbox"){?>
							<?php
							foreach ($reponses as $reponse) { 
								if ($reponse['ques_id']==$question['ques_id']){ ?>
									<label><input type="checkbox" name="rep[]" value="<?= $reponse['rep_cont'] ?>"/> <?= $reponse['rep_cont'] ?></label><br/><?php
						} } } ?>				
						
						<button type="submit" name="validation" class="boutonC"><span class="glyphicon glyphicon-log-in"></span> Valider</button>
					
					</form>
				</div>
			</div>
		
			<?php } //fin du else ?>
	
	</body>
</html>