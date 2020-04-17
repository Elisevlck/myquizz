<?php
	require_once "includes/function.php";
	session_start();
	verifConnexion();

	$quizId = $_GET['id'];
	$_SESSION['quiz']= $_GET['id'];
	$niveau = $_GET['niv'];
	$_SESSION['niveau']=$_GET['niv'];
	$themeId=$_SESSION['theme'];
	
	$recup_quiz = getDb()->prepare('select * from quiz where quiz_id=?');
	$recup_quiz->execute(array($quizId));
	$quizs = $recup_quiz->fetch(); 
	
	$recup_ques = getDb()->prepare('select * from question where quiz_id=?');
	$recup_ques->execute(array($quizId));
	$questions = $recup_ques->fetchAll();
	shuffle($questions);	
	
	if ($niveau=="facile") 
	{
    	$recup_rep = getDb()->prepare('select * from reponse where rep_niveau=?');
    	$recup_rep->execute(array($niveau));
    	$reponses = $recup_rep->fetchAll(); 
	}	
	if ($niveau=="moyen") 
	{
    	$recup_rep = getDb()->prepare('select * from reponse where rep_niveau=? OR rep_niveau="facile"');
    	$recup_rep->execute(array($niveau));
    	$reponses = $recup_rep->fetchAll(); 
	}	
	if ($niveau=="difficile") 
	{
    	$recup_rep = getDb()->prepare('select * from reponse');
    	$recup_rep->execute(array());
    	$reponses = $recup_rep->fetchAll();
	}
	$recup_theme = getDb()->prepare('select * from theme where theme_id =?');
	$recup_theme->execute(array($themeId));
	$themes = $recup_theme->fetch(); //	
	shuffle($reponses);
?>

<!doctype html>

<html>

	<?php 
		$pageTitle = $quizs['quiz_nom'];
		require_once "includes/head.php"; 
	?>

	<body>
	
		<?php require_once "includes/header.php"; ?>
		
		<div class="containeurGlobal">

			<div class="infoBase"><img src="images\chrono.gif" style="float:right;" width="300"></img>
			
    			<div id="infoBaseInt">
    				
    				<h2><strong><?= $quizs['quiz_nom'] ?></strong></h2>
    				<p><em>Nombre de questions : <?= $quizs['nbquestions'] ?> questions</em></p>
    				<p><em>Thème : <?= $themes['theme_nom'] ?></em></p>
    				<p><em><small>Date de création : <?= $quizs['datecreation'] ?></small></em></p>
    				<p><em>Niveau choisi : <?=$niveau?></em></p>
    				<h5><strong>ATTENTION</strong> le temps est compté !</h5>
    				<hr/>
    			
    			</div>
			</div>
				
				
				<form action="resultat.php" Method="POST">
				
					<?php $i=1;
						$debut=time();
					?>
								
					<?php foreach ($questions as $question) 
					{ ?>
					
						<div class="element">
						
						<div id="elementInt">
						
						<em><strong><?=$i?>) <?= $question['ques_cont'] ?></strong></em><br/><?php
						
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
						
						// type texte
						if ($question['ques_type']=="texte"){?>
							<input type="text" name='<?= $question["ques_id"]?>' class="texteForme" style="width:60%" placeholder="Entrez votre réponse" required autofocus/><br/>
						<?php }							
										
						// type radio					
						if ($question['ques_type']=="radio")
						{
									
							foreach ($reponses as $reponse) 
							{ 
									
									if ($reponse['ques_id']==$question['ques_id']){ ?>
										
										<label><input type="radio" name='<?= $question["ques_id"]?>' value=" <?= $reponse['rep_cont'] ?>" require autofocus/> <?= $reponse['rep_cont'] ?></label><?php
								
								
						} } }
						
						// type checkbox					
						if ($question['ques_type']=="checkbox")
						{?>
							<?php
							foreach ($reponses as $reponse) 
							{ 
								if ($reponse['ques_id']==$question['ques_id']){ ?>
									<label><input type="checkbox" name="reponse<?=$question["ques_id"]?>[]" value=" <?= $reponse['rep_cont'] ?>" required autofocus/> <?= $reponse['rep_cont'] ?></label><?php
						} } } 							
						$i++;						
						?>
                			
					</div></div>
				
				<?php 		  } ?>			
				
				<br/>
				<button type="submit" name="validation" value="<?=$debut?>" style="align-item:center" class="boutonC"><span class="glyphicon glyphicon-log-in"></span> Valider</button><br/>
				
			
			</form>
				
			</div>

			<?php require_once "includes/footer.php"; ?>
		</div>

		<?php require_once "includes/scripts.php"; ?>
	</body>

</html>