<?php 
include_once("util/top_foot_inc.php");

include_once("includes/visite.php");
top();
connetti();

$visite=new visite();
$visite->db=$db;


$visite->get_param();

/*

Fai una finestrella piccina che richieda ID o Nome e Cognome che Ajax manda i dati della persona, se poi clicchi su un
cosino sotto si espande e diventa per inserire o persona oppure visita ulteriore o altra info, sennò e ricerca generica.

A fianco metti ... bo

 */



/*
if get();
	nuova_visita();
	controlla_visite()

else

form_inserisci_visita();
form_controlla_visite();

 */

foot();
?>