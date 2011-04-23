<?php


// $Id: test.php 2055 2009-11-06 23:09:58Z shodan $
//

include_once ("util/top_foot_inc.php");


top();


require_once ("util/funzioni.php" );

require_once ("util/sphinxql.php");
require_once ("util/mysqlutil.php");
require_once ("util/myhandler.php");
include_once ("includes/caching.php");

include_once ("includes/versetto.php");
connetti();


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


"I capifamiglia rendere conto Creatore di come"/5  -> trova almeno 5 parole
videro << tutto << buono   ->   rispetta l'ordine (sottointeso AND)
 @*[X] parola	 -> 	la parola si trova entro X dall'inizio del versetto
^Quindi mangiavano$	 -> Definisce che è all'inzio e alla fine del versetto

(questi 3 soltanto se si ricostruiscono gli indici estesi)
"anda*" -> inizia con
"*ssimo* -> finisce con
"*quar*" -> nel mezzo

<form method="post" name="q">
<input name="a" type"text" style="width:40em" value="$q2"> <input name="o" type"text" style="width:2em" value="$o"><input name="submit" type="submit" value="cerca"></form>
EOD;


echo $esempi;
print ("</pre>\n");

$spql="select * from ita_discorsi_rt where match ('$q')";

$colonne[]="titolo";
$colonne[]="oratore";
$colonne[]="testo";
$colonne[]="categorie";


$hs=handler('discorsi',$colonne);

//echo $spql;
echo "</div>";
$res=mysql_query($spql,$sdb);

	while ($id = mysql_fetch_row($res)){
		$retval=hs_select($hs,1,'=',$id[0]);
		//dumpa($retval);
		$txt=$retval[0][2];


/*
 * fronte?<br> -> fronte?</p><p>
 * fronte,<br> -> fronte.</p><p>
 * fronte<br> -> fronte<br>
 */
		$txt=str_replace(",<br>",", ",$txt);
//Eccezzione per adesso è la virgola

		$txt=preg_replace("/(\p{P})<br>/","\\1</p><p> ",$txt);
		//TODO cerca altre preg e documentale plz

		//Falcia i <br>, i paragrafi si i br per adesso no...
		$txt=str_replace("<br>"," ",$txt);


		echo "<h2>{$retval[0][0]}<h2><h3>{$retval[0][1]}</h3>";
echo "<div class=\"capitolo\"> <p>$txt</p>";

		echo "</div>";
	}













/*
 *


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
*/
//dumpa($GLOBALS);
//
// $Id: test.php 2055 2009-11-06 23:09:58Z shodan $
//
foot();
?>
