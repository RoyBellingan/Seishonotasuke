<?php


// $Id: test.php 2055 2009-11-06 23:09:58Z shodan $
//

define('ABSPATH', dirname(__FILE__).'/');


include_once (ABSPATH."/util/top_foot_inc.php");


top();


require_once (ABSPATH."util/funzioni.php" );

//require ("util/sphinxapi.php");
require_once (ABSPATH."util/mysqlutil.php");
include_once (ABSPATH."includes/caching.php");

include_once (ABSPATH."includes/versetto.php");
connetti();

$versetto=new trova_versetto();
$versetto->lang();
//dumpa($versetto,1);
$cache=new cache();

$cl = new SphinxClient ();
$cl->config_1_bibbia();
//dumpa($cl,1);
//db_info();
//////////////////////
// parse command line
//////////////////////


$data=<<<EOD
<br><br><br><br>
<div class="testo_18" style="position:static;margin:auto;width:80%;" >
EOD;
echo $data;
print ("<pre>\n");
$q=(empty($_POST['a'])) ? " " : $_POST['a'] ;

$q2=htmlspecialchars($q);

$o = (empty($_POST['o'])) ? 0 : $_POST['o'] ;  //Parti dopo quante (offsett)
$esempi=<<<EOD

cieli & terra -> AND
cieli | terra -> OR
cieli !terra -> not
cieli -terra -> not
"cieli e la terra" -> frase esatta
"cielo terra"~10  -> entro 10 parole
"Ed erano cherubini che spiegavano due ali verso l’alto"/3  -> trova almeno 3 parole
videro << tutto << buono   ->   rispetta l'ordine (sottointeso AND)
 @*[X] parola	 -> 	la parola si trova entro X dall'inizio del versetto
^Quindi mangiavano$	 -> Definisce che è all'inzio e alla fine del versetto
<br>
<form method="post" name="q"> 
<input name="a" type"text" value="$q2"> <input name="o" type"text" style="width:2em" value="$o"><input name="submit" type="submit" value="cerca"></form>
EOD;


echo $esempi;
print ("</pre>\n");



$i=$cl->index; //Indice


$v=0; //Verbositi, 0 solo query - 9 parecchie cose

$l=25;


$id=$cl->getquery($q,$o,$l);
$tot=$cl->res['total'];
$totfo=$cl->res['total_found'];
$tempo=$cl->res['time'];
print "Query <br> $q <br> Riportate $tot su $totfo in $tempo ms";

$versetto->class_p="versetto";
$versetto->class_coord="quale";
$versetto->class_cit="testo";
$versetto->echo_on=true;
$versetto->cache=$cache;

$versetto->form_verse_id($id,1);

//dumpa($GLOBALS);
//
// $Id: test.php 2055 2009-11-06 23:09:58Z shodan $
//
foot();
?>
