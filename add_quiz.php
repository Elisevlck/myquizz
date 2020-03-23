<?php
require_once "includes/function.php";
session_start();

if (isUserConnected()) {
    
    if (isset($_POST['title'])) {
        // the movie form has been posted : retrieve movie parameters
        $title = escape($_POST['title']);
        $shortDescription = escape($_POST['shortDescription']);
        $longDescription = escape($_POST['longDescription']);
        $director = escape($_POST['director']);
        $year = escape($_POST['year']);
        
        $tmpFile = $_FILES['image']['tmp_name'];
        if (is_uploaded_file($tmpFile)) {
            // upload movie image
            $image = basename($_FILES['image']['name']);
            $uploadedFile = "images/$image";
            move_uploaded_file($_FILES['image']['tmp_name'], $uploadedFile);
        }
        
        // insert movie into BD
        $stmt = getDb()->prepare('insert into movie
        (mov_title, mov_description_short, mov_description_long, mov_director, mov_year, mov_image)
        values (?, ?, ?, ?, ?, ?)');
        $stmt->execute(array($title, $shortDescription, $longDescription,
        $director, $year, $image));
        redirect("index.php");
    }
    ?>

  <!doctype html>
  <html>

  <?php
    $pageTitle = "Ajout d'un quiz";
    require_once "includes/head.php";
    ?>

    <body>
      <div class="container">
        <?php require_once "includes/header.php"; ?>

          <h2 class="text-center">Ajout d'un quiz</h2>
          <div class="well">
            <form class="form-horizontal" role="form" enctype="multipart/form-data" action="quizz_add.php" method="post">
              <input type="hidden" name="id" value="<?= $movieId ?>">
			  
              <div class="form-group">
                <label class="col-sm-4 control-label">Titre</label>
                <div class="col-sm-6">
                  <input type="text" name="title" value="<?= $movieTitle ?>" class="form-control" placeholder="Entrez le titre du quiz" required autofocus>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Description courte</label>
                <div class="col-sm-6">
                  <textarea name="shortDescription" class="form-control" placeholder="Entrez sa description courte" required>
                    <?= $movieShortDescription ?>
                  </textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Description longue</label>
                <div class="col-sm-6">
                  <textarea name="longDescription" class="form-control" rows="6" placeholder="Entrez sa description longue" required>
                    <?= $movieLongDescription ?>
                  </textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Réalisateur</label>
                <div class="col-sm-6">
                  <input type="text" name="director" value="<?= $movieDirector ?>" class="form-control" placeholder="Entrez son réalisateur" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Année de sortie</label>
                <div class="col-sm-4">
                  <input type="number" name="year" value="<?= $movieYear ?>" class="form-control" placeholder="Entrez son année de sortie" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Image</label>
                <div class="col-sm-4">
                  <input type="file" name="image" />
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-4 col-sm-offset-4">
                  <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-save"></span> Enregistrer</button>
                </div>
              </div>
            </form>
          </div>

          <?php require_once "includes/footer.php"; ?>
      </div>

      <?php require_once "includes/scripts.php"; ?>
    </body>

  </html>

  <?php } else { ?>
    <html>

    <body>
      <img src="https://sd.keepcalm-o-matic.co.uk/i/don-t-mess-with-me-bro.png" />
    </body>

    </html>
<?php } ?>