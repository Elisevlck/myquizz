<?php
	require_once "includes/function.php";
	session_start();
	// Récuperer tous les quiz
	$questions = getDb()->query('select * from question'); 
	$reponses = getDb()->query('select * from reponse');
?>

<!doctype html>

<html>

	<body>
	
	<?php 
		$pageTitle="Questions";
		require_once "includes/head.php"; 
	?>

	<body>
	
		<div class="container">			
		
			<?php require_once "includes/header.php"; ?>
		
			<form method="POST" action="resultat.php">
					
		
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
		
		<?php include "includes/footer.php";
		include "includes/scripts.php";?>
		
		</form>

	</body>

</html>