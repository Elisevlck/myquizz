<?php

// Se connecter à la base de données. Retourne un PDO objet

function getDb() {
	
	//On essaie de se connecter
    try{
		//$bdd=new PDO('mysql:host=localhost;dbname=phplogin','root','');
		//$conn = new PDO("mysql:host=localhost;dbname=myquizz;charset=utf8", 'root', '');
		return new PDO("mysql:host=localhost;dbname=myquizz;charset=utf8", 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        //On définit le mode d'erreur de PDO sur Exception
        //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo 'Connexion réussie';
    }                
    /*On capture les exceptions si une exception est lancée et on affiche les informations relatives à celle-ci*/
    catch(PDOException $e){
        echo "Erreur : " . $e->getMessage();
    }
				
	//On ferme la connexion
	$conn=null;
    //return $conn = new PDO("mysql:host=$servername;dbname=myquizz;charset=utf8", 'root', '');
    //array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
}

// Vérifier si un utilisateur est connecté
function isUserConnected() 
{
    return isset($_SESSION['login']);
}

function isAdmin() 
{
	if($_SESSION['role']=="administrateur")
	{
		
		return isset($_SESSION['role']);
	}
	
	
    
}

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

function chrono($chrono)
{
	
	while(time()<=$chrono);
	
	redirect('resultat.php');
	
	echo 'Le temps est fini';	
	
}

// Rediriger sur une url
function redirect($url) {
    header("Location: $url");
}

// Escape a value to prevent XSS attacks
function escape($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
	




}
?>