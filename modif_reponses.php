<?php

	require_once "includes/function.php";
	session_start();
	verifConnexion();
    verifAdmin();

	$quesId = $_SESSION['ques'];
	
	$recup_ques = getDb()->prepare('select * from question where ques_id=?');
	$recup_ques->execute(array($quesId));
	$question = $recup_ques->fetch();

	$recup_reponses=getDb()->prepare('select * from reponse where ques_id=?');
	$recup_reponses->execute(array($quesId));
	$reponses=$recup_reponses->fetchAll();
?>

<!doctype html>

<html>

	<?php 
		$pageTitle = "Modifier une question";
		require_once "includes/head.php"; 
	?>

	<body>	
		
		<?php include "includes/header.php"; ?>
		
		<?php
		
		if (isset($_POST['validation']))
		{
    	    if($question['ques_type']=='texte')
    		{
    		    if(preg_match('/^[a-zA-Z0-9@"èêàùî. \'?!,\-]+$/i',$_POST['cont']))
    			{
    				$insert_rep = getDb()->prepare("update reponse set rep_cont=? where rep_estVrai='vrai' AND ques_id=?");
    			    $insert_rep->execute(array(strtolower($_POST['cont']),$quesId));
    			}
    			else
    			{
    			    $erreur="La réponse saisie contient des caractères non-autorisés !";
    			}
    		}
    				
    		if($question['ques_type']=='radio')
    		{
    					if(preg_match('/^[a-zA-Z0-9@"èêàùî. ?!,\-]+$/i',$_POST['v']))
    					{
    					    $insert_repC = getDb()->prepare("update reponse set rep_cont=? where rep_niveau='facile' AND rep_estVrai='vrai' AND ques_id=?");
    					    $insert_repC->execute(array(strtolower($_POST['v']),$quesId));
    					}
    					
    					if(preg_match('/^[a-zA-Z0-9@"èêàùî. ?!,\-]+$/i',$_POST['f']))
    					{
    					    $insert_repF = getDb()->prepare("update reponse set rep_cont=? where rep_niveau='facile' AND rep_estVrai='faux' AND ques_id=?");
    					    $insert_repF->execute(array(strtolower($_POST['f']),$quesId));
    					}
    					
    					if(preg_match('/^[a-zA-Z0-9@"èêàùî. ?!,\-]+$/i',$_POST['m']))
    					{
    					    $insert_repM = getDb()->prepare("update reponse set rep_cont=? where rep_niveau='moyen' AND rep_estVrai='faux' AND ques_id=?");
    					    $insert_repM->execute(array(strtolower($_POST['m']),$quesId));
    					}
    					
    					if(preg_match('/^[a-zA-Z0-9@"èêàùî. ?!,\-]+$/i',$_POST['d']))
    					{
    					    $insert_repM = getDb()->prepare("update reponse set rep_cont=? where rep_niveau='difficile' AND rep_estVrai='faux' AND ques_id=?");
    					    $insert_repM->execute(array(strtolower($_POST['d']),$quesId));
    					}
    		}
    				
    		if($question['ques_type']=='checkbox')
    		{
    				    
    		            if(preg_match('/^[a-zA-Z0-9@"èêàùî. ?!,\-]+$/i',$_POST['vv']))
    					{
    					    $insert_repC = getDb()->prepare("update reponse set rep_cont=? and rep_estVrai=? where rep_niveau='facile' AND ques_id=?");
    					    $insert_repC->execute(array(strtolower($_POST['vv']),$_POST['vvE'],$quesId));
    					}
    					
    					if(preg_match('/^[a-zA-Z0-9@"èêàùî. ?!,\-]+$/i',$_POST['ff']))
    					{
    					    $insert_repF = getDb()->prepare("update reponse set rep_cont=? and rep_estVrai=? where rep_niveau='facile' AND ques_id=?");
    					    $insert_repF->execute(array(strtolower($_POST['ff']),$_POST['ffE'],$quesId));
    					}
    					
    					if(preg_match('/^[a-zA-Z0-9@"èêàùî. ?!,\-]+$/i',$_POST['mm']))
    					{
    					    $insert_repM = getDb()->prepare("update reponse set rep_cont=? and rep_estVrai=? where rep_niveau='facile' AND ques_id=?");
    					    $insert_repM->execute(array(strtolower($_POST['mm']),$_POST['mmE'],$quesId));
    					}
    					
    					if(preg_match('/^[a-zA-Z0-9@"èêàùî. ?!,\-]+$/i',$_POST['dd']))
    					{
    					    $insert_repM = getDb()->prepare("update reponse set rep_cont=? and rep_estVrai=? where rep_niveau='facile' AND ques_id=?");
    					    $insert_repM->execute(array(strtolower($_POST['dd']),$_POST['ddE'],$quesId));
    					}			
    		}
    		header("Location: index_question.php?id=".$_SESSION['quiz']);
		}
		?>
		
		<div class="containeurGlobal">
		
			<div class="infoBase">
					
				<div id="infoBaseInt">
					
					<h5><strong><?=$question['ques_cont'] ?> </strong></h5>
					
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
						
					foreach ($reponses as $reponse)
					{ 
							
						if ($reponse['rep_estVrai']=='vrai')
							echo '<font color=red><strong>'.ucwords($reponse['rep_cont']).' </strong></font>';
						else 
							echo ucwords($reponse['rep_cont']).'';
						echo ' ';
					}
					?>
					
				</div>
					
			</div>
			
			<div class=element>
			    
			    <div id=elementInt>
			        
			        <form method="post" action="modif_reponse.php">
			            
			            <?php 
			            if($question['ques_type']=='texte') //QUESTION DE TYPE TEXTE
					    { ?>
						    <input type="text" name="cont" class="texteForme" style="width:90%" placeholder="Entrez la réponse correcte :" ><br/> 
					    <?php } 
					
    					if($question['ques_type']=='radio')//QUESTION DE TYPE choix unique
    					{ ?>
    						<input type="text" name="v" class="texteForme" style="width:90%" placeholder="Entrez la réponse correcte :" ><br/><br/> 
    						<input type="text" name="f" class="texteForme" style="width:90%" placeholder="Entrez la réponse fausse qui apparaitra au niveau facile :" ><br/> <br/> 
    						<input type="text" name="m" class="texteForme" style="width:90%" placeholder="Entrez la réponse fausse qui apparaitra au niveau moyen :" ><br/><br/> 
    						<input type="text" name="d" class="texteForme" style="width:90%" placeholder="Entrez la réponse fausse qui apparaitra au niveau difficile :" ><br/><br/> 
    						
    					<?php } 
					
					
					    if($question['ques_type']=='checkbox')//QUESTION DE TYPE choix multiples
					    { ?>
					
    					    <select name="vvE" size="3"  >
    							<option value="vrai">Vrai</option>
    							<option value="faux">Faux</option>
    						</select>
    					
    					    <input type="text" name="vv" class="texteForme" style="width:80%" placeholder="Entrez la réponse qui apparaitra au niveau facile :" ><br/><br/> 
    					    
    					    <select name="ffE" size="3"  >
    							<option value="vrai">Vrai</option>
    							<option value="faux">Faux</option>
    						</select>
    					    
    						<input type="text" name="ff" class="texteForme" style="width:80%" placeholder="Entrez la réponse qui apparaitra au niveau facile :" ><br/><br/> 
    						
    						<select name="mmE" size="3" >
    							<option value="vrai">Vrai</option>
    							<option value="faux">Faux</option>
    						</select>
    						
    						<input type="text" name="mm" class="texteForme" style="width:80%" placeholder="Entrez la réponse qui apparaitra au niveau moyen :" ><br/><br/> 
    						
    						<select name="ddE" size="3"  >
    							<option value="vrai">Vrai</option>
    							<option value="faux">Faux</option>
    						</select>
    						
    						<input type="text" name="dd" class="texteForme" style="width:80%" placeholder="Entrez la réponse qui apparaitra au niveau difficile :" ><br/><br/> 
												
						 
				        <?php	} ?>
    			
    			        <?php
    			        if(isset($erreur_cont))
			                echo '<font color="blue"; text-align:center;>'.$erreur_cont."<br/><br/></font>";
                        ?>	
    				    
    				    <button type="submit" name="validation" class="boutonC"><span class="glyphicon glyphicon-log-in"></span> Valider</button><br/><br/>
    				    
    				</form>
			
			    </div>
			
			</div>
			
		</div>
		
	</body>
	
	<?php 
	include "includes/footer.php";
	include "includes/scripts.php";
	?>
	
</html>
		
		