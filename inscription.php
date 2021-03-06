<?php
	require_once "includes/function.php";
	session_start();
	$utilisateurs = getDb()->query('select * from utilisateur'); 
?>

<!DOCTYPE html>

<html>

    <?php 
		$pageTitle="Inscription";
		require_once "includes/head.php"; 
	?>
	
	<body>
	
		<?php require_once "includes/header.php"; ?>

		<?php

		//validation du bouton 
		if(isset($_POST['inscription']))
		{
			//récupération variables (trim->sécuriser la variable)
			$login = trim($_POST['login']);
			$email = trim($_POST['email']);
			$password = trim($_POST['password']);
			$repeatpassword = trim($_POST['repeatpassword']);
			
			//tout le formulaire rempli
			if(!empty($login) AND !empty($email) AND !empty($password) AND !empty($repeatpassword))			
			{	
				//filtre mail, sécurité
				if(filter_var($email, FILTER_VALIDATE_EMAIL))
				{
					
				$reqlog = getDb()->prepare('select * from utilisateur where ut_nom=?'); 
				$reqlog->execute(array($login));
				$logexist=$reqlog->rowCount();
				
				$reqlog = getDb()->prepare('select * from utilisateur where ut_mail=?'); 
				$reqlog->execute(array($email));
				$mailexist=$reqlog->rowCount();
				
					//pseudo et mail unique ou non
					if($logexist == 0)			
					{				
						if($mailexist == 0)
						{
							//même mdp
							if($password == $repeatpassword)
							{		
								//caractère max pour le mdp(100) : création compte
								$loginlength = strlen($login);
								if($loginlength <= 100)
								{
									$insert_ut = getDb()->prepare("INSERT INTO utilisateur(ut_nom ,ut_mdp, ut_mail, ut_role) VALUES(?,?,?,?)");
									$insert_ut->execute(array($login,$password,$email,"joueur"));
									$_SESSION['login']=$login;
									$_SESSION['email']=$email;
									$_SESSION['password']=$password;
									$_SESSION['role']="joueur";
									
									header("Location:index.php");
									
							
								}				
								else
								{	 
									$msg = "Votre login ne doit pas dépasser 100 caractères.";
								}
							}	
							else
							{
								$msg = "Vos mot de passe ne correspondent pas !";
							}	
						}
						else
						{
							$msg = "Mail déjà utilisé !";				
						}
					}		
					else
					{
						$msg = "Login déjà utilisé !";				
					}
				}
				else $msg = "Votre email n'est pas valide !";
				
			}
			else $msg = "Veuillez saisir tous les champs";
			
		} ?>

	<div class="conteneurconex">              
		<form method="post" action="inscription.php">
			<div id="inscription">
			    
				<fieldset><legend><strong>Inscription</strong></legend><br/>
					
					<label for="login"><i>Identifiant : </i> </label> <input type="text" name="login" value="<?php if(isset($login)) {echo $login;} ?>" class="form-control" placeholder="Entrez votre identifiant" required autofocus><br/>				 
					    
					<label for="mail"><i> Adresse mail : </i></label><input type="email" name="email" value="<?php if(isset($email)) {echo $email;} ?>" class="form-control" placeholder="Entrez votre adresse mail" required><br/>
					    
					<label for="mdp"><i> Mot de passe : </i></label><input type="password" name="password" class="form-control" placeholder="Entrez votre mot de passe" required><br/>
					    
					<label for="mdp2"><i>Confirmation mot de passe : </i></label><input type="password" name="repeatpassword" class="form-control" placeholder="Confirmer votre mot de passe" required><br/>
					
			        <button type="submit" name="inscription" class="boutonC"><span class="glyphicon glyphicon-log-in"></span> Valider</button>
			    
			        
					</fieldset>	
				</div>  
			</form>
		</div>

<?php if(isset($msg))
			            {
				            echo '<font color="blue"; text-align:center; font-family:Courier New;>'.$msg."</font>";
				           } ?> 
 
<?php include "includes/footer.php";
include "includes/scripts.php";?>


			
		
	</body>
</html>