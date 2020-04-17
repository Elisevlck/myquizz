<?php
	require_once "includes/function.php";
	session_start();
	verifConnexion();
    verifAdmin();

	$quesId = $_GET['id'];
	$_SESSION['ques']=$quesId;
	
	$recup_ques = getDb()->prepare('select * from question where ques_id=?');
	$recup_ques->execute(array($quesId));
	$question = $recup_ques->fetch();
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
		    $fautes=0;
		    
		        if(!empty($_POST['cont']))
            	{
            	    if(preg_match('/^[a-zA-Z0-9@éèàùêô. \'?!,\-]+$/i',$_POST['cont']))
            	    {
            	        $mod_cont = getDb()->prepare('update question set ques_cont=? where ques_id=?');
    	                $mod_cont->execute(array($_POST['cont'],$quesId));
            	    }
            	    else
            	    {
            	        $fautes++;
            	        $erreur_cont="L'intitulé de la question ne doit comporter que des lettres ! ";
            	    }
            	}
            	
            	if(!empty($_POST['type']))
            	{
            	    $mod_cont = getDb()->prepare('update question set ques_type=? where ques_id=?');
    	            $mod_cont->execute(array($_POST['type'],$quesId));
            	}
            	
            	if (!empty($_FILES['media']['name']))
        	    {
            			    $file_name=$_FILES["media"]['name'];
            			    $file_extension=strrchr($file_name,'.');
            			    $file_tmp_name = $_FILES["media"]['tmp_name'];
            			    $file_dest='files/'.$file_name;
            			        
            			    $extensionsValides = array('.jpg', '.JPG','.jpeg','.JPEG', '.gif', '.GIF', '.PNG', '.png', '.mp3', '.MP3', '.mp4', '.MP4');	
            			 
            			    if(in_array($file_extension, $extensionsValides)) 
            			    {
        					    if (move_uploaded_file($file_tmp_name,$file_dest))	 
        						{
        						    $insert_ques = getDb()->prepare("update question set ques_media=? where ques_id=?");
                    				$insert_ques->execute(array($file_dest,$quesId));
        						}
                    			else 
                    			{
                    			    $fautes++;
                    				$erreur_media ="<br/>Erreur lors de l'importation de votre média";
                    			}
        		        	}
            		        else 
                    		{
                    		    $fautes=$fautes;
                    			$erreur_media ="<br/>Votre media doit être au format jpg, jpeg, gif, png ou mp3 ou mp4";
                    	    }
        	    }
        		if ($fautes==0)
        		{
        		    header('Location: modif_reponse.php');
        		}
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
					?>
					
				</div>
					
			</div>
			
			<div class=element>
			    
			    <div id=elementInt>
			        
			        <form method="post" action="modif_question.php?id=<?=$quesId?>" enctype="multipart/form-data">
    			        
    			        <label for="quiz"><strong><i>Intitulé de la question : </i></strong></label><br/>
    			        <input type="text" name="cont" class="texteForme" style="width:80%" placeholder="<?=$question['ques_cont']?>" ><br/><br/>
    			        
    			        <?php
    			        if(isset($erreur_cont))
			                echo '<font color="blue"; text-align:center;>'.$erreur_cont."<br/><br/></font>";
                        ?>	
    			        
    					<label for="quiz"><strong><i>Type de la question : </i></strong></label> <br/>
    					<input type="radio" name="type" value="texte"/>Réponse ouverte <br/>
    					<input type="radio" name="type" value="radio"/>Réponse unique<br/>
    					<input type="radio" name="type" value="checkbox"/>Réponse multiple<br/><br/>
                					
                		<input type="file" name="media" /> <br/><br/>
                		<?php
                		if(isset($erreur_media))
			                echo '<font color="blue"; text-align:center;>'.$erreur_media."<br/><br/></font>";
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
		
		
		
		
		
		
		