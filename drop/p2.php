<?php
//die ('Non si lanciano gli script a mozzo');
//include_once ("util/top_foot_inc.php");

define('ABSPATH', dirname(__FILE__).'/');


include_once(ABSPATH."util/top_foot_inc.php");
include_once(ABSPATH."includes/wordinfoclass.php");
include (ABSPATH."includes/caching.php");
include (ABSPATH."includes/versetto.php");

top();
connetti();



$winfo= new wordinfo();
$versetto=new trova_versetto();
$cache=new cache();
$cache->type=2;
$cl = new SphinxClient ();
$cl->config_1_bibbia();

$winfo->wordlang();//Acquisisco Parola di ricerca e lingua da usare
$winfo->queryword();//Faccio le query di rito

$winfo->selectalpha(64);//Recuper il solo array in ordine alfabetico, con 65 altre parole
$winfo->selectfeq(45);

$winfo->divafi(); //Scrive il DIV con i select posizionati carini, e le info della parola in questione
$winfo->jsselect(); // Servono per farlo funzionare meglio

$i=$cl->index; //Indice
$q=$winfo->word; //Query


$v=0; //Verbositi, 0 solo query - 9 parecchie cose
$o=0; //Parti dopo quante (offsett)
$l=50;


//printquery($cl,$q,$i,$v,$o,$l);
//$id=getquery($cl,$q,$i,$o,$l);
$id=$cl->getquery($q,$o,$l);
//dumpa($id,1);

//


//dumpa ($versetto,1);
echo "<div id=\"versetti\">";
$versetto->class_p="versetto";
$versetto->class_coord="quale";
$versetto->class_cit="testo";
$versetto->echo_on=true;
$versetto->cache=$cache;

$versetto->form_verse_id($id,1);
echo "</div>";
//$winfo->versetti(); //Scrive N versetti pertinenti alla parola

//$winfo->divappunti(); //Scrive Appunti pertinenti

//$winfo->divcommenti();

//$winfo->argomenti(); //Argomenti biblici in particolare (santi, culti vari ????)

//$winfo->divvisite_Argomenti(); //Argomenti trattati nelle visite ?



//dumpa($winfo,1); //Info di rito




foot();
$winfo->jsecho();
?>

