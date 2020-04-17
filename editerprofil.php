<?php 
	require_once "includes/function.php";		
	session_start();
	verifConnexion();
	$quizs = getDb()->query('select * from utilisateur'); 	
	include "includes/head.php";
?>
      
<!DOCTYPE html>

<html>	
	
<?php include "includes/header.php";
		
if(isset($_SESSION['login'])) 
{
			
	$requser = getDb()->prepare("SELECT * FROM utilisateur WHERE ut_nom = ?");
	$requser->execute(array($_SESSION['login']));
	$user = $requser->fetch();
				
	//voir si pseudo existe 
	$userexist = $requser->rowCount();				
	$reqmail = getDb()->prepare("SELECT * FROM utilisateur WHERE ut_mail = ?");
	$reqmail->execute(array($_SESSION['email']));
	$mail = $reqmail->fetch();
				
	//voir si mail existe
	$mailexist = $reqmail->rowCount();
	
	if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $user['ut_nom']) 						   
	{
		if($userexist == 0)  
		{							   
			$newpseudo = trim($_POST['newpseudo']);
			$insertpseudo = getDb()->prepare("UPDATE utilisateur SET ut_nom = ? WHERE ut_nom=?");
			$insertpseudo->execute(array($newpseudo, $user['ut_nom']));
			$_SESSION['login'] = $newpseudo;
							  
		}
		else
		{
			$msg = "Login déjà utilisé !";								
		}
	}
						 
	if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['ut_mail']) 					   
	{
						   
		if($mailexist == 0)
		{
			 $newmail = trim($_POST['newmail']);
			 $insertmail = getDb()->prepare("UPDATE utilisateur SET ut_mail = ? WHERE ut_nom=?");
			 $insertmail->execute(array($newmail, $user['ut_nom']));
					
		}
		else
		{
			$msg = "Mail déjà utilisé !";
		}
					 
	}
						 
	if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])) 					   
	{
		$mdp1 = ($_POST['newmdp1']);
		$mdp2 = ($_POST['newmdp2']);
						  
		if($mdp1 == $mdp2) 
		{
			$insertmdp = getDb()->prepare("UPDATE utilisateur SET ut_mdp = ? WHERE ut_nom=?");
			$insertmdp->execute(array($mdp1, $user['ut_nom']));
					
		} 
		else 
		{
			$msg = "Vos deux mdp ne correspondent pas !";
		}				  
	}
						
	//name : nom de la photo
	if(isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name'])) 	
	{
		//taille max de la photo
		$tailleMax = 200000;
		//extension autorisée
		$extensionsValides = array('jpg', 'jpeg', 'gif', 'png');					
						   
		//size : vérification de la taille du fichier importé
		if($_FILES['avatar']['size'] <= $tailleMax) 				   
		{
							   
			$extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
							  
			//vérifier si extension d'upload est dans le tableau d'extension
			if(in_array($extensionUpload, $extensionsValides)) 
			{
								  								  
				$chemin = "membres/avatars/".$_SESSION['login'].".".$extensionUpload;
				//déplacer le fichier dans notre destination (chemin)
				$resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
								 
				if($resultat) 
				{
					$updateavatar = getDb()->prepare('UPDATE utilisateur SET avatar = :avatar WHERE ut_nom = :ut_nom');
					$updateavatar->execute(array(
						'avatar' => $_SESSION['login'].".".$extensionUpload, //nom fichier
						'ut_nom' => $_SESSION['login']));

				} 
				else 
				{
					$msg = "Erreur durant l'importation de votre photo de profil";
				}
			}
			
			else 
			{
				$msg = "Votre photo de profil doit être au format jpg, jpeg, gif ou png";
			}
		} 
		else 
		{
			$msg = "Votre photo de profil ne doit pas dépasser 2Mo";
		}
	}
} ?>
  
   <body>
       
       <div class="containeurGlobal">
        
        <form method="POST" action="" enctype="multipart/form-data">
            
			<div class="edition" align="center">
				<h2><strong>Edition de mon profil</strong></h2><br /><br />
               <label>Pseudo :</label>
					<input type="text" name="newpseudo" placeholder="Pseudo"/><br /><br />
               <label>Mail :</label>
					<input type="text" name="newmail" placeholder="Mail"  /><br /><br />
               <label>Mot de passe :</label>
					<input type="text" name="newmdp1" placeholder="Mot de passe"/><br /><br />
               <label>Confirmer votre mot de passe :</label>
					<input type="text" name="newmdp2" placeholder="Confirmation du mot de passe" /><br /><br />
		
			   <button type="submit" name="edition" class="boutonc"><span class="glyphicon glyphicon-log-in"></span>Editer mon profil</button>
				<br/>
				<br/>				
				<a href="logout.php"> Reconnectez-vous pour actualiser vos données</a><br/><br/>	
			
		    </div>
		
    		<div class="editionavatar" align="center">
    		    
    			<h2><strong>Modifier mon avatar<strong/></h2><br /><br />
    			<label>Avatar :</label>
    			<input type="file" name="avatar" /> <br/><br/>
    			<input type="submit" value="Mettre à jour mon avatar !" /> 
         
    		</div>
		
		</div>
		</form>
	</body>
	
	  
     <?php
			 
	if(isset($msg))
	{
		echo '<font color="blue"; text-align:center;>'.$msg."</font>";
	}
	include('includes/scripts.php');
?>	    

</html>

