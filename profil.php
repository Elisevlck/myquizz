<!DOCTYPE html>

<html>
<?php 
		require_once "includes/function.php";		
		session_start();
		$quizs = getDb()->query('select * from utilisateur'); 
	
 include "includes/head.php";?>
   
   
	<body>
	
		<?php include "includes/header.php";
		
		?>

<div class="monprofil">		
	<h1> MON PROFIL </h1> 
	<br/>
	<br/>Avatar : <?= $_SESSION['login']?>
	<br/><br/>
	<h6>
		Statut : <?= $_SESSION['role']?>
		<br/>Dernière connexion : 
		<br/>Pseudo : <?= $_SESSION['login']?>
		<br/>Adresse mail : <?= $_SESSION['email']?>
		<br/>Mot de passe : <?= $_SESSION['password']?>	 
	</h6> 

</div>
	<?php
	if(isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name'])) 
	
	
	
	{
	   $tailleMax = 2097152;
	   $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');
	   
	   if($_FILES['avatar']['size'] <= $tailleMax) 
	   
	   {
	      $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
	      if(in_array($extensionUpload, $extensionsValides)) 
		  {
	         $chemin = "membres/avatars/".$_SESSION['login'].".".$extensionUpload;
			 
	         $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
			 
	         if($resultat) 
			 {
	            $updateavatar = getDb()->prepare('UPDATE utilisateur SET avatar = :avatar WHERE ut_id = :ut_id');
	            $updateavatar->execute(array(
	               'avatar' => $_SESSION['login'].".".$extensionUpload,
	               'ut_id' => $_SESSION['login']
	               ));
	            header('Location: profil.php?id='.$_SESSION['login']);
	         } else {
	            $msg = "Erreur durant l'importation de votre photo de profil";
	         }
	      } else {
	         $msg = "Votre photo de profil doit être au format jpg, jpeg, gif ou png";
	      }
	   } else {
	      $msg = "Votre photo de profil ne doit pas dépasser 2Mo";
	   }
	}
	?>


<div align="left" action="">

	<form method="POST" action="" enctype="multipart/form-data">
		<label>Avatar :</label>
		<input type="file" name="avatar" /> <br/><br/>
		<input type="submit" value="Mettre à jour mon profil !" />
		
				
				<?php 
				
				$getlogin = intval($_GET['login']);
				$reqlog = getDb()->prepare('select * from utilisateur where avatar=?'); 
				$reqlog->execute(array($getlogin));
				$logexist=$reqlog->rowCount();
				
				if(!empty($logexist['avatar'])) 
				{ 
				?>
				<img src="membres/avatars/<?php echo $logexist['avatar'];} ?>
		
		
		

<?php include('includes/footer.php'); ?>
<?php include('includes/scripts.php'); ?>


	</body>
    </html>