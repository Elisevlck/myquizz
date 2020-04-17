<?php 
	require_once "includes/function.php";
	
	$stmt = getDb()->prepare('select * from theme where genre_id="1"');
	$stmt->execute(array());
	$autres = $stmt->fetchAll(); 
	
	$stmt2 = getDb()->prepare('select * from theme where genre_id="2"');
	$stmt2->execute(array());
	$revisions = $stmt2->fetchAll();

	if(isUserConnected())
	{
	$reqlog = getDb()->prepare('select avatar from utilisateur where ut_nom="'.$_SESSION['login'].'" ');
	$reqlog->execute(array($_SESSION['login']));
	$reqlog=$reqlog->fetch();
	}
?>


<header>
    <nav>        
        <ul>
            		
<?php 
	
	if(isUserConnected())
	{			
		if (isJoueur()) 
		{ ?>
			 
			<div id="logo">  <p><a href="index.php"><img src="images/logo1.png" width="100%" style="margin-top:1vw;"/></a></p></div> 
			
            <li>Thèmes
            
                <ul class="sous">
				
                    <?php foreach ($autres as $theme) 
					{ ?>				
						<li><a class="link" href="index_quiz.php?id=<?= $theme['theme_id'] ?>"><?= $theme['theme_nom'] ?></a></li>						
				<?php } ?>                           
							
                </ul> 	
                
            </li>
			
            <li>Révisions
                <ul class="sous">
                    
                    <?php foreach ($revisions as $revision) 
					{ ?>
						<li><a class="link" href="index_quiz.php?id=<?= $revision['theme_id'] ?>"><?= $revision['theme_nom'] ?></a></li>
						
			<?php	} ?>
                </ul>
            </li> 		
					
			
			<li> <?php 
				if(!empty($reqlog['avatar']))
				{?>
						
					<img src="membres/avatars/<?php echo $reqlog['avatar']; ?>"  " width="20%"  />
			    <?php }?>
			   
			    Bienvenue <?= $_SESSION['login'] ?><b class="caret"></b> 
					
				<ul class="sous">
				    
					<li ><a class="link" href ="logout.php">Déconnexion</a></li> 							
					<li ><a class="link" href ="histo.php">Historique - statistique</a></li>  
					<li ><a class="link" href ="profil.php">Mon profil</a></li>
					<li ><a class="link" href ="">Tutoriel</a></li>

				</ul>
			</li>
			
        <?php } ?>
			 			 		 
        <?php if (isAdmin()) { ?>
				
			<div id="logo">  <p><a href="index.php"><img src="images/logo1.png" width="100%" style="margin-top:1vw;"/></a></p></div> 
			
            <li>Thèmes
                <ul class="sous">
                    
                        <li><a class="link" href="suppr_theme.php?id=1">Supprimer un thème </a></li>
                    
                    <?php foreach ($autres as $theme) 
					{ ?>				
						<li><a class="link" href="index_quiz.php?id=<?= $theme['theme_id'] ?>"><?= $theme['theme_nom'] ?></a></li>						
				    <?php } ?>                           
			            
			            <li><a class="link" href="add_theme.php?id=1">Ajouter un thème </a></li>	
                </ul> 				
            </li>
		
			
            <li>Révisions
                <ul class="sous">
                    
                    <li><a class="link" href="suppr_theme.php?id=2">Supprimer une révision </a></li>
				
                    <?php foreach ($revisions as $revision) 
					{ ?>
				
						<li><a class="link" href="index_quiz.php?id=<?= $revision['theme_id'] ?>"><?= $revision['theme_nom'] ?></a></li>
				    <?php } ?>
				    
				<li><a class="link" href="add_theme.php?id=2">Ajouter une révision </a></li	 >               
                
                </ul>
           
            </li> 
			
			<li> <?php 
				if(!empty($_SESSION['avatar']))
				{?>
						
					<img src="membres/avatars/<?php echo $_SESSION['avatar']; ?>" width="20%" />
			    <?php	}?>
			    Bienvenue <?= $_SESSION['login'] ?><b class="caret"></b>
			
    			<ul class="sous">
    			    
    				<li ><a class="link" href ="logout.php">Déconnexion</a></li> 							
    				<li ><a class="link" href ="histo.php">Historique - statistique</a></li>  
    				<li ><a class="link" href ="profil.php">Mon profil</a></li>
    				<li ><a class="link" href ="">Tutoriel</a></li>
                </ul>
				
			</li>
														
<?php  } 
			
	} 
	
	else 
	{ ?>
				
			<div id="logo">  <p><img src="images/logo1.png" width="100%" style="margin-top:1vw;"/></p></div> 
			
            <li>Thèmes
                <ul class="sous">
				
                    <?php foreach ($autres as $theme) 
					{ ?>				
						<li><a class="link"><?= $theme['theme_nom'] ?></a></li>						
				<?php } ?>                           
							
                </ul> 									
            </li>
			
            <li>Révisions
                <ul class="sous">
				
                    <?php foreach ($revisions as $revision) 
					{ ?>
				
						<li><a class="link"><?= $revision['theme_nom'] ?></a></li>
						
				    <?php } ?>
				
                </ul>
            </li> 
			
			<li>Non connecté
					<ul class="sous">
						<li><a class="link" href="login.php">Connexion - Inscription</a></li>
						<li><a class="link" href="https://www.youtube.com/watch?v=lJc3FU8c2rc">Tutoriel</a></li>
					</ul>
			</li>					
    <?php
	} ?>				
	
        </ul>
    </nav>
</header>