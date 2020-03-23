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
function isUserConnected() {
    return isset($_SESSION['login']);
}

// Rediriger sur une url
function redirect($url) {
    header("Location: $url");
}

// Escape a value to prevent XSS attacks
function escape($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
	
function motDePasse($longueur) 

{ // par défaut, on affiche un mot de passe de 5 caractères
    
	// chaine de caractères qui sera mis dans le désordre:
    $Chaine = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
    
	// on mélange la chaine avec la fonction str_shuffle()
    $Chaine = str_shuffle($Chaine);
    
	// ensuite on coupe à la longueur voulue avec la fonction substr()
    $Chaine = substr($Chaine,0,$longueur);
    
	// ensuite on retourne notre chaine aléatoire de "longueur" caractères
    return $Chaine;
}

// Appel à la fonction:
/*echo motDePasse(7); // retourne un mot de passe avec 5 caractères (lettres et numéros)
// petite précision: la chaine ne peut pas donner une chaine aléatoire de plus de 62 caractères, 
// si vous souhaitez une chaine plus longue, utilisez la concaténation (le point):
echo motDePasse(62).motDePasse(10); // retourne un mot de passe avec 72 caractères (lettres et numéros)
echo motDePasse(); // affiche un mot de passe de 5 caratères*/

}
?>