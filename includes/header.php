<header>
    <nav>        
        <ul>
             
            <div id="logo">  <p><a href="page1.php"><img src="images/logo1.png" width="80" /></a></p></div> 
            

            <li>Quizz par thème
                <ul class="sous">
                    <li ><a class="link" href ="sport.php">Sport</a></li>
                    <li ><a class="link" href ="cinema.php">Cinéma</a></li>                                
                </ul>
            </li>
            <li>Révisions
                <ul class="sous">
                    <li ><a class="link" href ="histgeo.php">Histoire/Géographie</a></li>
                    <li ><a class="link" href ="maths.php">Maths</a></li>                 
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