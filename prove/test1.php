<?php
//die ('Non si lanciano gli script a mozzo');
//include_once ("util/top_foot_inc.php");

include_once("util/top_foot_inc.php");

include ("includes/caching.php");
include ("includes/versetto.php");
top();

echo "Pagina di prova<br>";

$cl=initsphinx();
$versetto=new trova_versetto();
$cache=new cache();

$i="index_italiano_p"; //Indice
$q=" disse ! loro"; //Query


$v=0; //Verbositi, 0 solo query - 9 parecchie cose
$o=0; //Parti dopo quante (offsett)
$l=10;


//printquery($cl,$q,$i,$v,$o,$l);
//$id=getquery($cl,$q,$i,$o,$l);
$id=$cl->getquery($q,$i,$o,$l);
//dumpa($id,1);




//dumpa ($versetto,1);

$versetto->class_p="versetto";
$versetto->class_coord="quale";
$versetto->class_cit="testo";
$versetto->echo_on=true;
$versetto->cache=$cache;

$versetto->form_verse_id($id,1);


//dumpa ($versetto,1);
/*
echo "$versetto->libro  $versetto->capitolo:$versetto->versetto <br> $versetto->testo";

$versetto->fetch_versetto_id($id[1],1);
echo "$versetto->libro  $versetto->capitolo:$versetto->versetto <br> $versetto->testo";


$versetto->fetch_versetto_id($id[3],1);
echo "$versetto->libro  $versetto->capitolo:$versetto->versetto <br> $versetto->testo";

*/
//getquery($cl,$q,$i,$v,$o,)


/*
 * E adesso fai quello che crea un array di query di risposta e le fetcha mettendole dentro un div carino
 * in teoria basta fare la chiamata con $v=1... e mandare il parametro $div per il nome del div è un $id opzionale che 
 * mette l'id numerico o altri goodies
 */



foot();
