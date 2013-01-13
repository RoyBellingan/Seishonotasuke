<?php

/** TODO
 * Carica nel db i versetti ora
 *
 *
 */
//die("non si lanciano a mozzo le cose...");

ini_set("display_errors", "1");
ERROR_REPORTING(E_ALL);
define("PATH", "../../");

include_once (PATH . "util/funkz.php");
include_once (PATH . "util/elenco_lib.php");
include_once (PATH . "includes/snoopy.php");
include_once (PATH . "util/mysqlutil.php");
include_once (PATH . "util/elenco_lib.php");
include_once ("handler.php");

$lang = "deutsch";
$lang_sigla = "de";
//$db = new_mysqli();
//$sql = "truncate table deutsch_riferimenti";
//qq($sql);

$libro_start = 1;

for ($libro = 1; $libro <= 1; $libro++) {

	/*
	 $pid = pcntl_fork();
	 if ($pid == -1) {
	 exo("could not fork");
	 $this -> reason = "could not fork";
	 return false;

	 } else if ($pid) {
	 //echo "father";
	 } else {
	 */
	$db = new_mysqli();
	$h = new handlerer();

	$h -> libro_id = $libro;

	$h -> libro = $libr[$lang][$h -> libro_id];

	//echo "parse di $h->libro\n<br>"; ;
	$h -> leggi_testo("libri/$lang_sigla/$h->libro");

	$h -> parse_capitoli_wol();
	//printa($h);

	$le_cap = sizeof($h -> chapter);

	$h -> chapter_count = $le_cap;

	//echo " sono $le_cap capitoli\n<br>";
	//die();
	spam:
	for ($i = 1; $i <= $le_cap; $i++) {

		/*
		 $lib = "Salmi";
		 //$lib="@";

		 if ($h->libro != "Salmi") {
		 //echo "qualcosa";
		 break 2;
		 } else {

		 $pid2 = pcntl_fork();
		 if ($pid2 == -1) {
		 exo("could not fork");
		 $this -> reason = "could not fork";
		 return false;

		 } else if ($pid2) {
		 echo "\n$h->libro fork $pid2 e cap = $i";
		 sleep(1);
		 //$i++;
		 continue;

		 } else {
		 //die();
		 unset($db);
		 $db = new_mysqli();

		 }

		 }
		 */
		loop:
		$h -> capitolo_id = $i;

		unset($h -> spam);
		unset($h -> versetto_has_ref);
		unset($h -> versetto_has_link);

		//echo "$h->libro - $i\n<br>";
		$h -> parse_versetti($i);
		//printa ($h->verse);
//		die();

		$vr_cap = sizeof($h -> verse);
		$h -> versetti_num = $vr_cap;

		$h -> proper_parse_link();

		for ($j = 1; $j <= $vr_cap; $j++) {

			//$h -> parse_link($j);
		}
		//printa($h -> versetto_has_link[15]);

		//$h -> load_spam();

		//printa($h -> versetto_has_link[15]);
		//printa($h -> spam[2]);
		//die();

		//$h -> link_merge();
		//printa($h -> versetto_has_ref[15]);
		//die();

		//$vr_cap

		for ($j = 1; $j <= $vr_cap; $j++) {

			//$h -> db_push($j);
		}

		//Rimuovi da in mezzo al testo i link, e fai una versione "nuda"
		for ($j = 1; $j <= $vr_cap; $j++) {
			$h->verse_id=$j;
			$h->strip_verse();
			//$h->load_verse();
			
		}
die();
		//printa($h->versetto_has_link[1][0]);
		//unset($h -> spam);
		//$le = sizeof($h -> spam);
		//printa($h -> spam);

		//die();

		//

		//
	}

	die();

}

//}
die();
