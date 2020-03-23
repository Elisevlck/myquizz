<!DOCTYPE html>

<html>

<? 
	require_once "includes/head.php";
	require_once "includes/header.php";
	include('fonction.php');
	
<body>

<?php


//connexion db
$bdd=new PDO('mysql:host=localhost;dbname=phplogin','root','');

session_start();

//formulaire rempli
if(!empty($_POST['login']) AND !empty($_POST['password']))
{
	
	//db
	$requete = $bdd->prepare('select * from utilisateur where ut_login =? and ut_mdp =?');
	
	//récupère variable
	$loginconnect = trim($_POST['login']);
	$mdpconnect = trim($_POST['password']); 

		
	$requete->execute(array($loginconnect,$mdpconnect));
	$resultat = $requete->fetch();


	//mot de passe entrée même que celui de la db
	if($mdpconnect == $resultat['ut_mdp']) //affiche erreur jsp pq
	{
		//reconnaissance de l'utilisateur
		if($requete->rowCount() == 1)
		{
			
			$_SESSION['login'] = $loginconnect;
		
			//si ut est admin
			if($resultat['ut_statut'] == "admin")
			
			{
				//echo "ok"; //vérif
				//à compléter redirection vers page accueil pour admin (test)
				redirect('mdpoublie.php'); 

			}
			//si ut est joueur			
			else
			{
				//echo "okk"; //vérif
				//à compléter redirection vers page accueil pour joueur (test)
				redirect('mdpoublie.php');
				
			}
		
		}
		else
		{
			$erreur = "Utilisateur non reconnu !";
		}
	}
	else
	{		
		$erreur = "Mauvais login ou mdp !";		
	}
}

else
{
	$erreur = "Veuillez saisir tous les champs !";
}


		
	



?>

<div class="conteneurconex">
     
            <form method="post" action="connexion.php">

                <div id="connexion">
                <fieldset><legend><strong>Qui êtes-vous ?</strong></legend>

                <label for="login"><i>Login : </i> </label> <input type="text" name="login" class="form-control" placeholder="Entrez votre login" required autofocus>
                                 
               <br/>
               
                <label for="login"><i> Mot de passe : </i></label><input type="password" name="password" class="form-control" placeholder="Entrez votre mot de passe" required>
                <br/>
                    <a href="mdpoublie.php"><i>Mot de passe oublié ?</i></a><br />
                <a href="inscription.php"><i>Nouveau sur le compte ? Inscrivez-vous</i></a>
                <br/>
<br />
                
                <button type="submit" name="connexion" class="boutonC"><span class="glyphicon glyphicon-log-in"></span>Se connecter</button>
                <br/>

                
                </div>  


                
                </fieldset>
                        
            </form>

</div>






 
 
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script> 
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
		
		
			<?php
			if(isset($erreur))
			{
				echo '<font color="blue"; text-align:center;>'.$erreur."</font>";
			}?>	
		
		
	</body>
    </html>