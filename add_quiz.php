<?php
	require_once "includes/function.php";
	session_start();
	
	$themeId = $_GET['id'];
	
	$recup_theme = getDb()->prepare('select * from theme where theme_id=?');
	$recup_theme->execute(array($themeId));
	$theme = $recup_theme->fetch();	
?>

<!DOCTYPE html>

<html>

   <?php 
		$pageTitle="Ajout d'un quiz";
		require_once "includes/head.php"; 
	?>
	
	<body>
	
		<?php require_once "includes/header.php"; ?>
		
		<?php

		if(isset($_POST['validation']))
		{
			$nom=trim($_POST['nom']);
			
			if (isset($_POST['nbquestions']))
				$nbquestions = trim($_POST['nbquestions']);
			elseif (!isset($_POST['nbquestions']))
				$nbquestions = 10;
			
			if(!empty($nom)){
				
				$verif_nom = getDb()->prepare('select * from quiz where quiz_nom=?'); 
				$verif_nom->execute(array($nom));
				$nom_exist=$verif_nom->rowCount();

					//pseudo unique ou non
					if($nom_exist == 0)			
					{		
						$insert_quiz = getDb()->prepare("INSERT INTO quiz(quiz_nom, nbquestions, theme_id, createur) VALUES(?,?,?,?)");
						$insert_quiz->execute(array($nom,$nbquestions,$themeId,$_SESSION['login']));
						//$erreur = "Votre quiz a bien été créé";
								
						$recup_quizid = getDb()->prepare("SELECT * FROM quiz WHERE quiz_nom=?");
						$recup_quizid->execute(array($nom));
						$lenvquiz = $recup_quizid->fetch();
						$quizid=$lenvquiz['quiz_id'];
								
						header("Location: add_question.php?id=".$quizid."&nb=".$nbquestions);
					}					
					else
					{
						$erreur = "Le nom de votre quiz est déjà utilisé!";				
					}							
			}
			else $erreur = "Veuillez saisir un nom!";			
		}
		?>

		


		<div class="conteneurconex">
     
            <form method="post" action="add_quiz.php?id=<?=$themeId?>">

                <div id="connexion">
				
				<strong><FONT size="7"><?=$theme['theme_nom']?></font></strong>
				
                <fieldset><legend>Ajouter un quiz</legend><br/> 
                
					<label for="quiz"><i>Nom du quiz : </i> </label> <input type="text" name="nom" class="form-control" placeholder="Saisir l'intitulé" required autofocus><br/>
					<label for="quiz"><i>Nombre de questions : </i> </label> <input type="text" name="nbquestions" class="form-control" placeholder="10 par défaut" required autofocus><br/>                                 
					<button type="submit" name="validation" class="boutonC"><span class="glyphicon glyphicon-log-in"></span> Valider</button>

                </fieldset>				
				</div>                         
            </form>			
		</div>
		
		
		<?php 
		include "includes/footer.php";
		include "includes/scripts.php";
		
		if(isset($erreur))
			echo '<font color="blue"; text-align:center;>'.$erreur."</font>";
		
		?>	
		
	</body>
</html>


