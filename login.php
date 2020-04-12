<?php 
		require_once "includes/function.php";		
		session_start();
		$quizs = getDb()->query('select * from utilisateur'); 
?>

<!DOCTYPE html>

<html>
	
	<?php $pageTitle="Connexion";
	require_once "includes/head.php"; ?>		
	
	<body>
	
		<?php
		require_once"includes/header.php"; 	

		//formulaire rempli
		if(!empty($_POST['login']) AND !empty($_POST['password']) AND !empty($_POST['role']))
		{
			
			//récupère variable
			$loginconnect = trim($_POST['login']);
			$mdpconnect = trim($_POST['password']);
			$roleconnect = trim($_POST['role']);	
			
			
			//db
			$requete = getDb()->prepare('select * from utilisateur where ut_nom =? and ut_mdp =?');
			$requete->execute(array($loginconnect,$mdpconnect));
			$resultat = $requete->fetch();

			//reconnaissance de l'utilisateur
			if($requete->rowCount() == 1)
			{	

				if($mdpconnect == $resultat['ut_mdp'])
				{	
					$_SESSION['login'] = $loginconnect;	
					$_SESSION['password'] = $mdpconnect;
								
					if($roleconnect == $resultat['ut_role'])
					{
						//si ut est admin
						if($resultat['ut_role'] == "administrateur")							
						{	
							$_SESSION['role'] = $roleconnect;
							$_SESSION['email'] = $resultat['ut_mail'];	
							// $resultat['lastlogin'] = time();
							// $_SESSION['lastlogin'] = $resultat['lastlogin'];
							$requete=getDb()->query("UPDATE utilisateur SET lastlogin='". time() ."' WHERE ut_nom='".$_SESSION['login']."' ");
								
							redirect('profil.php');
							
						}
						//si ut est joueur			
						else
						{
								
							$_SESSION['role'] = $roleconnect;	
							$_SESSION['email'] = $resultat['ut_mail'];								
							$resultat['lastlogin'] = time();
							$_SESSION['lastlogin'] = $resultat['lastlogin'];
							$requete=getDb()->query("UPDATE utilisateur SET lastlogin='". time() ."' WHERE ut_nom='".$_SESSION['login']."' ");
								
							redirect('profil.php');
								
						}				
					}
					else
					{
						$msg="Vous n'êtes pas un ".$roleconnect;
					}
				}
				else
				{
					$msg = "Mauvais mdp !";
				}
			}
			else
			{		
				$msg = "Utilisateur non reconnu !";		
			}
		}
		else
		{
			$msg = "Veuillez saisir tous les champs !";
		}
		
?>

		<div class="conteneurconex">
			 
			<form method="post" action="login.php">

				<div id="connexion">
					<fieldset><legend><strong>Qui êtes-vous ?</strong></legend>
						
						<input type="radio" name="role" value="administrateur"/><label for="admin">Administrateur</label>
						<input type="radio" name="role" value="joueur"/><label for="joueur">Joueur</label><br/>

						<label for="login"><i>Login : </i> </label> <input type="text" name="login" class="form-control" placeholder="Entrez votre login" required autofocus>				 
					    <br/>
					   
						<label for="login"><i> Mot de passe : </i></label><input type="password" name="password" class="form-control" placeholder="Entrez votre mot de passe" required>
						<br/>
						
						<a href="mdpoublie.php"><i>Mot de passe oublié ?</i></a><br />
						<a href="inscription.php"><i>Nouveau sur le compte ? Inscrivez-vous</i></a>
						<br/>
						<br/>
						
						<button type="submit" name="connexion" class="boutonC"><span class="glyphicon glyphicon-log-in"></span>Se connecter</button>
						<br/>

					</fieldset>	
				</div>  							
			</form>
		</div>
		
			<?php
			if(isset($msg))
			{
				echo '<font color="blue"; text-align:center;>'.$msg."</font>";
			}?>	
	
	<?php require_once"includes/footer.php"; ?>
	<?php require_once"includes/scripts.php"; ?>		
		
	</body>
    </html>