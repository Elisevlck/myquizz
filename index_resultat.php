<?php
	require_once "includes/function.php";
	session_start();
	verifConnexion();

	$quizId = $_GET['id'];
	
	$recup_ques = getDb()->prepare('select * from question where quiz_id=?');
	$recup_ques->execute(array($quizId));
	$questions = $recup_ques->fetchAll();
	
    $recup_quiz = getDb()->prepare('select * from quiz where quiz_id=?');
	$recup_quiz->execute(array($quizId));
	$quiz = $recup_quiz->fetch();
?>

<!doctype html>

<html>

	<?php 
		$pageTitle = "Correction";
		require_once "includes/head.php"; 
	?>

	<body>	
		
		<?php include "includes/header.php"; ?>
		
		<div class="containeurGlobal">
		
			<div class="infoBase">
				
				<div id="infoBaseInt">
			
			    	<h1><strong> <?=$quiz['quiz_nom'] ?> : Correction </strong></h1>
					
				</div>
			</div>
				
			<?php 
			foreach ($questions as $question) { ?>
				
				<div class="element">
				    
				<div id="elementInt">
					    
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
				    ?>
					    
					
					<strong><?= $question['ques_cont']?></strong><br/>
						
						<?php
						$recup_rep = getDb()->prepare('select * from reponse where ques_id=?');
						$recup_rep->execute(array($question['ques_id']));
						$reponses = $recup_rep->fetchAll();
						
						echo ' |  ';
						
						foreach ($reponses as $reponse)
						{ 
							if ($reponse['rep_estVrai']=='vrai')
								echo '<font color=red><strong>'.ucwords($reponse['rep_cont']).'</strong></font>';
							else 
								echo ucwords($reponse['rep_cont']).'';
							echo ' |  ';
						}
						?>
						
				</div>
				</div>
				<?php } ?>				
		</div>
		
	</body>
	<?php //include "includes/footer.php";
	include "includes/scripts.php";
	?>

</html>