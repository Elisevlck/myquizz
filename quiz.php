<?php
	require_once "includes/function.php";
	session_start();

	$quizId = $_GET['id'];
	
	$stmt = getDb()->prepare('select * from quiz where quiz_id=?');
	$stmt->execute(array($quizId));
	$quizs = $stmt->fetch(); // Access first (and only) result line
	
	$stmt2 = getDb()->prepare('select * from question where quiz_id=?');
	$stmt2->execute(array($quizId));
	$questions = $stmt2->fetchAll(); // Access first (and only) result line	
	
	$stmt3 = getDb()->prepare('select * from reponse');
	$stmt3->execute(array());
	$reponses = $stmt3->fetchAll(); // Access first (and only) result line	
?>

<!doctype html>
<html>

	<?php 
		$pageTitle = $quizs['quiz_nom'];
		require_once "includes/head.php"; 
	?>

	<body>
	
	
		<div class="container">
			<?php require_once "includes/header.php"; ?>

			<div class="jumbotron">
				
				<h2><?= $quizs['quiz_nom'] ?></h2>
				<p>Nombre de questions : <?= $quizs['nbquestions'] ?> questions</p>
				<p>Thème : <?= $quizs['theme_nom'] ?></p>
				<p><small>Date de création : <?= $quizs['datecreation'] ?></small></p>
				
				<h1> Répondre aux questions suivantes : </h1>
				
				<form action="resultat.php" Method="POST">
				
					<?php $i=1;?>
								
					<?php foreach ($questions as $question) { ?>
					
						<strong><?=$i?>) <?= $question['ques_cont'] ?></strong><br/><?php
						
						// type texte
						if ($question['ques_type']=="texte"){?>
							<input type="text" name ="rep$i" size="17" /><br/>
						<?php }						
						
						// type checkbox					
						if ($question['ques_type']=="multiple"){
									
							foreach ($reponses as $reponse) { 
								if ($reponse['ques_id']==$question['ques_id']){
									?><label><input type="checkbox" name="rep$i" value="<?= $reponse['rep_cont'] ?>"/><?= $reponse['rep_cont'] ?></label><?php
						
						} } } 
						
						// type radio					
						if ($question['ques_type']=="unique"){
									
							foreach ($reponses as $reponse) { 
								if ($reponse['ques_id']==$question['ques_id']){ 
									?><label><input type="radio" name="rep$i" value="<?= $reponse['rep_cont'] ?>"/><?= $reponse['rep_cont'] ?></label><?php
						} } }
						
						$i++;						
						
					?><br/><br/>	
                			
				
				<?php } ?>			
				
				<button type="submit" name="inscription" class="boutonC"><span class="glyphicon glyphicon-log-in"></span> Valider</button>		
			</form>
				
			</div>

			<?php require_once "includes/footer.php"; ?>
		</div>

		<?php require_once "includes/scripts.php"; ?>
	</body>

</html>