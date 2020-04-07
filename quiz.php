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
	
	$stmt4 = getDb()->prepare('select * from theme where theme_id =?');
	$stmt4->execute(array($_GET['id']));
	$themes = $stmt4->fetch(); // Access first (and only) result line	
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
				
				<h2><strong><?= $quizs['quiz_nom'] ?></strong></h2>
				<p><em>Nombre de questions : <?= $quizs['nbquestions'] ?> questions</em></p>
				<p><em>Thème : <?= $themes['theme_nom'] ?></em></p>
				<p><em><small>Date de création : <?= $quizs['datecreation'] ?></small></em></p>
				<hr/>
				
				<h2> <strong>Répondre aux questions suivantes : </strong></h2><br/>
				
				<form action="resultat.php?id=<?= $quizs['quiz_id'] ?>" Method="POST">
				
					<?php $i=1;?>
								
					<?php foreach ($questions as $question) { ?>
					
						<em><?=$i?>) <?= $question['ques_cont'] ?></em><br/><?php
						
						
						
						// type texte
						if ($question['ques_type']=="texte"){?>
							<input type="text" name='<?= $question["ques_id"]?>' size="17" /><br/>
						<?php }	
						
						// type radio					
						if ($question['ques_type']=="radio"){
									
							foreach ($reponses as $reponse) { 
								if ($reponse['ques_id']==$question['ques_id']){ ?>
									<label><input type="radio" name='<?= $question["ques_id"]?>' value="<?= $reponse['rep_cont'] ?>"/><?= $reponse['rep_cont'] ?></label><?php
						} } }
						
						// type checkbox					
						/*if ($question['ques_type']=="multiple"){
									
							foreach ($reponses as $reponse) { 
								if ($reponse['ques_id']==$question['ques_id']){ ?>
									<label><input type="checkbox" name="[rep]['.<?=$question["ques_id"]?>.']" value="<?= $reponse['rep_cont'] ?>"/><?= $reponse['rep_cont'] ?></label><?php
						
						} } } 	*/											
						$i++;						
						
					?><br/><br/>	
                			
				
				<?php 		  } ?>			
				
				<button type="submit" name="validation" class="boutonC"><span class="glyphicon glyphicon-log-in"></span> Valider</button>
				
			
			</form>
				
			</div>

			<?php require_once "includes/footer.php"; ?>
		</div>

		<?php require_once "includes/scripts.php"; ?>
	</body>

</html>