<?php
	include('includes/function.php');
	session_start();
	session_destroy();
	redirect('page1.php'); //faut rediriger vers autre chose que l'index
?>