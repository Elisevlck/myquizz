<?php

	require_once "includes/function.php";
	session_start();
	verifConnexion();
	verifAdmin();
	
	$themeId = $_GET['id'];
	$_SESSION['theme']= $themeId;
	
	$recup_theme = getDb()->prepare('select * from theme where theme_id=?');
	$recup_theme->execute(array($themeId));
	$letheme = $recup_theme->fetch();
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
    		    if (!empty($_POST['nom']) AND (!empty($_POST['nbquestions'])))
    		    {
    		            if((preg_match('/^[0-9\-]+$/i',$_POST['nbquestions'])))
    		            {
    		                $nbquestions = trim($_POST['nbquestions']);
    		                
    		                if(preg_match('/^[a-zA-Z0-9@. \'éèêàù?!,\-]+$/i',$_POST['nom']))
    		                {
    		                    $nom=trim($_POST['nom']);
    		                    $verif_nom = getDb()->prepare('select * from quiz where quiz_nom=?'); 
        				        $verif_nom->execute(array($nom));
        			        	$nom_exist=$verif_nom->rowCount();
        
            					if($nom_exist == 0)			
            					{		
            						$insert_quiz = getDb()->prepare("INSERT INTO quiz(quiz_nom, nbquestions, theme_id, createur) VALUES(?,0,?,?)");
            						$insert_quiz->execute(array($nom,$_SESSION['theme'],$_SESSION['login']));
            						
            						$recup_quizid = getDb()->prepare("SELECT * FROM quiz WHERE quiz_nom=?");
            						$recup_quizid->execute(array($nom));
            						$lenvquiz = $recup_quizid->fetch();
            						
            						$_SESSION['quiz']=$lenvquiz['quiz_id'];
            						$_SESSION['nbQues']=$nbquestions;
            								
            						header("Location: add_question.php");
            					}					
            					else
            					{
            						$erreur = "Le nom de votre quiz est déjà utilisé!";				
            					}			
    		                }
    		                else
    		                {
    		                    $erreur = "L'intitulé de votre quiz comporte des caractères non-autorisés !";
    		                }
    		                
    		            }
    		            else
    		            {
    		                $erreur = "Le nombre entré n'est pas valide !";
    		            }
    		    }
    		    else
    		    {
    		        $erreur="Veuillez compléter tous les champs ! ";
    		    }  
    		}
		?>

		


		<div class="conteneurconex">
     
            <form method="post" action="add_quiz.php?id=<?=$themeId?>">

                <div id="connexion">
				
    				<strong><FONT size="7"><?=$letheme['theme_nom']?></font></strong>
    				
                    <fieldset><legend>Ajouter un quiz</legend><br/>
                    
    					<label for="quiz"><i>Nom du quiz : </i> </label> <input type="text" name="nom" class="form-control" placeholder="Saisir l'intitulé" required autofocus><br/>
    					<label for="quiz"><i>Nombre de questions : </i> </label> <input type="text" name="nbquestions" class="form-control" placeholder="10 par défaut" required autofocus ><br/>                                 
    					<button type="submit" name="validation" class="boutonC"><span class="glyphicon glyphicon-log-in"></span> Ajouter</button> <br/><br/>
    					
    					<?php
                            if(isset($erreur))
        			            echo '<font color="blue"; text-align:center;>'.$erreur."</font>";
		                ?>
		                
                    </fieldset>
                    
				</div>
				
            </form>
            
		</div>
		
	</body>	
	
	<?php 
		include "includes/footer.php";
		include "includes/scripts.php";
	?>	
	
</html>

