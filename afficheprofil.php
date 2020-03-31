<html>
<body>
<?php 
		
		require_once "includes/head.php"; 
	?>
	
	<div class="conteneurprofil">
	
	
		Statut : <?= $_SESSION['role']?>
		<br/><br/>Pseudo : <?= $_SESSION['login']?>
		<br/><br/>Avatar : 	<img src="membres/avatars/<?php echo $_SESSION['avatar']; ?>"  width="60"/>
	
		
		
	</div>


</body>
</html>