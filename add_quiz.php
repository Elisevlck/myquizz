<?php
	require_once "includes/function.php";
	session_start();
	// Récuperer tous les quiz
	$quizs = getDb()->query('select * from quiz');
	$questions = getDb()->query('select * from question'); 
	$reponses = getDb()->query('select * from reponse');
?>

<?php //quand on met cette partie, erreur comme quoi erreur de code inattendu
	if (isUserConnected()) {
		
		if (isset($_POST['title'])) {
			// the movie form has been posted : retrieve movie parameters
			$title = escape($_POST['title']);
			$nbques = escape($_POST['shortDescription']);
			$theme = escape($_POST['longDescription']);
						
			// insert quiz into BD
			$stmt = getDb()->prepare('insert into quiz (quiz_nom, nbquestions, id_theme) values (?, ?, ?)');
			$stmt->execute(array($title, $nbques, $theme));
			redirect("index.php");
		}
?>



<!doctype html>
  
<html>

  <?php
    $pageTitle = "Ajout d'un quiz";
    include('includes/head.php');
    ?>

    <body>
      <div class="container">
        <?php include('includes/header.php'); ?>

          <h2 class="text-center">Ajout d'un quiz</h2>		  
		  
          <div class="well">
		  
            <form class="form-horizontal" role="form" enctype="multipart/form-data" action="add_quiz.php" method="post">
            <input type="hidden" name="id" value="<?= $quizId ?>">
			  
            <div class="form-group">			
                <label class="col-sm-4 control-label">Titre</label>                
				<div class="col-sm-6">					
					<input type="text" name="title" value="<?= $quizTitle ?>" class="form-control" placeholder="Entrez le titre du quiz" required autofocus>
                </div>	
            </div>
			
            <div class="form-group">
                <label class="col-sm-4 control-label">Nombre de questions</label>
                <div class="col-sm-6">					
					<textarea name="nbques" class="form-control" placeholder="Entrez le nombre de questions" required><?= $nbquestions ?></textarea>
                </div>
            </div>
			
            <div class="form-group">
                <label class="col-sm-4 control-label">Thème</label>
                <div class="col-sm-6">
					<textarea name="theme" class="form-control" rows="6" placeholder="Entrez le thème" required><?= $theme ?></textarea>
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-4">
					<button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-save"></span> Enregistrer</button>
                </div>
            </div>
            </form>
          </div>

          <?php include('includes/footer.php'); ?>
		  <?php include('includes/scripts.php');  ?>
      </div>      
    </body>
 </html>