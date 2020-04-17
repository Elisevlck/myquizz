<?php
	require_once "includes/function.php";
	session_start();
	verifConnexion();
	verifAdmin();
	
	$genreId=$_GET['id'];
	
	$recup_ut = getDb()->prepare('select * from utilisateur'); 
	$recup_ut->execute(array());
	$utilisateurs=$recup_ut->fetchAll();
	
	$recup_genre = getDb()->prepare('select * from genre where genre_id=?');
	$recup_genre->execute(array($genreId));
	$genre = $recup_genre->fetch();
?>

<!DOCTYPE html>

<html>

   <?php 
		$pageTitle="Ajout d'un thème";
		require_once "includes/head.php"; 
	?>
	
	<body>
	
		<?php require_once "includes/header.php"; ?>
		
		<?php

    		if(isset($_POST['validation']))
    		{
        			$nom=trim($_POST['nom']);
    			
        			if(preg_match('/^[a-zA-Z0-9@.?!,\-]+$/i',$nom))
        			{
            			$unicite = getDb()->prepare('select * from theme where theme_nom=?'); 
            			$unicite->execute(array($nom));
            			$nomexist=$unicite->rowCount();
            				
            			if($nomexist == 0) //unicité du nom			
            			{		
            				$insert_theme = getDb()->prepare("INSERT INTO theme(theme_nom ,genre_id) VALUES(?,?)");
            				$insert_theme->execute(array($nom,$genreId));
            								
            				$recup_themeId=getDb()->prepare("select * from theme where theme_nom=?");
            				$recup_themeId->execute(array($nom));
            				$theme=$recup_themeId->fetch();
            							
            				header('Location: index_quiz.php?id='.$theme['theme_id']);
            			}					
            			else
            			{
            				$erreur = "Le nom de votre thème est déjà utilisé!";				
            			}
            		}
            		else
            		{
            		    $erreur="Votre intitulé contient des caractères non-autorisés !";
            		}
    		}
		?>


        <div class="conteneurconex">
     
            <form method="post" action="add_theme.php?id=<?=$genreId?>">

                <div id="connexion">
				
					<?php if ($genreId==1)
					{ ?>
					
    					<h1>Quizz par thème</h1>
    				    <fieldset><legend><strong>Ajouter un thème</strong></legend><br/> 
    					
    					<label for="theme"><i>Nom du thème : </i> </label> 
    					<input type="text" name="nom" class="form-control" placeholder="Entrez le nom du thème" required autofocus><br/>
    					
					<?php } 
					
					else { ?>
					
    					<h1>Révisions</h1>
    				    <fieldset><legend><strong>Ajouter une révision</strong></legend><br/> 
    				    
    					<label for="theme"><i>Nom de la révision : </i> </label> <input type="text" name="nom" class="form-control" placeholder="Entrez le nom du thème" required autofocus><br/>
    				<?php } ?>				
    				  
    				<button type="submit" name="validation" class="boutonC"><span class="glyphicon glyphicon-log-in"></span> Ajouter</button><br/>
    				
					<?php
                	if(isset($erreur))
                	{
                		echo '<br/><font color="blue"; text-align:center;>'.$erreur."</font>";
                	}
                	?>	

                </div> 
                
			</form>
			
        </div>
        
    </body>    

    <?php include "includes/footer.php";
    include "includes/scripts.php";?>
    
</html>