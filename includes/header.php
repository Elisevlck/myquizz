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
             
            <div id="logo">  <p><a href="page1.php"><img src="images/logo1.png" width="80" /></a></p></div> 
			
            <li>Quizz par thème
                <ul class="sous">
				
                    <?php foreach ($autres as $theme) { ?>				
						<li><a class="link" href="index_quiz.php?id=<?= $theme['theme_id'] ?>"><?= $theme['theme_nom'] ?></a></li>						
				<?php } ?>                             
                </ul>
            </li>
			
			
            <li>Révisions
                <ul class="sous">
				
                    <?php foreach ($revisions as $revision) { ?>
				
						<li><a class="link" href="index_quiz.php?id=<?= $revision['theme_id'] ?>"><?= $revision['theme_nom'] ?></a></li>
						
				<?php } ?>	                
                </ul>
            </li> 
			
				<?php if (isUserConnected()) { ?>
					<li> Bienvenue <?= $_SESSION['login'] ?><b class="caret"></b>
						<ul class="sous">
							<li ><a class="link" href ="logout.php">Déconnexion</a></li> 							
							<li ><a class="link" href ="hist.php">Historique/statistique</a></li>  
							 <li ><a class="link" href ="profil.php">Mon profil</a></li>

						</ul>
					</li>
														
					<?php } else { ?>
					<li>Non connecté
						<ul class="sous">
							<li><a class="link" href="login.php">Se connecter</a></li>
						</ul>
					</li>                                   
        </ul>
		   <?php } ?>
    </nav>

</header>