<?php
	require_once "includes/function.php";
	session_start();
	// Récuperer tous les quiz
	
	$themeId = $_GET['id'];
	
	$stmt = getDb()->prepare('select * from theme where theme_id=?');
	$stmt->execute(array($themeId));
	$themes = $stmt->fetch();
	$themeNom=$themes['theme_nom'];	
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

		//validation du bouton 
		if(isset($_POST['validation']))
		{
			//récupération variables (trim->sécuriser la variable)
			$nom=trim($_POST['nom']);
			
			if (isset($_POST['nbquestions']))
				$nbquestions = trim($_POST['nbquestions']);
			elseif (!isset($_POST['nbquestions']))
				$nbquestions = 10;
			
			//tout le formulaire rempli
			if(!empty($nom)){
				
				$reqlog = getDb()->prepare('select * from quiz where quiz_nom=?'); 
				$reqlog->execute(array($nom));
				$logexist=$reqlog->rowCount();

					//pseudo unique ou non
					if($logexist == 0)			
					{		
								$insert_quiz = getDb()->prepare("INSERT INTO quiz(quiz_nom, nbquestions, theme_id) VALUES(?,?,?)");
								$insert_quiz->execute(array($nom,$nbquestions,$themeId));
								$erreur = "Votre quiz a bien été créé";
								
								$recup_quizid = getDb()->prepare("SELECT * FROM QUIZ WHERE quiz_nom=?");
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
			else $erreur = "Veuillez saisir tous un nom";			
		}
		?>

		


<div class="conteneurconex">
     
            <form method="post" action="add_quiz.php?id=<?=$themeId?>">

                <div id="connexion">
				
				<h1> Thème : <?=$themeNom?> </h1>				
                <fieldset><legend><strong>Ajouter un quiz</strong></legend><br/> 
                
                <label for="quiz"><i>Nom du quiz : </i> </label> <input type="text" name="nom" class="form-control" placeholder="Entrez le nom du quiz" required autofocus>                                 
               <br/>
			   
			   <label for="quiz"><i>Nombre de questions : </i> </label> <input type="text" name="nbquestions" class="form-control" placeholder="Valeur par défaut : 10" required autofocus>                                 
               <br/>
			   
                <button type="submit" name="validation" class="boutonC"><span class="glyphicon glyphicon-log-in"></span> Valider</button>

                
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


