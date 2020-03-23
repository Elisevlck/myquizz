<?php
	include('includes/function.php');
	session_start();
	session_destroy();
	redirect('index.php'); //faut rediriger vers autre chose que l'index
?>