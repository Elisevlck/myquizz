<?php
	session_start();
	require_once "includes/function.php";
	verifConnexion();
	
	$recup_quizs = getDb()->prepare('select * from quiz');
	$recup_quizs->execute(array());
	$quizs = $recup_quizs->fetchAll();
?>

<html>
    
    <?php 
    	$pageTitle = "Tous les quiz";
    	require_once "includes/head.php"; 
    ?> 
    
	<body>
	    
		<?php include "includes/header.php";?>
		
		<div class="containeurGlobal">
		    
		    <div class="infoBase">
		        
		        <div id="infoBaseInt">
		            
		            <h3><strong> Tous les quiz accessibles sur le site : </strong></h3>
		            
		        </div>
		        
		    </div>
		    
		    <?php foreach ($quizs as $quiz){ ?>
		     
                <div class="element">
                    
                    <div id="elementInt">
                        
                       
                        <h3><strong><?=$quiz['quiz_nom']?></strong></h3>
                        <em><?=$quiz['nbquestions']?> questions</em><br/>
                        <em><small>Crée par <?=$quiz['createur']?> le <?=$quiz['datecreation']?></small></em>
                        
                        <?php 
                        if(isAdmin()) {?>
                            <a class='option' href="index_question.php?id=<?= $quiz['quiz_id'] ?>">Modifier</a><br/><br/> 
                        <?php } ?>
                        
    					Affichage d'un trait :
    					<a class="option" href="quiz.php?id=<?= $quiz['quiz_id'] ?>&tId=<?=$themeId?>&niv=facile">Facile</a>   
    					<a class="option" href="quiz.php?id=<?= $quiz['quiz_id'] ?>&tId=<?=$themeId?>&niv=moyen">Moyen</a>      
    					<a class="option" href="quiz.php?id=<?= $quiz['quiz_id'] ?>&tId=<?=$themeId?>&niv=difficile">Difficile</a>
    					<br/><br/>
    					Affichage question par question :
    					<a class="option" href="quiz1par1_init.php?id=<?= $quiz['quiz_id'] ?>&niv=facile">Facile</a>      
    					<a class="option" href="quiz1par1_init.php?id=<?= $quiz['quiz_id'] ?>&niv=moyen">Moyen</a>      
    					<a class="option" href="quiz1par1_init.php?id=<?= $quiz['quiz_id'] ?>&niv=difficile">Difficile</a>
    					<br/><br/>
    						
                        
                    </div>
                    
                </div>
            
		     <?php } ?>
		     
         </div>
    </body>
    
    <?php
        include "includes/footer.php";
        include "includes/scripts.php";
    ?>
    
</html>
	