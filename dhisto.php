<?php
require_once ('includes/function.php');
session_start();
verifConnexion();
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_pie.php');
require_once ('jpgraph/jpgraph_pie3d.php');

    $stmt=getDb()->prepare("select * from utilisateur where ut_nom=?");
	$stmt->execute(array($_SESSION['login']));
	$Id = $stmt->fetch(); 
	$utId = $Id['ut_id'];
	
	$stmt2 = getDb()->prepare('select * from partie where ut_id=? order by quiz_id');
	$stmt2->execute(array($utId));
	$parties = $stmt2->fetchAll();
	$moyenne=0;
	$i=0;
	
    foreach($parties as $partie)
	{	
	    $i++;	
		$moyenne=$moyenne+$partie['part_score'];
	}
	$reussite = round($moyenne, 2);
	$reussite = ($moyenne/$i)*100;
	$nonreussite = 100-$reussite;


//tableau légende
$tableau=['Quiz réussi','Quiz raté'];

//donnée du diagramme
$donnees = array($reussite,$nonreussite);

//taille
$largeur = 400;
$hauteur = 350;

// Initialisation du graphique
$graphe = new PieGraph($largeur, $hauteur);

// Creation du camembert avec la légende
$camembert = new PiePlot3D($donnees);
$camembert->SetLegends($tableau);
$camembert->SetCenter(0.4);
$camembert->SetSliceColors(array('#BBFF33', '#FF6100'));

// Ajout du camembert au graphique
$graphe->add($camembert);

// Ajout du titre du graphique
$graphe->title->set("Taux de réussite du joueur");

// Affichage du graphique
$graphe->stroke();

?>


