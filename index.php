<?php
	session_start();
	require_once "includes/function.php";
?>

<html>
    
    <?php 
    	$pageTitle = "Page d'accueil";
    	require_once "includes/head.php"; 
    ?> 
    	
    <body>
    		<?php include "includes/header.php";?>
      
    		<div class="conteneur">		
    			
    			<div id="carouselExampleControls" class="carousel slide">
    			
    				<div class="carousel-inner">
    				
    					<div class="carousel-item active">
    						<img class="d-block w-100" src="images/géo1.png" alt="First slide">
    					</div>
    					
    					<div class="carousel-item">
    						<img class="d-block w-100" src="images/sport.png" alt="Second slide">
    					</div>
    					
    					<div class="carousel-item">
    						<img class="d-block w-100" src="images/maths1.jpg" alt="Third slide">
    					</div>
    					
    					<div class="carousel-item">
    						<img class="d-block w-100" src="images/intouchable.jpg" alt="Fourth slide">
    					</div>
    					
    				</div>
    				
    				<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    					<span class="carousel-control-prev-icon"></span>
    					<span class="sr-only">Previous</span>
    				</a>
    				
    				<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    					<span class="carousel-control-next-icon"></span>
    					<span class="sr-only">Next</span>
    				</a>
    				
    		</div>
    		
    		<div class="description"><h2>Marre des révisions ?</h2><br/>	
    			<strong>MYQUIZZ</strong> vous propose de vous DIVERTIR <br />tout en révisant et en vous amusant !<br/>	
    			Il suffit juste de vous inscrire <br/>pour pouvoir profiter de nos quizz !<br/><br/>
    				<?php
    		
        		if(isUserConnected())
        		{
        	    	echo '<a href="index_all_quiz.php"><button type="button" class="bouton">JOUER !</button></a>';
        		}
        		else 
        		{  
        		    echo '<a href="login.php"><button type="button" class="bouton">JOUER !</button></a>';
                }  
            
            ?>
    		</div>
    		
    	</div>
    
    <?php require_once"includes/footer.php"; ?>
    <?php require_once"includes/scripts.php"; ?>
    
	</body>
	
</html>