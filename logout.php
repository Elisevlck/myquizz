<?php
	include('includes/function.php');
	session_start();
	session_destroy();
	header("Location:index.php");
?>

