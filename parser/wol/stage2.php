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

$lang="italiano";

$db = new_mysqli();
$h = new handlerer();


$h->libro_id=8;



$h -> libro = $libro = $libr[$lang][$h->libro_id];

echo "parse di $libro\n";


$h -> leggi_testo("libri/it/$libro");
//printa($h->book);
//die();

$h -> parse_capitoli();
//printa($h->chapter[1]);
//die();
//$h -> antispam();
//printa($h->spam);
//die();

$le_cap = sizeof($h -> chapter);

for ($i = 1; $i <= $le_cap; $i++) {
	echo "$libro - $i\n";
	$h -> parse_versetti($i);

	$vr_cap = sizeof($h -> verse);

	for ($j = 1; $j <= $vr_cap; $j++) {
		$h -> proper_parse_link();
		$h -> parse_link($j);
		
	}
	$h -> fetch_link();
}
die();
//printa($h -> verse[24]);
//die();

//printa($h -> versetto_has_link);
//die();
$h -> fetch_link();

//foreach ($h ->versetto_has_link as $key => $value) {

//foreach ($h -> verse as $key => $value) {

//}
$h -> db_push(1);
$h -> db_push(2);
$h -> db_push(3);
$h -> db_push(4);
$h -> db_push(5);
//}
die();
die();

$h -> get_link($file_link);
$h -> proper_link();

$h -> versetto_add_note();

$h -> versetto_add_margin();
?>