<?php
	require_once "includes/function.php";
	session_start();
	// Récuperer tous les quiz
	//$quizs = getDb()->query('select * from quiz'); 
?>

<!DOCTYPE html>

	<?php 
		$pageTitle="Mot de passe oublié";
		require_once "includes/head.php"; 
	?>
	
	<body>
		
		<?php require_once "includes/header.php";?>


		<?php
			
			//$bdd=new PDO('mysql:host=localhost;dbname=phplogin','root','');
			if (!empty($_POST['login']) AND !empty($_POST['nvpassword']) AND !empty($_POST['repeatnvpassword']))

		{	
				$login = trim($_POST['login']);
				$nvpassword = trim($_POST['nvpassword']);
				$repeatnvpassword = trim($_POST['repeatnvpassword']);
				
				$requete = getDb()->prepare('select * from utilisateur where ut_nom=?'); 	
				$requete->execute(array($login));
				$requete = $requete->fetch();

				if($nvpassword == $repeatnvpassword)
				{
					if($login == $requete['ut_nom'])
						{
							
							 $resultat=getDb()->prepare("UPDATE utilisateur SET ut_mdp = ? WHERE ut_nom =?"); 
							 $resultat->execute(array($nvpassword, $requete['ut_nom']));
							 $erreur = "Votre mot de passe a bien été changé !";
							 redirect('login.php');
											
						}
						else
						{
							$erreur = "Login introuvable !";
											
						}	
					
				}
				else
				
				{
					$erreur = "Les mots de passe ne correspondent pas !";
				}
				
				
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