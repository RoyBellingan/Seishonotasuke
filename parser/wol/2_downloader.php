<?php

die("non si lanciano a mozzo le cose...");

ini_set("display_errors", "1");
ERROR_REPORTING(E_ALL);

define('ABSPATH', dirname(__FILE__) . '/');

include_once ("../../util/funkz.php");
include_once ("../../util/elenco_lib.php");

$error = false;

$counter = 0;

//Percorso Base:

// http://	wol.jw.org	/it	/wol	/b	/r6		/lp-i	/20		/23
// vabbè	sito		lingua	serve	bo	versione?	cosa	sottopagina	sottopagina2
$lingua = "Deutsch";
//Lingua che ci si appresta a scaricare
$lang = "de";
//Abbreviazione

echo "mi apresto a Scaricare la bibbia in $lingua";
//printa($libr["$lingua"]);

//echo(mkdir("libri/$lang") ? "cartella creata" : false("Warn nessuna cartella verifca che non esista gia !!!!"));

$counter = 1001060003;
$init=2;
$end=66;


for ($jj = $init; $jj < $end+1; $jj++) {
	$bite = 0;
	$libro = "libri/$lang/" . $libr["$lingua"][$jj];
	$libro_a = $libram[$jj];
	echo "<h2> Now Parsing $libro in $lingua</h2>";

	$fp = fopen("$libro", 'w');
	//echo $fp;
	$error = false;

	$counter++;
	$url = "http://wol.jw.org/$lang/wol/d/r10/lp-x/$counter";
	echo $url;
	exb();

	//TODO metti un controllo se non riesce ad aprire lo stream...
	$cod = file_get_contents($url);

	//echo $cod;
	exb();
	//die();

	$len = fwrite($fp, $cod);
	$bite += $len;

	echo "\n<br>wrote $bite bytes to $libro.testo-raw<br><br>";
	exb();

}

//foot();
?>