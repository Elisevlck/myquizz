<?php
	require_once "includes/function.php";
	session_start();
	// Récuperer tous les quiz
	$quizs = getDb()->query('select * from quiz'); 
?>

<!DOCTYPE html>

	<?php 
		$pageTitle="Mot de passe oublié";
		require_once "includes/head.php"; 
	?>
	
	<body>
		
		<?php require_once "includes/header.php";?>


		<?php
			
			
			if (isset($_POST['mail'])

			{	
				$email = trim($_POST['email']);
				
				
				$requete = getDb()->prepare('select * from utilisateur where ut_mail=?'); 	
				$requete->execute(array($email));
				$requete = $requete->fetch();

					if($email == $requete['ut_mail'])
						{
							
							$nvpassword = randomnb(8);
							
							 $resultat=getDb()->prepare("UPDATE utilisateur SET ut_mdp = ? WHERE ut_mail =?"); 
							 $resultat->execute(array($nvpassword, $requete['ut_mail']));
							 $erreur = "Votre mot de passe a bien été changé !";
							 redirect('login.php');
							 
							 //redaction du mail 
											
						}
						else
						{
							$erreur = "Mail introuvable !";
											
						}	
					
				}
				else
				
				{
					
				}
				
				
		
					
			
		?>
				
<div class="conteneurconex">
     
            <form method="post" action="mdpoublie.php">

                <div id="connexion">
                <fieldset><legend><strong>Mot de passe oublié</strong></legend>

                <br/>
                    
           
               
                <label for="login"><i> Login : </i></label><input type="text" name="login" class="form-control" placeholder="Entrez votre login" required>
                <br/>
                    
				<label for="mdp"><i> Nouveau mot de passe : </i></label><input type="password" name="nvpassword" class="form-control" placeholder="Entrez votre mot de passe" required>
               <br/>
                    <label for="mdp"><i>Confirmation nouveau mot de passe : </i></label><input type="password" name="repeatnvpassword" class="form-control" placeholder="Confirmer votre mot de passe" required>
            
                <br/>
                
                <button type="submit" name="mdpoublie" class="boutonC"><span class="glyphicon glyphicon-log-in"></span> Récupérer mon mot de passe</button>
                <br/>

                
                </div>  


                
                </fieldset>
                        
            </form>

</div>


<?php
			include('includes/footer.php'); 
			include('includes/scripts.php'); 

			if(isset($erreur))
			{
				echo '<font color="blue"; text-align:center;>'.$erreur."</font>";
			}
?>	
 
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script> 
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
				
</body></html>