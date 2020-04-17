<?php

    // Se connecter à la base de données. Retourne un PDO objet

    function getDb() {
    	
    	//On essaie de se connecter
        try{
    		return new PDO("mysql:host=localhost;dbname=id13265287_bdd;charset=utf8", 'id13265287_myquizz', 'vYx<?8Jb2Z\P-2c_', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            //On définit le mode d'erreur de PDO sur Exception
            echo 'Connexion réussie';
        }                
       //On capture les exceptions si une exception est lancée et on affiche les informations relatives à celle-ci
        catch(PDOException $e){ 
            echo "Erreur : " . $e->getMessage();
        }
    				
    	//On ferme la connexion
    	$conn=null;
    }
    //pour qu'un utilisateur ne puisse accéder aux contenus sans être connecté, même en tappant l'url
    function verifConnexion() 
    {
        if (!isset($_SESSION['login']))
        {
            header ("Location: index.php");
            exit();
        }
    }
    
    //pour qu'un joueur ne puisse accéder aux contenus des admin, même en tappant l'url
    function verifAdmin() 
    {
        if ($_SESSION['role']!="administrateur")
        {
            header ("Location: index.php");
            exit();
        }
    }
    
    // Pour le chronomètre
    function microtime_float() 
    {
      list($usec, $sec) = explode(" ", microtime());
      return ((float)$usec + (float)$sec);
    }
    
    // Vérifier si un utilisateur est connecté
    function isUserConnected() 
    {
        return isset($_SESSION['login']);
    }
    
    // Vérifier si un utilisateur est un admin
    function isAdmin() 
    {
    	if($_SESSION['role']=="administrateur")
    	{
    		return isset($_SESSION['role']);
    	}
    }
    
    // Vérifier si un utilisateur est joueur
    function isJoueur() 
    {
    	if($_SESSION['role']=="joueur")
    	{	
    		return isset($_SESSION['role']);
    	}
    }
    
    // Génère un mot de passe aléatoire
    function randomnb($nb)
    {
    	$alphabet='azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN0123456789';
    	return(substr(str_shuffle(str_repeat($alphabet, $nb)),0,$nb));
    }
    
    // Escape a value to prevent XSS attacks
    function escape($value) 
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
    }
?>