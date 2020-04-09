<?php
	require_once "includes/function.php";
	session_start();
	
	$genreId=$_GET['id'];
	
	$utilisateurs = getDb()->query('select * from utilisateur'); 
	
	$stmt = getDb()->prepare('select * from genre where genre_id=?');
	$stmt->execute(array($genreId));
	$genres = $stmt->fetch();
	$genreNom=$genres['genre_nom'];
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

		//validation du bouton 
		if(isset($_POST['validation']))
		{
			//récupération variables (trim->sécuriser la variable)
			$nom=trim($_POST['nom']);
			
			//tout le formulaire rempli
			if(!empty($nom)){
				
				$reqlog = getDb()->prepare('select * from theme where theme_nom=?'); 
				$reqlog->execute(array($nom));
				$logexist=$reqlog->rowCount();

					//pseudo unique ou non
					if($logexist == 0)			
					{		
								$insert_theme = getDb()->prepare("INSERT INTO theme(theme_nom ,genre_id) VALUES(?,?)");
								$insert_theme->execute(array($nom,$genreNom));
								$erreur = "Votre thème a bien été créé";
							
								redirect('add_quiz.php');
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
     
            <form method="post" action="add_theme.php?id=<?=$genreId?>">

                <div id="connexion">
				
					<?php if ($genreId==1){ ?>
					
					<legend><strong>Ajouter un thème</strong></legend>
					<label for="theme"><i>Nom du thème : </i> </label> <input type="text" name="nom" class="form-control" placeholder="Entrez le nom du thème" required autofocus>
					
					<?php } 
					else { ?>
					
					<legend><strong>Ajouter une révision</strong></legend>
					<label for="theme"><i>Nom de la révision : </i> </label> <input type="text" name="nom" class="form-control" placeholder="Entrez le nom du thème" required autofocus>
					<?php } ?>				
				   <br/>
					
					<button type="submit" name="validation" class="boutonC"><span class="glyphicon glyphicon-log-in"></span> Valider</button>

                </div> 
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