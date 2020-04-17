<?php 
	require_once "includes/function.php";		
	session_start();
	verifConnexion();
	
	$quizs = getDb()->query('select * from utilisateur'); 	
	
	$stmt=getDb()->prepare("select * from utilisateur where ut_nom=?");
	$stmt->execute(array($_SESSION['login']));
	$Id = $stmt->fetch(); 
	$utId = $Id['ut_id'];
	
	$recup_parties = getDb()->prepare('select * from partie where ut_id=? order by quiz_id');
	$recup_parties->execute(array($utId));
	$parties = $recup_parties->fetchAll();
	
	$stmt3 = getDb()->prepare('select * from partie where ut_id =? order by quiz_id');
	$stmt3->execute(array($utId));
	$quiz = $stmt3->fetch();
	
?>

<!DOCTYPE html>	

<html> 
    
    <?php 
    	$pageTitle = "Historique";
    	require_once "includes/head.php"; 
    ?> 

	<body>
	
        <?php require_once "includes/header.php";?>
        
        <div class="histo">
            
            <h2><strong>Mon historique :</strong></h2><br/><br/>
            
    		<?php 
    		$i=0;
    		
    		foreach($parties as $partie)
    		{		
    	    	$i++;	
    		
    			$recup_quiz = getDb()->prepare('select quiz_nom from quiz where quiz_id =? ');
    	        $recup_quiz->execute(array($partie['quiz_id']));
    	        $quizNom = $recup_quiz->fetch();  
    	         ?>
    				
    			<strong>Partie n°<?=$i?></strong><br/>
    			<br/>Quiz : <?=$quizNom['quiz_nom'];?>
    			<br/>Date : <?=$partie['part_date'];?>
    			<br/>Temps : <?php $time = $partie['part_temps'];
    			echo date('H:i:s', $partie['part_temps']); ?>
    			<br/>Taux de réussite : <?=$partie['part_score']*100 .' %';?>
    			<br/>Niveau : <?=$partie['quiz_niveau'];?>
    			<br/><br/>
    				
    			<?php 
    			
    		} ?>

        </div>
        <br/>
        <hr size="4" color ="black" width=75%/> <br/><br/>
        <div class="stat">
            
            <br/>
            <h2><strong>Mes statistiques :</strong></h2><br/><br/>
            

            <?php

    			$moyenne=0;
    			$i=0;
    			$j=0;
    			$nomquiz='';
    			
    			//pourcentage réussite totale (moyenne de tout pourcentage)*100
    			foreach($parties as $partie)
    			{		
        			$i++;
        			$moyenne=$moyenne+$partie['part_score'];
    			}
    			
    			echo "Vous avez joué : ".$i." partie(s) !<br/>";
    			
    			if($i !=0)
    		    {
        			$nbr = ($moyenne/$i)*100;
        			$reussite = round($nbr, 2);
        			$nonreussite = 100-$reussite;
        			echo "Votre taux de réussite général : ".$reussite ." %";
    		    }

    			$req=getDb()->prepare('select quiz_id,COUNT(DISTINCT (quiz_id)) from partie where ut_id=? group by quiz_id');
    			$req->execute(array($utId));
    			$nbquiz=$req->fetchAll();
    			echo'<br/><br/>';
    			foreach($nbquiz as $row)
    			{		
    			    $stmt4 = getDb()->prepare('select quiz_nom from quiz where quiz_id =? ');
    	            $stmt4->execute(array($row['quiz_id']));
    	            $quizNom = $stmt4->fetch();  
    	           
    				$nomquiz = $nomquiz.' <br/>- '.$quizNom['quiz_nom'];		
    		
    				$j++;
    			}
    			echo 'Vous avez joué à : '.$j.' quiz(s) différent(s) !<br/>';
    			
    			if($j != 0)
    			{
    			    echo 'Vous avez joué à : '.$nomquiz;
    			}
	    	?>
	    	<br/><br/>
	    	<div id="camembert"> 
	        
	            <img src='dhisto.php' style="margin-left:auto; margin-right:auto; position:relative;" />
            
            </div> 
		</div>
		
		
	</body>
		
	<?php
	include('includes/footer.php'); 
	include('includes/scripts.php'); 
	?>	

</html>