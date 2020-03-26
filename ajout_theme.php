<?php
	require_once "includes/function.php";
	session_start();
?>

<!DOCTYPE html>

<html>

   <?php 
		$pageTitle="Ajout d'un thème";
		require_once "includes/head.php"; 
	?>
	
	<body>
	
		<?php require_once "includes/header.php"; ?>
		
	<body>

		<?php

		//validation du bouton 
		if(isset($_POST['inscription']))
		{
			//récupération variables (trim->sécuriser la variable)
			$nom=trim($_POST['nom']);
			$genre = trim($_POST['genre']);
			
			//tout le formulaire rempli
			if(!empty($nom) AND !empty($genre)){
				
				$reqlog = getDb()->prepare('select * from theme where theme_nom=?'); 
				$reqlog->execute(array($nom));
				$logexist=$reqlog->rowCount();

					//pseudo unique ou non
					if($logexist == 0)			
					{		
								$insert_theme = getDb()->prepare("INSERT INTO theme(theme_nom ,genre_nom) VALUES(?,?)");
								$insert_theme->execute(array($nom,$genre));
								$erreur = "Votre thème a bien été créé";
							
								/*header('Location : 2.html');*/
								//redirection vers page accueil html
					}					
					else
					{
						$erreur = "Le nom de votre thème est déjà utilisé!";				
					}							
			}
			else $erreur = "Veuillez saisir tous les champs";			
		}
		?>


<div class="conteneurconex">
     
            <form method="post" action="ajout_theme.php">

                <div id="connexion">
                <fieldset><legend><strong>Ajout d'un thème</strong></legend>
 <br/>
                    <input type="radio" name="genretheme" value="Thèmes"/><label for="theme">Thèmes Divers</label>
                    <input type="radio" name="genretheme" value="Révisions"/><label for="revisions">Révisions</label><br/>
                    
                
                <label for="login"><i>Nom du thème : </i> </label> <input type="text" name="nom" value="<?php if(isset($login)) {echo $login;} ?>" class="form-control" placeholder="Entrez le nom du thème :" required autofocus>                
               <br/>
                
                <button type="submit" name="inscription" class="boutonC"><span class="glyphicon glyphicon-log-in"></span> Valider</button>

                
                </div>  


                
                </fieldset>
                        
            </form>
			
		
			

</div>

<?php include "includes/footer.php";
include "includes/scripts.php";?>
 
	<?php
			if(isset($erreur))
			{
				echo '<font color="blue"; text-align:center;>'.$erreur."</font>";
			}?>	
		
	</body>
    </html>