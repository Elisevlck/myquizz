<?php
	require_once "includes/function.php";
	session_start();

	$quizId = $_GET['id'];
	
	$stmt = getDb()->prepare('select * from quiz where quiz_id=?');
	$stmt->execute(array($quizId));
	$quiz = $stmt->fetch(); // Access first (and only) result line
		
	$stmt2 = getDb()->prepare('select * from question where quiz_id=?');
	$stmt2->execute(array($quizId));
	$questions = $stmt2->fetch(); // Access first (and only) result line	
	
	$reponses = getDb()->query('select * from reponse');	
?>

<!doctype html>
<html>

	<?php 
		$pageTitle = $quiz['quiz_nom'];
		require_once "includes/head.php"; 
	?>

	<body>
		<div class="container">
			<?php require_once "includes/header.php"; ?>

			<div class="jumbotron">
				
				<h2><?= $quiz['quiz_nom'] ?></h2>
				<p>Nombre de questions : <?= $quiz['nbquestions'] ?> questions</p>
				<p>Thème : <?= $quiz['theme_nom'] ?></p>
				<p><small>Date de création : <?= $quiz['datecreation'] ?></small></p>
				
				<?php foreach ($questions as $question) { ?>
				
				<p><?= $question['ques_cont'] ?></p>
				
				<?php	
				if ($question['ques_type']=="texte")
				{?>
					<input type="text" name ="titre" size="17" /><br/>
				<?php } ?>
								
				<?php	
				
				if ($question['ques_type']=="radio"){
				
					foreach ($reponses as $reponse) { ?>
							
							<?php if ($reponse['ques_id']==$question['ques_id']){ ?>
								
								<label><input type="radio" name="repp[]" value="<?= $reponse['rep_cont'] ?>"/><?= $reponse['rep_cont'] ?></label>							
													
				<?php } } } ?>
				
				<?php	
				if ($question['ques_type']=="checkbox"){?>
					
					<?php foreach ($reponses as $reponse) { ?>
						
						<?php if ($reponse['ques_id']==$question['ques_id']){ ?>
							
							<label><input type="checkbox" name="rep[]" value="<?= $reponse['rep_cont'] ?>"/><?= $reponse['rep_cont'] ?></label>
												
				<?php } } } ?>
				<br/><br/>				
			
			<?php } ?>
				
				
						
						
				
			</div>

			<?php require_once "includes/footer.php"; ?>
		</div>

		<?php require_once "includes/scripts.php"; ?>
	</body>

</html>