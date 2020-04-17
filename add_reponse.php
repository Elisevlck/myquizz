<?php
	require_once "includes/function.php";
	session_start();
	verifConnexion();
	verifAdmin();
	
	$quizId = $_SESSION['quiz'];
	$nbQues = $_SESSION['nbQues'];
	
	$recup_quiz = getDb()->prepare('select * from quiz where quiz_id=?');
	$recup_quiz->execute(array($quizId));
	$lequiz = $recup_quiz->fetch();
	
	$recup_ques = getDb()->prepare('select * from question where quiz_id=? order by ques_id');
	$recup_ques->execute(array($quizId));
	$questions = $recup_ques->fetchAll();
?>

<!DOCTYPE html>

<html>

   <?php 
		$pageTitle="Ajout des réponses(s)";
		require_once "includes/head.php"; 
	?>
	
	<body>
	
		<?php require_once "includes/header.php"; ?>
		
		<?php

    		if(isset($_POST['validation']))
    		{
    			foreach ($questions as $question)
    			{	
    				$id=$question['ques_id'];
    			
    				if($question['ques_type']=='texte')
    				{
    				    if(preg_match('/^[a-zA-Z0-9@"èêàùî.\' ?!,\-]+$/i',$_POST[$id.'/texte']))
    				    {
    				        $insert_rep = getDb()->prepare("INSERT INTO reponse(rep_cont, rep_niveau, rep_estVrai, ques_id) VALUES(?,'facile','vrai',?)");
    					    $insert_rep->execute(array(strtolower($_POST[$id.'/texte']),$id));
    				    }
    				}
    				
    				if($question['ques_type']=='radio')
    				{
    					if(preg_match('/^[a-zA-Z0-9@"èêàùî. ?!,\-]+$/i',$_POST[$id.'/V']))
    					{
    					    $insert_repV = getDb()->prepare("INSERT INTO reponse(rep_cont, rep_niveau, rep_estVrai, ques_id) VALUES(?,'facile','vrai',?)");
    					    $insert_repV->execute(array(strtolower($_POST[$id.'/V']),$id));
    					}
    					
    					if(preg_match('/^[a-zA-Z0-9@"èêàùî. ?!,\-]+$/i',$_POST[$id.'/F']))
    					{
    					    $insert_repF = getDb()->prepare("INSERT INTO reponse(rep_cont, rep_niveau, rep_estVrai, ques_id) VALUES(?,'facile','faux',?)");
    					    $insert_repF->execute(array(strtolower($_POST[$id.'/F']),$id));
    					}
    					
    					if(preg_match('/^[a-zA-Z0-9@"èêàùî. ?!,\-]+$/i',$_POST[$id.'/M']))
    					{
    					    $insert_repM = getDb()->prepare("INSERT INTO reponse(rep_cont, rep_niveau, rep_estVrai, ques_id) VALUES(?,'moyen','faux',?)");
    					    $insert_repM->execute(array(strtolower($_POST[$id.'/M']),$id));
    					}
    					
    					if(preg_match('/^[a-zA-Z0-9@"èêàùî. ?!,\-]+$/i',$_POST[$id.'/D']))
    					{
    					    $insert_repM = getDb()->prepare("INSERT INTO reponse(rep_cont, rep_niveau, rep_estVrai, ques_id) VALUES(?,'moyen','faux',?)");
    					    $insert_repM->execute(array(strtolower($_POST[$id.'/D']),$id));
    					}
    				}
    				
    				if($question['ques_type']=='checkbox')
    				{
    				    
    				    if(preg_match('/^[a-zA-Z0-9@"èêàùî. ?!,\-]+$/i',$_POST[$id.'/VV']))
    					{
    					    $insert_repC = getDb()->prepare("INSERT INTO reponse(rep_cont, rep_niveau, rep_estVrai, ques_id) VALUES(?,'facile',?,?)");
    					    $insert_repC->execute(array(strtolower($_POST[$id.'/VV']),$_POST[$id.'/VV/estVrai'],$id));
    					}
    					
    					if(preg_match('/^[a-zA-Z0-9@"èêàùî. ?!,\-]+$/i',$_POST[$id.'/FF']))
    					{
    					    $insert_repF = getDb()->prepare("INSERT INTO reponse(rep_cont, rep_niveau, rep_estVrai, ques_id) VALUES(?,'facile',?,?)");
    					    $insert_repF->execute(array(strtolower($_POST[$id.'/FF']),$_POST[$id.'/FF/estVrai'],$id));
    					}
    					
    					if(preg_match('/^[a-zA-Z0-9@"èêàùî. ?!,\-]+$/i',$_POST[$id.'/MM']))
    					{
    					    $insert_repM = getDb()->prepare("INSERT INTO reponse(rep_cont, rep_niveau, rep_estVrai, ques_id) VALUES(?,'moyen',?,?)");
    					    $insert_repM->execute(array(strtolower($_POST[$id.'/MM']),$_POST[$id.'/MM/estVrai'],$id));
    					}
    					
    					if(preg_match('/^[a-zA-Z0-9@"èêàùî. ?!,\-]+$/i',$_POST[$id.'/DD']))
    					{
    					    $insert_repM = getDb()->prepare("INSERT INTO reponse(rep_cont, rep_niveau, rep_estVrai, ques_id) VALUES(?,'difficile',?,?)");
    					    $insert_repM->execute(array(strtolower($_POST[$id.'/DD']),$_POST[$id.'/DD/estVrai'],$id));
    					}			
    				}
    				
    				$init=$lequiz['nbquestions'];
    				$nbQues=$init+$nbQues;
    				
    				$actu_nbques=getDb()->prepare("update quiz set nbquestions=? where quiz_id=?");
    				$actu_nbques->execute(array($nbQues,$quizId));
    				unset($_SESSION['nbQues']);
    				
    				header("Location: index_question.php?id=".$quizId);
    			}
    		}	
		
		?>
		
		
		<div class="containeurGlobal">
		
			<div class="infoBase">
					
				<div id="infoBaseInt">
					
					<h1><strong><?=$lequiz['quiz_nom'] ?> </strong></h1>
					<em>Ajouter les réponses correspondantes </em>
					
				</div>
					
			</div>
		
		    <form method="post" action="add_reponse.php?">
				
				<?php 
				foreach ($questions as $question)
				{?>				
					<div class="element">
			
    					<div id='elementInt'>
    					
        					<h4><strong><?=$question['ques_cont']?></strong> </h4>
        					<em> Type : <?=$question['ques_type']?></em><br/>
        					
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
        					   echo '<audio src='.$question['ques_media']." controls width="."400"."></audio><br/><br/>";
        					}
        					
        					$id=$question['ques_id'];
        					
        					//QUESTION DE TYPE TEXTE					
        					if($question['ques_type']=='texte') 
        					{ ?>
        						<input type="text" name="<?=$id?>/texte" class="texteForme" style="width:90%" placeholder="Entrez la réponse correcte :" required autofocus><br/> 
        					<?php } 
        					
        					//QUESTION DE TYPE choix unique
        					
        					if($question['ques_type']=='radio')
        					{ ?>
        						<input type="text" name="<?=$id?>/V" class="texteForme" style="width:90%" placeholder="Entrez la réponse correcte :" required autofocus><br/><br/> 
        						<input type="text" name="<?=$id?>/F" class="texteForme" style="width:90%" placeholder="Entrez la réponse fausse qui apparaitra au niveau facile :" required autofocus><br/> <br/> 
        						<input type="text" name="<?=$id?>/M" class="texteForme" style="width:90%" placeholder="Entrez la réponse fausse qui apparaitra au niveau moyen :" required autofocus><br/><br/> 
        						<input type="text" name="<?=$id?>/D" class="texteForme" style="width:90%" placeholder="Entrez la réponse fausse qui apparaitra au niveau difficile :" required autofocus><br/><br/> 
        						
        					<?php } 
        					
        					//QUESTION DE TYPE choix multiples
        					if($question['ques_type']=='checkbox')
        					{ ?>
        					
        					    <select name="<?=$id?>/VV/estVrai" size="3" require autofocus >
        							<option value="vrai">Vrai</option>
        							<option value="faux">Faux</option>
        						</select>
        					
        					    <input type="text" name="<?=$id?>/VV" class="texteForme" style="width:80%" placeholder="Entrez la réponse qui apparaitra au niveau facile :" required autofocus><br/><br/> 
        					    
        					    <select name="<?=$id?>/FF/estVrai" size="3" require autofocus >
        							<option value="vrai">Vrai</option>
        							<option value="faux">Faux</option>
        						</select>
        					    
        						<input type="text" name="<?=$id?>/FF" class="texteForme" style="width:80%" placeholder="Entrez la réponse qui apparaitra au niveau facile :" required autofocus><br/> <br/> 
        						
        						<select name="<?=$id?>/MM/estVrai" size="3" require autofocus>
        							<option value="vrai">Vrai</option>
        							<option value="faux">Faux</option>
        						</select>
        						
        						<input type="text" name="<?=$id?>/MM" class="texteForme" style="width:80%" placeholder="Entrez la réponse qui apparaitra au niveau moyen :" required autofocus><br/><br/> 
        						
        						<select name="<?=$id?>/DD/estVrai" size="3" require autofocus >
        							<option value="vrai">Vrai</option>
        							<option value="faux">Faux</option>
        						</select>
        						
        						<input type="text" name="<?=$id?>/DD" class="texteForme" style="width:80%" placeholder="Entrez la réponse qui apparaitra au niveau difficile :" required autofocus><br/><br/> 
        												
        						 
        				    <?php } ?>
        					<hr/>
        					
        			    </div>
        				
			        </div>
			    
			<?php } ?>
			
			<br/><button type="submit" name="validation" class="boutonC"><span class="glyphicon glyphicon-log-in"></span> Ajouter</button><br/>
			
		</form>
		
	</body>
		
	<?php include "includes/footer.php";
	include "includes/scripts.php";?>
	 
	<?php
	if(isset($erreur))
	{
		echo '<font color="blue"; text-align:center;>'.$erreur."</font>";
	}?>	
			
	</body>
	
</html>