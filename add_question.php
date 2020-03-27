<?php
	require_once "includes/function.php";
	session_start();
	// Récuperer tous les quiz
	$quizs = getDb()->query('select * from quiz');	
?>

<!DOCTYPE html>

<html>

   <?php 
		$pageTitle="Ajout de question(s)";
		require_once "includes/head.php"; 
	?>
	
	<body>
	
		<?php require_once "includes/header.php"; ?>
	
		     
    <form method="post" action="add_question.php">

		<div id="connexion">
			
			<fieldset><legend><strong>Ajouter des questions </strong></legend><br/> 
			
			<?php $nbquestions = $_POST['nbquestions'];?>
					
			<?php for($i=1; $i<=$nbquestions; $i++) {?>
						
						<p> Question n° <? =$i?> : </p><br/>					
						 
						<label for="quiz"><i>Intitulé : </i> </label> 
						<input type="text" name="intitule" value="<?php if(isset($login)) {echo $login;} ?>" class="form-control" placeholder="Entrez l'intitulé de la question :" required autofocus><br/> 
						
						<label for="quiz"><i>Type : </i> </label> 
						<input type="radio" name="type" value="texte"/><label for="type">Question ouverte</label><br/>
						<input type="radio" name="type" value="radio"/><label for="type">Réponse unique</label><br/>
						<input type="radio" name="type" value="checkbox"/><label for="type">Choix multiples</label><br/>
					
					<button type="submit" name="inscription" class="boutonC"><span class="glyphicon glyphicon-log-in"></span> Valider</button><br/><br/>
			<?php } ?>
					</fieldset>
                </div>             
            </form>


<?php include "includes/footer.php";
include "includes/scripts.php";?>
 
	<?php
			if(isset($erreur))
			{
				echo '<font color="blue"; text-align:center;>'.$erreur."</font>";
			}?>	
		
	</body>
</html>


