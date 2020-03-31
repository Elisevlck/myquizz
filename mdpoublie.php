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
			
			
			if (isset($_POST['mdpoublie']))

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
							 
							
							ini_set('SMTP','smtp.gmail.com');
							$destinataire = $_POST['email'];
							$envoyeur ='dubozemma@gmail.com';
							$sujet = 'Mot de passe oublié';
							$message = "Bonjour !\r\Votre mot de passe est $nvpassword !";
							$headers = 'From: '.$envoyeur."\r\n".
							           'Reply-To: '.$envoyeur."\r\n".'X-Mailer: PHP/'. phpversion();
							
							$envoye = mail($destinataire, $sujet, $message, $headers);
											
						}
						else
						{
							$erreur = "Mail introuvable !";
											
						}	
					
				}
			
		?>
				
<div class="conteneurconex">
     
            <form method="post" action="mdpoublie.php">

                <div id="connexion">
                <fieldset><legend><strong>Mot de passe oublié</strong></legend>

                <br/>
                    
           
               
                     <label for="login"><i> Adresse mail : </i></label><input type="email" name="email" value="<?php if(isset($email)) {echo $email;} ?>" class="form-control" placeholder="Entrez votre adresse mail" required>
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