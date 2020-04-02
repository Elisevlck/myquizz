<?php
	require_once "includes/function.php";
	session_start();
?>
	
	
	<?php
		
		//$rep=$_POST['rep'];
		
		//validation du bouton 
		if(isset($_POST['inscription']))
		{		
			$score="";	
			
			foreach ($_POST as $fieled => $value){
				echo '<b>'.$fieled.'</b> : '.$value.'<br/>';
			}
			echo '<br/><br/>';
			
			/*for ($i=1;$i<=5;$i++)
			{			
				print 'La '.$i.'ème réponse est '.$_POST['rep['.$i.']'].'<br/>';
				print_r($rep);
				//$rep=$_POST['rep$i'];
				//$score=$score.' '.$rep; 
			}	
						
			//print 'Les pays sélectionnés sont :<ul>';
			
			//foreach($_POST['rep[]'] as $rep){
			//	echo '<li>'.$pay.'</li>';    }
    
			//print '</ul>';*/
		}
	?>