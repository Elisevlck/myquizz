<?php
	require_once "includes/function.php";
	session_start();

	$quizId = $_GET['id'];
	$stmt = getDb()->prepare('select * from quiz where quiz_id=?');
	$stmt->execute(array($quizId));
	$quiz = $stmt->fetch(); // Access first (and only) result line
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
            <div class="row">
                <div class="col-md-5 col-sm-7">
                    <!--<img class="img-responsive quizImage" src="images/<?= $quiz['quiz_image'] ?>" title="<?= $quiz['quiz_nom'] ?>" />-->
                </div>
                <div class="col-md-7 col-sm-5">
                    <h2><?= $quiz['quiz_intitule'] ?></h2>
                    <p><?= $quiz['nbquestions'] ?>, <?= $quiz['theme_nom'] ?></p>
                    <p><small><?= $quiz['quiz_datecreation'] ?></small></p>
                </h2>
            </div>
        </div>
    </div>
	
	<fieldset><legend>Les records des jeux olympiques</legend>

		<h1>Les records des jeux olympiques</h1>
			
		<?php			

					
			print 'Votre réponse est '.$_POST['titre'].'<br/>';
			'<br/>';
			
			print 'Les pays sélectionnés sont :<ul>';
			
				echo '<li>'.$pay.'</li>';
    }
    
			print '</ul>';
			
			print 'Votre temps sélectionné :' .$_POST['temps'].'<br/>';
		?>
		
				
	</fieldset>

    <?php require_once "includes/footer.php"; ?>
</div>

<?php require_once "includes/scripts.php"; ?>
</body>

</html>