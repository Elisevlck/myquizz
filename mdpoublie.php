<!DOCTYPE html>
    <html>
<?php include('head.php'); ?>
<?php include('header.php'); ?>

	  
<body>


<?php

    session_start();
	$bdd=new PDO('mysql:host=localhost;dbname=phplogin','root','');
	
	
include('function.php');


if (!empty($_POST['login']) AND !empty($_POST['nvpassword']) AND !empty($_POST['repeatnvpassword']))

{	
		$login = trim($_POST['login']);
		$nvpassword = trim($_POST['nvpassword']);
		$repeatnvpassword = trim($_POST['repeatnvpassword']);
		
		$requete = $bdd->prepare('select * from utilisateur where ut_login=?'); 	
		$requete->execute(array($login));
		$requete = $requete->fetch();

		if($nvpassword == $repeatnvpassword)
		{
			if($login == $requete['ut_login'])
				{
					
					 $resultat=$bdd->prepare("UPDATE utilisateur SET ut_mdp = ? WHERE ut_login =?"); 
					 $resultat->execute(array($nvpassword, $requete['ut_login']));
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
include('footer.php'); 
 include('scripts.php'); 

			if(isset($erreur))
			{
				echo '<font color="blue"; text-align:center;>'.$erreur."</font>";
			}
?>	
 
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script> 
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
				
</body></html>