<!-- <?php
	require_once "includes/function.php";
	session_start();
	// Récuperer tous les quiz
	$quizs = getDb()->query('select * from quiz'); 
?>-->

<!DOCTYPE html>

<html>

   <?php 
		$pageTitle="Ajout de question(s)";
		require_once "includes/head.php"; 
	?>
	
	<body>
	
		<?php require_once "includes/header.php"; ?>

		<?php

		//validation du bouton 
		if(isset($_POST['inscription']))
		{
			//récupération variables (trim->sécuriser la variable)
			$nom=trim($_POST['nom']);
			$nbquestions = trim($_POST['nbquestions']);
			$theme = trim($_POST['theme']);
			
			//tout le formulaire rempli
			if(!empty($nom) AND !empty($nbquestions)AND !empty($theme)){
				
				$reqlog = getDb()->prepare('select * from quiz where quiz_nom=?'); 
				$reqlog->execute(array($nom));
				$logexist=$reqlog->rowCount();

					//pseudo unique ou non
					if($logexist == 0)			
					{		
								$insert_theme = getDb()->prepare("INSERT INTO quiz(quiz_nom, nbquestions, theme_nom) VALUES(?,?,?)");
								$insert_theme->execute(array($nom,$nbquestions,$theme));
								$erreur = "Votre quiz a bien été créé";
							
								/*header('Location : index.php');*/
								//redirection vers page accueil html
					}					
					else
					{
						$erreur = "Le nom de votre quiz est déjà utilisé!";				
					}							
			}
			else $erreur = "Veuillez saisir tous les champs";			
		}
		?>


<div class="conteneurconex">
     
            <form method="post" action="add_quiz.php">

				<div id="connexion">
					<fieldset><legend><strong>Ajouter des questions </strong></legend><br/> 
					
					<label for="quiz"><i>Type : </i> </label> <input type="text" name="nom" value="<?php if(isset($login)) {echo $login;} ?>" class="form-control" placeholder="Entrez le nom du quiz" required autofocus><br/>                     
					<label for="quiz"><i>Intitulé : </i> </label> <input type="text" name="intitule" value="<?php if(isset($login)) {echo $login;} ?>" class="form-control" placeholder="Entrez l'intitulé de la question :" required autofocus><br/>                              
					
					<button type="submit" name="inscription" class="boutonC"><span class="glyphicon glyphicon-log-in"></span> Valider</button>

					</fieldset>
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


