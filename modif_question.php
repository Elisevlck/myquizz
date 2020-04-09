<?php
	require_once "includes/function.php";
	session_start();

	$quesId = $_GET['idq'];
	$themeId = $_GET['idt'];
	
	$stmt = getDb()->prepare('select * from quiz where quiz_id=?');
	$stmt->execute(array($quizId));
	$quizs = $stmt->fetch();
	
	$stmt2 = getDb()->prepare('select * from question where quiz_id=?');
	$stmt2->execute(array($quizId));
	$themes = $stmt2->fetchAll();	
?>