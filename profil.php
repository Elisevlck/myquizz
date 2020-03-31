<!DOCTYPE html>

<html>
<?php 
		require_once "includes/function.php";		
		session_start();
		$quizs = getDb()->query('select * from utilisateur'); 	
		include "includes/head.php";?>
      
	<body>
<?php include "includes/header.php";
		
		/*if(isset($_SESSION['login']))
		{
			$reqtime=getDb()->prepare("select * from utilisateur where lastlogin=? and ut_nom='".$_SESSION['login']."' ");
			
					
			$requete=getDb()->query("UPDATE utilisateur SET lastlogin='". time() ."' WHERE ut_nom='".$_SESSION['login']."' ");
	

}*/ 

	if(isset($_SESSION['login']))    	
{	 
	$requete=getDb()->query("select * from utilisateur where ut_nom='".$_SESSION['login']."' ");
	$dnn=$requete->fetch(); 
} 



?>	
		


<div class="monprofil">		
	<h1> MON PROFIL </h1> 
	<br/>

	<br/><br/>
	<h6>
		Statut : <?= $_SESSION['role']?>
		<br/><br/>Dernière connexion : 
		<?php echo 'Le '.date("d/m/Y \a H:i", $_SESSION['lastlogin']);?> 
		<?php if ($dnn['lastlogin'] == 0){ echo 'Cet utilisateur ne c\'est jamais connecté(e).'; } else { echo date('d/m/Y \a H:i',$dnn['lastlogin']);} ?>
		<br/><br/>Pseudo : <?= $_SESSION['login']?>
		<br/><br/>Adresse mail : <?= $_SESSION['email']?>
		<br/><br/>Mot de passe : <?= $_SESSION['password']?>	 
	</h6> 


	<br/>Avatar : 			
				<?php 
				
				// $getlogin = intval($_GET['login']);
				$reqlog = getDb()->prepare('select avatar from utilisateur where ut_nom="'.$_SESSION['login'].'" '); 
				$reqlog->execute(array($_SESSION['login']));
				$reqlog=$reqlog->fetch();
				
				if($reqlog['avatar'] == NULL) 
				{ 
					echo "Vous n'avez pas d'avatar !";
			
				}
				else
				{
					$_SESSION['avatar'] = $reqlog['avatar'];
					
				
				?>
				<img src="membres/avatars/<?php echo $reqlog['avatar']; ?>"  width="180"/>
			
				


				<?php
				
				}
				?>
				
	<br/><br/>		
<a href ="editerprofil.php"><button type="button" class="button">Editer mon profil</button></a>		

</div>			
				
				
				
				<?php if(isset($erreur))
			{
				echo '<font color="blue"; text-align:center;>'.$erreur."</font>";
			}
			include('includes/footer.php'); 
			include('includes/scripts.php'); 

			?>	
				


	</body>
    </html>