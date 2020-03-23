<?php



function redirect($url) 

{
    header("Location: $url");
}




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


?>