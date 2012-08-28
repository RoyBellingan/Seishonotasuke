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

$libro_start = 1;

$libro_end = 1;

$capitolo_start=9;

$capitolo_end=9;

for ($libro = $libro_start; $libro <= $libro_end; $libro++) {
	//$pid = pcntl_fork();
/*
	if ($pid == -1) {
		exo("could not fork");
		$this -> reason = "could not fork";
		return false;

	} else if ($pid) {
		//Papà
		$posixProcessID = posix_getpid();
		//exo("fork fatto! pid $pid, io sono l PADRE $posixProcessID");
		//Diamo un leggero vantaggio al download iniziale...

		//sleep(2);
//die();
		//return true;

	} else {
		*/
		//Figghio

		$h = new handlerer();
		$h -> libro_id = $libro;
		$h -> libro = $libr[$lang][$h -> libro_id];
		echo "parse di $h->libro\n";
		$h -> leggi_testo("libri/it/$h->libro");


		$h -> parse_capitoli();

		$le_cap = sizeof($h -> chapter);

		$h -> chapter_count = $le_cap;

		//$h -> link_fullati();
		
		$h -> link_fullati=0;

		if ($h -> link_fullati == false) {
			//die();
			$end= $capitolo_end ? $capitolo_end : $h -> chapter_count;
			for ($i = $capitolo_start; $i <= 9; $i++) {
				echo "$h->libro - $i\n";
				$h -> parse_versetti($i);

				$vr_cap = sizeof($h -> verse);
				printa($h->verse);
				echo "abbiamo $vr_cap versetti";
				die();
				$h -> proper_parse_link();
				for ($j = 1; $j <= $vr_cap; $j++) {
				//	echo "famose il $j\n";
					
					$h -> parse_link($j);
				}
				//printa($h->versetto_has_link);
				//die();
				$h -> fetch_link();
			}
			die();
		} else {
			echo "$h->libro è fullato già!\n";
			die();
		}
	//}
}

//printa($h -> verse[24]);
//die();

//printa($h -> versetto_has_link);
//die();
die();
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