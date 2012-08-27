<!DOCTYPE html>
<html  lang="it">
<head>
<title>Genesi 1 &mdash; BIBLIOTECA ONLINE Watchtower</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script>
	function stripslashes(str) {
		// +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
		// +   improved by: Ates Goral (http://magnetiq.com)
		// +      fixed by: Mick@el
		// +   improved by: marrtins    // +   bugfixed by: Onno Marsman
		// +   improved by: rezna
		// +   input by: Rick Waldron
		// +   reimplemented by: Brett Zamir (http://brett-zamir.me)
		// +   input by: Brant Messenger (http://www.brantmessenger.com/)    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
		// *     example 1: stripslashes('Kevin\'s code');
		// *     returns 1: "Kevin's code"
		// *     example 2: stripslashes('Kevin\\\'s code');
		// *     returns 2: "Kevin\'s code"
		return (str + '').replace(/\\(.?)/g, function(s, n1) {
			switch (n1) {
				case '\\':
					return '\\';
				case '0':
					return '\u0000';
				case '':
					return '';
				default:
					return n1;
			}
		});
	}
</script>
</head>
<body>
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
include_once ("handler.php");

$db = new_mysqli();


$h = new handlerer();

$h->libro=$libro="Genesi";


$h -> leggi_testo("libri/it/$libro");
//printa($h->book);
//die();

$h -> parse_capitoli();
//printa($h->chapter[1]);
//die();
$h->capitolo_id=1;
$h -> antispam();
printa($h->spam);
//die();

$h -> parse_versetti(1);
//printa($h -> verse[24]);
//die();

$h -> proper_parse_link();
$h -> db_clean();
foreach ($h -> verse as $key => $value) {
	$h -> parse_link($key);
	$h -> db_push($key);
}


//printa($h -> versetto_has_link);



die();
//$h->fetch_link();
die();
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