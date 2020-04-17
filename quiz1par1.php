<?php
	require_once "includes/function.php";
	session_start();
	verifConnexion();
	
	$quizId = $_SESSION['quiz'];
	$niveau = $_SESSION['niveau'];
	$scoreActu=$_SESSION['score'];
	
	$page=$_SESSION['page'];
	$quesId=$_SESSION['quesIds'][$page];
	
	if ($page==1)
	{
	    $_SESSION['temps']=time();
	}
	
	$recup_quiz = getDb()->prepare('select * from quiz where quiz_id=?');
	$recup_quiz->execute(array($quizId));
	$quiz = $recup_quiz->fetch(); 
	
	$recup_ques = getDb()->prepare('select * from question where ques_id=?');
	$recup_ques->execute(array($quesId));
	$question = $recup_ques->fetch();
	
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
?>

<html>

	<?php 
		$pageTitle = $quiz['quiz_nom'];
		require_once "includes/head.php"; 

	?>
	
	<body>
	    
	<?php
	
	
		//validation du bouton 
		if(isset($_POST['validation']))
		{	
		
			$id=$question['ques_id'];
			$tps=time();
			
			if ($question['ques_type']=="texte" OR $question['ques_type']=="radio")
			{
				
					$rep=trim(strtolower($_POST['rep']));
					
					if(preg_match('/^[a-zA-Z0-9@éèêôîùà.\' ?!,\-]+$/i',$rep))
					{
					    $recup_bdd = getDb()->prepare('select * from reponse where ques_id=?');
					    $recup_bdd->execute(array($quesId));
					    $bonnerep = $recup_bdd->fetch();
					    
					    if ($rep==$bonnerep['rep_cont'])
						    $point=1;
						else
						    $point=0;
						    
						$scoreActu=$scoreActu+$point;
						$_SESSION['score']=$scoreActu;
            			$_SESSION['page']=$_SESSION['page']+1;
            						
            			header('Location: quiz1par1.php');
					}
					else
					{
					    $erreur_cont="<br/>Veuillez entrer une réponse sans caractères spéciaux !";
					}
					
					
			}
			if ($question['ques_type']=="checkbox")
			{
					
					if ($niveau=="facile") {	
						$req = getDb()->prepare('select count(*) AS compteur from reponse where ques_id=? AND rep_estVrai="vrai" AND rep_niveau=?');
						$req->execute(array($quesId,$niveau));
						$nbVrai = $req->fetch(); 
					}	
					if ($niveau=="moyen") {					
						$req = getDb()->prepare('select count(*) AS compteur from reponse where ques_id=? AND rep_estVrai="vrai" AND (rep_niveau=? OR rep_niveau="facile")');
						$req->execute(array($quesId,$niveau));
						$nbVrai = $req->fetch(); 
					}	
					if ($niveau=="difficile") {					
						$req = getDb()->prepare('select count(*) AS compteur from reponse where ques_id=? AND rep_estVrai="vrai"');
						$req->execute(array($quesId));
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
					
						if ($nbVrai=="1")
						{
							
							$req1 = getDb()->prepare('select * from reponse where ques_id=? and rep_estVrai="vrai"');
							$req1->execute(array($quesId));
							$repbdd=$req1->fetch();
							
								if ($repbdd['rep_cont']==$value)
									$nbBonneRep++;
									
						}
						else 
						{							
							
							$req1 = getDb()->prepare('select * from reponse where ques_id=? and rep_estVrai="vrai"');
							$req1->execute(array($quesId));
							$repbdd=$req1->fetchAll();
							
							foreach ($repbdd as $rep)
							{
								
								if ($rep['rep_cont']==$value)
									$nbBonneRep++;
							}
						}
					}				
					
					if ($nbVrai==$nbChoix && $nbChoix==$nbBonneRep)
						$point=1;
					else
					    $point=0;
					    
					$scoreActu=$scoreActu+$point;
					$_SESSION['score']=$scoreActu;
					$page=$page+1;
            		$_SESSION['page']=$page;
            					
            		header('Location: quiz1par1.php');
			}
		}
	?>
	
	
	
		<?php 
			
			if ($page>count($_SESSION['quesIds']))
			{ 
				header('Location: resultat1par1.php');				
			}
			
			else
			{	
			
			    require_once "includes/header.php"; ?>
			    
			    <div class="containeurGlobal">
				
    				<div class="infoBase"><img src="images\chrono.gif" style="float:right;" width="300"></img>
    					
    					<div id="infoBaseInt">
    					
        					<h2><strong><?= $quiz['quiz_nom'] ?></strong></h2>
        					<h5><strong>ATTENTION</strong> le temps est compté !</h5>
        					<hr/>
    					
    					</div>
    					
    				</div>
    				
    					
    				<div class="element">
    		
    					<div id="elementInt">
    					
        					<form action="quiz1par1.php" Method="POST">
        				
        						<strong><?=$question['ques_cont']?></strong><br/><br/>
        						
        						<?php 
        						
        					    $extension=strrchr($question['ques_media'],'.');
            					$extensionsImg = array('.jpg', '.JPG','.jpeg','.JPEG', '.gif', '.GIF', '.PNG', '.png');	
                        			 
                        	    if(in_array($extension, $extensionsImg)) 
            	                {
            					    echo '<img class="imgQues" src="'.$question['ques_media'].'" alt="photopays" title="Nommez ce pays"/><br/><br/>';
            					}
            					if (($extension=='.mp4') OR ($extension=='.MP4'))
            					{
            					    echo '<video src='.$question['ques_media']." controls width="."400"."></video><br/>";
            					}
            					if (($extension=='.mp3') OR ($extension=='.MP3'))
            					{
            					   echo '<audio src='.$question['ques_media']." controls width="."400"."></audio><br/>";
            					}
        					
        						
        						//type texte
        						if ($question['ques_type']=="texte"){?>
        							<input type="text" name='rep' class="texteForme" style="width:60%" placeholder="Entrez votre réponse" required autofocus /><br/>
        						<?php }							
        										
        						// type radio					
        						if ($question['ques_type']=="radio"){
        									
        							foreach ($reponses as $reponse) { 
        									
        									if ($reponse['ques_id']==$question['ques_id']){ ?>
        										
        										<label><input type="radio" name='rep' value="<?= $reponse['rep_cont'] ?>" require/> <?= ucwords($reponse['rep_cont']) ?></label><br/><?php
        						} } }
        						
        						// type checkbox					
        						if ($question['ques_type']=="checkbox"){?>
        							<?php
        							foreach ($reponses as $reponse) { 
        								if ($reponse['ques_id']==$question['ques_id']){ ?>
        									<label><input type="checkbox" name="rep[]" value="<?= $reponse['rep_cont'] ?>" require/> <?= ucwords($reponse['rep_cont']) ?></label><br/><?php
        						} } } ?>				
        						
        						<br/><input type="submit" name="validation" value="Valider" class="glyphicon glyphicon-log-in"><br/>
        						
        					</form>
        					
    					</div>
    					
    				</div>
    			</div>
		
			<?php } //fin du else ?>
	</div>
	</body>
	<?php require_once "includes/footer.php"; ?>
		<?php require_once "includes/scripts.php"; ?>
</html>