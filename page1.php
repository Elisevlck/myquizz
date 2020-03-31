<!DOCTYPE html>
<?php
	require_once "includes/function.php";
	session_start();
	$quizs = getDb()->query('select * from utilisateur'); 
?>

<!doctype html>

<html>

	<?php 
		$pageTitle = "Page d'accueil";
		require_once "includes/head.php"; 
	?>
   
	<body>
	
		<?php include "includes/header.php";?>
				
		<div  class="connexion"><a href ="login.php"><button type="button" class="bouton">JOUER !</button></a></div>   

		<div class="conteneur">		   
			<div id="carousel" class="carousel slide">
		  <div class="carousel-inner">
			<div class="carousel-item active">
			  <img class="d-block w-100" src="images/revision1.jpg"
				alt="First slide">
			</div>
			<div class="carousel-item">
			  <img class="d-block w-100" src="images/sport1.jpg"
				alt="Second slide">
			</div>
			<div class="carousel-item">
			  <img class="d-block w-100" src="images/cinema1.jpg"
				alt="Third slide">
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


    <div class="description"><h2>Marre des révisions ?</h2>
    <br/>
    <strong>MYQUIZZ</strong> vous propose de vous DIVERTIR <br />tout en révisant et en vous amusant !
    <br/>
    Il suffit juste de vous inscrire <br/>pour pouvoir profiter de nos quizz !<br/><br/>

    <mark>À vous de<font size="6pt"> JOUER !</font></mark></div>
</div>


<?php include('includes/footer.php'); ?>
<?php include('includes/scripts.php'); ?>


	</body>
    </html>