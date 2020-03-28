	<?php
	require_once "includes/function.php";
	session_start();
?>
	
	
	<?php

		//validation du bouton 
		if(isset($_POST['inscription']))
		{		
			$score="";			
			for ($i=1;$i<=5;$i++)
			{			
				print 'La '.$i.'ème réponse est '.$_POST['rep$i'].'<br/>';
				//$rep=$_POST['rep$i'];
				//$score=$score.' '.$rep; 
			}	
		
		//print 'Votre reponse : '.$score.'<br/>';
			
			//redirect('index_theme.php');
		}
	?>