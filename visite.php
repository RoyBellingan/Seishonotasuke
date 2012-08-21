<?php
//TODO fix bugzilla e metti tabella con codice pubblicazione e che pubblicazione è, a volte viene comodo...
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
/*
id_persona
nome	Claudia
cognome
etÃ 	82
note_brevi	Originaria dell'Istria, sugli 82 anni, parecchio vivace, rivisitala fra una settimana...



Lei sostiene di non essere interessata, io non ci credo, mi ha fatto entrare nel platio antistante la casa per lamentantarsi della cappa su Roma
via	Via del Colle
numero	30
territorio	98
lat	41.788129
lon	12.676312
lingua	Italiana
note_persona
data
con
argomento
note_visita
materiale
ins	Invia richiesta
 */
?>