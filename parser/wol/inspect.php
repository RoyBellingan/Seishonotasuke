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

$lang = "italiano";
$db = new_mysqli();
$sql = "truncate table riferimenti";
qq($sql);

$libro_start = 1;

for ($libro = 2; $libro <= 2; $libro++) {

	$db = new_mysqli();
	$h = new handlerer();

	$h -> libro_id = $libro;

	$h -> libro = $libr[$lang][$h -> libro_id];

	//echo "parse di $h->libro\n<br>"; ;
	$h -> leggi_testo("libri/it/$h->libro");

	$h -> parse_capitoli();

	$le_cap = sizeof($h -> chapter);

	$h -> chapter_count = $le_cap;

	//echo " sono $le_cap capitoli\n<br>";

	for ($i = 1; $i <= 3; $i++) {

		
		$h -> capitolo_id = $i;
		unset($h -> spam);
		unset($h -> versetto_has_ref);
		unset($h -> versetto_has_link);

		//echo "$h->libro - $i\n<br>";
		$h -> parse_versetti($i);
		//printa ($h->verse);

		$vr_cap = sizeof($h -> verse);
		$h -> versetti_num = $vr_cap;

		$h -> proper_parse_link();

		for ($j = 1; $j <= $vr_cap; $j++) {

			$h -> parse_link($j);
		}
		printa($h -> versetto_has_link[15]);
		
		

		//$h -> load_spam();

		//printa($h -> versetto_has_link[15]);
		//printa($h -> spam[2]);
		//die();

		//$h -> link_merge();
		//printa($h -> versetto_has_ref[15]);
		//die();

		//$vr_cap
/*
		for ($j = 1; $j <= $vr_cap; $j++) {

			$h -> db_push($j);
		}
*/
		//printa($h->versetto_has_link[1][0]);
		//unset($h -> spam);
		//$le = sizeof($h -> spam);
		//printa($h -> spam);

		//die();

		//

		//die();

		//
	}

	die();

}
