<?php 
	require_once "includes/function.php";		
	session_start();
	verifConnexion();
?>

<!DOCTYPE html>	

<html>  

    <?php 
        $pageTitle="Profil";
        include "includes/head.php";
    ?>
    
	<body>
	    
	    <?php require_once "includes/header.php";
		
    	if(isset($_SESSION['login']))    	
    	{	 
    		$requete=getDb()->query("select * from utilisateur where ut_nom='".$_SESSION['login']."' ");
    		$dnn=$requete->fetch(); 
    	} 

        ?>	

        <img src="images\profil.gif" style="float:left; margin-left:5%; margin-top:20%;" width="35%"></img>	
        
		<div class="monprofil">	
		
			<h1> MON PROFIL </h1> <br/><br/><br/>
		
			<strong>Statut :</strong> <?= $_SESSION['role']?><br/><br/>
			<strong>Dernière connexion :</strong> 
			
			<?php 
    			if ($dnn['lastlogin'] == 0)
    			{ 
    				echo 'Cet utilisateur ne s\'est jamais connecté(e).'; 
    				$time=time();
    			 	$requete=getDb()->query("UPDATE utilisateur SET lastlogin='". $time ."' WHERE ut_nom='".$_SESSION['login']."' ");	
    			}
    			else 
    			{ 
    				echo date('d/m/Y \à H:i',$dnn['lastlogin']);
    				$time=time();
    				$requete=getDb()->query("UPDATE utilisateur SET lastlogin='". $time ."' WHERE ut_nom='".$_SESSION['login']."' ");
    			} 
			?>
			<br/><br/>
			
			<strong>Pseudo :</strong> <?= $_SESSION['login']?><br/><br/>
				
			<strong>Adresse mail :</strong> <?= $_SESSION['email']?><br/><br/>
			<strong>Mot de passe :</strong> <?= $_SESSION['password']?><br/><br/>
			 
			<strong>Avatar :</strong> 
			
				<?php 
						
					$reqlog = getDb()->prepare('select avatar from utilisateur where ut_nom="'.$_SESSION['login'].'" '); 
					$reqlog->execute(array($_SESSION['login']));
					$reqlog=$reqlog->fetch();
						
					if($reqlog['avatar'] == NULL) 
					{ 
						echo "Vous n'avez pas d'avatar !";
					}
					else
					{
						$_SESSION['avatar'] = $reqlog['avatar']; ?>
						<img src="membres/avatars/<?php echo $reqlog['avatar']; ?>"  width="180""/> 
											
				    <?php 
					} 
				?>
						
			<br/><br/>
			
			<a class="option" href="editerprofil.php">Editer mon profil</a> <br/><br/>  	
			<a class="option" href="histo.php">Consulter mon historique & statistiques</a> <br/><br/>
			
		</div>			
				
	</body>
	
	<?php
	include('includes/footer.php'); 
	include('includes/scripts.php'); 
	?>	
	
</html>