<?php
	require_once "includes/function.php";
	session_start();

	$quizId = $_GET['id'];
	
	$stmt = getDb()->prepare('select * from quiz where quiz_id=?');
	$stmt->execute(array($quizId));
	$quiz = $stmt->fetch(); // Access first (and only) result line
	
		
	$stmt2 = getDb()->prepare('select * from question where quiz_id=?');
	$stmt2->execute(array($quizId));
	$questions = $stmt2->fetchAll(); // Access first (and only) result line	
	
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
				
				<h1> Répondre aux questions suivantes : </h1>
				
				<form action="quiz.php" Method="POST">
				
					<?php $i=1;?>
								
					<?php foreach ($questions as $question) { ?>
					
						<p><?=$i?>) <?= $question['ques_cont'] ?></p><?php
						$i++;
						
						// type texte
						if ($question['ques_type']=="texte"){?>
							<input type="text" name ="titre" size="17" /><br/>
						<?php }	
						
						// type checkbox					
						if ($question['ques_type']=="checkbox"){
									
							foreach ($reponses as $reponse) { 
								if ($reponse['ques_id']==$question['ques_id']){ ?>
									<label><input type="checkbox" name="repmultiple" value="<?= $reponse['rep_cont'] ?>"/><?= $reponse['rep_cont'] ?></label><?php
						
						} } } 
						
						// type radio
						if ($question['ques_type']=="radio" ){
							
							foreach ($reponses as $reponse) { 
								if ($reponse['ques_id']==$question['ques_id']){ ?>
									<label><input type="radio" name="repunique" value="<?= $reponse['rep_cont'] ?>"/><?= $reponse['rep_cont'] ?></label><?php						
						} } } 							
						
					?><br/><br/>				
				
				<?php } ?>			
			</form>
				
			</div>

			<?php require_once "includes/footer.php"; ?>
		</div>

		<?php require_once "includes/scripts.php"; ?>
	</body>

</html>