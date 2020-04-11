<?php
	require_once "includes/function.php";
	session_start();

	$quizId = $_GET['id'];
	$niveau = $_GET['niv'];
	$themeId=$_GET['tId'];
	$numQues=$_GET['num'];
	$scoreActu=$_GET['score'];
	
	$stmt = getDb()->prepare('select * from quiz where quiz_id=?');
	$stmt->execute(array($quizId));
	$quizs = $stmt->fetch(); 
?>

<html>

	<?php 
		$pageTitle = $quizs['quiz_nom'];
		require_once "includes/head.php"; 
	?>
	
	<body>
	
		<?php require_once "includes/header.php"; ?>
		
		<div class="conteneurconex">
		
			<div id="connexion">
			
				<h1> Correction : <?=$quizs['quiz_nom']?> </h1>
				Votre score est : <?=$scoreActu?>. <br/>
				Il y avait : <?=$quizs['nbquestions']?> questions.<br/>
				
			<?php	
			$time_start = $_POST['var1'];
			
			$time = time()- $time_start;

			echo  $time." secondes\n";
			/*echo '<br/>';
			
			$time = time() - $debut;
			echo  "Chronomètre : ".$time." secondes\n";	*/	
			$date = date("Y-m-d");
			echo '<br/>';
			echo '<br/>';
			echo '<br/>';
			?>
				
			</div>
		</div>