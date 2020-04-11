<?php 
	require_once "includes/function.php";
	
	$stmt = getDb()->prepare('select * from theme where genre_id="1"');
	$stmt->execute(array());
	$autres = $stmt->fetchAll(); 
	
	$stmt2 = getDb()->prepare('select * from theme where genre_id="2"');
	$stmt2->execute(array());
	$revisions = $stmt2->fetchAll()
?>
<header>
    <nav>        
        <ul>
            		
<?php 
	
	if(isUserConnected())
	{			
		if (isJoueur()) 
		{ ?>
			 
			 <div id="logo">  <p><a href="page1.php"><img src="images/logo1.png" width="80" /></a></p></div> 
			
            <li>Quizz par thème
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
					<li> Bienvenue <?= $_SESSION['login'] ?><b class="caret"></b> 
					
						<?php 
					if(!empty($_SESSION['avatar']))
					{?>
						
						<img src="membres/avatars/<?php echo $_SESSION['avatar']; ?>"  style="margin-left:10px;" width="100" />
			<?php	}?>
					<ul class="sous">
							<li ><a class="link" href ="logout.php">Déconnexion</a></li> 							
							<li ><a class="link" href ="hist.php">Historique/statistique</a></li>  
							<li ><a class="link" href ="profil.php">Mon profil</a></li>

						</ul>
					</li>
 <?php } ?>
			 			 		 
<?php 
		if (isAdmin()) 

		{ ?>
				
				<div id="logo">  <p><a href="page1.php"><img src="images/logo1.png" width="80" /></a></p></div> 
			
            <li>Quizz par thème
                <ul class="sous">
				
					
				
                    <?php foreach ($autres as $theme) 
					{ ?>				
						<li><a class="link" href="index_quiz.php?id=<?= $theme['theme_id'] ?>"><?= $theme['theme_nom'] ?></a></li>						
				<?php } ?>                           
			
				
				<li><a class="link" href="add_theme.php?id=1">Ajouter un thème </a></li>	
				
                </ul> 
									
            </li>
		
			
            <li>Révisions
                <ul class="sous">
				
                    <?php foreach ($revisions as $revision) 
					{ ?>
				
						<li><a class="link" href="index_quiz.php?id=<?= $revision['theme_id'] ?>"><?= $revision['theme_nom'] ?></a></li>
						
				<?php } ?>
				<li><a class="link" href="add_theme.php?id=2">Ajouter une révision </a></li	 >               
                </ul>
            </li> 
			
					<li> Bienvenue <?= $_SESSION['login'] ?><b class="caret"></b>

					
					
					
					<?php 
					if(!empty($_SESSION['avatar']))
					{?>
						
						<img src="membres/avatars/<?php echo $_SESSION['avatar']; ?>"  style="margin-left:10px;" width="100" />
			<?php	}?>
			
			<ul class="sous">
						<li ><a class="link" href ="logout.php">Déconnexion</a></li> 							
						<li ><a class="link" href ="hist.php">Historique/statistique</a></li>  
						<li ><a class="link" href ="profil.php">Mon profil</a></li>

					</ul>
					</li>
														
<?php  } 
			
	} 
	else 
	{ ?>
				
			<div id="logo">  <p><img src="images/logo1.png" width="80" /></p></div> 
			
            <li>Quizz par thème
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
						<li><a class="link" href="login.php">Se connecter</a></li>
					</ul>
			</li>					
<?php
	} ?>					
        </ul>
    </nav>
</header>