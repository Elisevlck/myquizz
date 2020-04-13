<?php
	require_once "includes/function.php";
	session_start();

	$quizId = $_GET['id'];
	$quesId = $_GET['num'];
	
	$stmt2 = getDb()->prepare('select * from question where ques_id=?');
	$stmt2->execute(array($quesId));
	$question = $stmt2->fetch();

	$recup_reponses=getDb()->prepare('select * from reponse where ques_id=?');
	$recup_reponses->execute(array($quesId));
	$reponses=$recup_reponses->fetchAll();
?>

<!doctype html>

<html>

	<?php 
		$pageTitle = "Modifier une question";
		require_once "includes/head.php"; 
	?>

	<body>	
		
		<?php include "includes/header.php"; ?>
		
		<div class="containeurGlobal">
		
			<div class="infoBase">
					
				<div id="infoBaseInt">
					
					<h5><strong><?=$question['ques_cont'] ?> </strong></h5>
					<em>Modifier la question</em>
					
				</div>
					
			</div>
			
			
		</div>
	</body>
</html>
		
		
		
		
		
		
		