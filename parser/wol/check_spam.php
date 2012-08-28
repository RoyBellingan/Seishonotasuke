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
$h = new handlerer();
for ($libro = $libro_start; $libro <= 1; $libro++) {

	$pid = pcntl_fork();
	if ($pid == -1) {
		exo("could not fork");
		$this -> reason = "could not fork";
		return false;

	} else if ($pid) {

	} else {

		$h -> libro_id = $libro;

		$h -> libro = $libr[$lang][$h -> libro_id];

		echo "parse di $h->libro\n<br>";
		;
		$h -> leggi_testo("libri/it/$h->libro");

		$h -> parse_capitoli();

		$le_cap = sizeof($h -> chapter);

		$h -> chapter_count = $le_cap;

		echo " sono $le_cap capitoli\n<br>";

		for ($i = 1; $i <= 1; $i++) {
			echo "$h->libro - $i\n<br>";
			$h -> parse_versetti($i);

			$vr_cap = sizeof($h -> verse);
			$h -> versetti_num = $vr_cap;
			unset($h -> spam);
			$h -> proper_parse_link();

			for ($j = 1; $j <= $vr_cap; $j++) {

				$h -> parse_link($j);
			}

			//printa($h->versetto_has_link[1][0]);

			$h -> antispam();

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
	

}
