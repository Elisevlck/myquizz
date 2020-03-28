	<?php

		//validation du bouton 
		if(isset($_POST['inscription']))
		{
			//récupération variables (trim->sécuriser la variable)
			$reponse='coucou, ';
			
			foreach ($_POST['rep[]'] as $rep){
			$reponse=$reponse+"$rep";}
			
			redirect('index_theme.php');
		}
	?>