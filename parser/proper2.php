<?php

die('non si lanciano gli script a mozzo');

/*
 * Rimuove la roba che non serve nei capitoli, e lascia solo il testo....
 */

$libr["Español"][1]="Génesis";
$libr["Español"][]="Éxodo";
$libr["Español"][]="Levítico";
$libr["Español"][]="Números";
$libr["Español"][]="Deuteronomio";
$libr["Español"][]="Josué";
$libr["Español"][]="Jueces";
$libr["Español"][]="Rut";
$libr["Español"][]="1 Samuel";
$libr["Español"][]="2 Samuel";
$libr["Español"][]="1 Reyes";
$libr["Español"][]="2 Reyes";
$libr["Español"][]="1 Crónicas";
$libr["Español"][]="2 Crónicas";
$libr["Español"][]="Esdras";
$libr["Español"][]="Nehemías";
$libr["Español"][]="Ester";
$libr["Español"][]="Job";
$libr["Español"][]="Salmos";
$libr["Español"][]="Proverbios";
$libr["Español"][]="Eclesiastés";
$libr["Español"][]="El Cantar de los Cantares";
$libr["Español"][]="Isaías";
$libr["Español"][]="Jeremías";
$libr["Español"][]="Lamentaciones";
$libr["Español"][]="Ezequiel";
$libr["Español"][]="Daniel";
$libr["Español"][]="Oseas";
$libr["Español"][]="Joel";
$libr["Español"][]="Amós";
$libr["Español"][]="Abdías";
$libr["Español"][]="Jonás";
$libr["Español"][]="Miqueas";
$libr["Español"][]="Nahúm";
$libr["Español"][]="Habacuc";
$libr["Español"][]="Sofonías";
$libr["Español"][]="Ageo";
$libr["Español"][]="Zacarías";
$libr["Español"][]="Malaquías";
$libr["Español"][]="Mateo";
$libr["Español"][]="Marcos";
$libr["Español"][]="Lucas";
$libr["Español"][]="Juan";
$libr["Español"][]="Hechos";
$libr["Español"][]="Romanos";
$libr["Español"][]="1 Corintios";
$libr["Español"][]="2 Corintios";
$libr["Español"][]="Gálatas";
$libr["Español"][]="Efesios";
$libr["Español"][]="Filipenses";
$libr["Español"][]="Colosenses";
$libr["Español"][]="1 Tesalonicenses";
$libr["Español"][]="2 Tesalonicenses";
$libr["Español"][]="1 Timoteo";
$libr["Español"][]="2 Timoteo";
$libr["Español"][]="Tito";
$libr["Español"][]="Filemón";
$libr["Español"][]="Hebreos";
$libr["Español"][]="Santiago";
$libr["Español"][]="1 Pedro";
$libr["Español"][]="2 Pedro";
$libr["Español"][]="1 Juan";
$libr["Español"][]="2 Juan";
$libr["Español"][]="3 Juan";
$libr["Español"][]="Judas";
$libr["Español"][]="Revelación";


$lang="s";


define('ABSPATH', dirname(__FILE__).'/');


include_once (ABSPATH."/util/top_foot_inc.php");

top();
$error=false;


for ($i=1;$i<67;$i++)
{

	$lib=$libr["Español"][$i];
	$j=$i+1;
	$lib2=$libr["Español"][$j];
	$path="libri/$lang/".$lib;
	$path2="libri/$lang/".$lib2;
	rename ($path2,$path);
	
}



foot();