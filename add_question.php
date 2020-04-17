<?php
	require_once "includes/function.php";
	session_start();
	verifConnexion();
	verifAdmin();
	
	if(isset($_GET['nb']))
	{
	    $nbQues=$_GET['nb'];
	    $_SESSION['nbQues']=$nbQues;
	}
	    
	else
    	$nbQues = $_SESSION['nbQues'];
	
	$quizId = $_SESSION['quiz'];
	
	$recup_quiz = getDb()->prepare('select * from quiz where quiz_id=?');
	$recup_quiz->execute(array($quizId));
	$quiz = $recup_quiz->fetch();
?>

<!DOCTYPE html>

<html>

    <?php 
		$pageTitle="Ajout de question(s)";
		require_once "includes/head.php"; 
	?>
	
	<body>
	
		<?php require_once "includes/header.php"; ?>
		
		<?php

    		if(isset($_POST['validation']))
    		{
    		    $nbCorrect=0; // compte les questions ne comportant pas de caractères spéciaux
    		    
    		    for($numquestion=1; $numquestion<=$nbQues; $numquestion++)
    			{
    			    if(preg_match('/^[a-zA-Z0-9@éèêàâôù. \'?!,\-]+$/i',$_POST[$numquestion."_cont"]))
    			    {
    			        $nbCorrect++;
    			    }
    			}
    			
    			if ($nbCorrect==$nbQues) //vérifier que toutes les questions ne contiennent pas de caractères spéciaux
    			{
        			for($numquestion=1; $numquestion<=$nbQues; $numquestion++)
        			{	
        			    
        			    $cont=$_POST[$numquestion."_cont"];
        			    $type=$_POST[$numquestion."_type"];
        			    $insert_ques = getDb()->prepare("INSERT INTO question(ques_cont, ques_type, quiz_id) VALUES(?,?,?)");
                    	$insert_ques->execute(array($cont,$type,$quizId));
                    	
        			    
        			    if (isset($_FILES))
        			    {
            			    $file_name=$_FILES[$numquestion."Media"]['name'];
            			    $file_extension=strrchr($file_name,'.');
            			    $file_tmp_name = $_FILES[$numquestion."Media"]['tmp_name'];
            			    $file_dest='files/'.$file_name;
            			        
            			    $extensionsValides = array('.jpg', '.JPG','.jpeg','.JPEG', '.gif', '.GIF', '.PNG', '.png', '.mp3', '.MP3', '.mp4', '.MP4');	
            			 
            			    if(in_array($file_extension, $extensionsValides)) 
            			    {
        					    if (move_uploaded_file($file_tmp_name,$file_dest))	 
        						{
        						    $insert_ques = getDb()->prepare("update question set ques_media=? where ques_cont=?");
                    				$insert_ques->execute(array($file_dest,$cont));
        						}
                    			else 
                    			{
                    				$erreur = "Erreur lors de l'importation de votre média";
                    			}
        		        	}
            		        else 
                    		{
                    			$erreur = "Votre media doit être au format jpg, jpeg, gif, png ou mp3 ou mp4";
                    	    }
        			    }
        			}
        			header("Location: add_reponse.php");
    			}
    			else
    			{
    			   $erreur="Veuillez saisir des intitulés sans caractères spéciaux !";
    			}
    		}
		?>
		
		
		
		<div class="containeurGlobal">
		
			<div class="infoBase">
					
				<div id="infoBaseInt">
					
					<h1><strong><?=$quiz['quiz_nom'] ?> </strong></h1>
					<em>Ajouter des questions </em>
					
				</div>
					
			</div>
		
		     
    		<form method="post" action="add_question.php" enctype="multipart/form-data">
    								
    			<?php 
    			for($numquestion=1; $numquestion<=$nbQues; $numquestion++) 
    			{?>
    				
    				<div class="element">
    			
    					<div id='elementInt'>
    					    
    							<h2>Question n° <?=$numquestion?> : </h2><br/>		
    							 
    							<label for="intitule"><i><strong>Intitulé : </strong></i></label> 
    							
    							<input type="text" name="<?=$numquestion?>_cont" class="texteForme" style="width:90%" placeholder="Entrez l'intitulé de la question :" required autofocus><br/><br/>
    							
    							<label for="type"><i><strong> Type :</strong></i></label> <br/>
					
            					<input type="radio" name="<?=$numquestion?>_type" value="texte" required/><label for="type">Question ouverte</label><br/>
            					<input type="radio" name="<?=$numquestion?>_type" value="radio"/><label for="type">Réponse unique</label><br/>
            					<input type="radio" name="<?=$numquestion?>_type" value="checkbox"/><label for="type">Choix multiples</label><br/><br/>
            					
            					<input type="file" name="<?=$numquestion?>Media" /> <br/><br/>
					
    					</div>
    					
    				</div>
    						
    			<?php } ?>
    			
    		  <br/><button type="submit" name="validation" class="boutonC"><span class="glyphicon glyphicon-log-in"></span> Ajouter</button><br/><br/>
    		  
    		  <?php
                if(isset($erreur))
        		    echo '<font color="blue"; text-align:center;>'.$erreur."</font>";
		      ?>
    		  
    				
    		</form>
    		
        </div>             
        
		
	<?php include "includes/footer.php";
	include "includes/scripts.php";?>
 
	</body>
	
</html>