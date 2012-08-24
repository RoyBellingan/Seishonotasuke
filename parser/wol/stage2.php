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

//die("non si lanciano a mozzo le cose...");

ini_set("display_errors", "1");
ERROR_REPORTING(E_ALL);
define("PATH", "../../");

include_once (PATH . "util/funkz.php");
include_once (PATH . "util/elenco_lib.php");
include_once (PATH . "includes/snoopy.php");
include_once (PATH . "util/mysqlutil.php");

$dbi = new_mysqli();
$h = new handlerer();

$h -> leggi_testo("libri/it/Genesi");
//printa($h->book);
//die();

$h -> parse_capitoli();
//printa($h->chapter[1]);
//die();

$h -> parse_versetti(1);
//printa($h -> verse[24]);
//die();

$h -> proper_parse_link();
foreach ($h -> verse as $key => $value) {
	$h -> parse_link(1);
}

//printa($h -> versetto_has_link);

//foreach ($h ->versetto_has_link as $key => $value) {
$h -> antispam();

$h -> db_push(1);
//}
die();
die();

$h -> get_link($file_link);
$h -> proper_link();

$h -> versetto_add_note();

$h -> versetto_add_margin();

class handlerer {

	/**Stuff init and usual related things...
	 *
	 */
	function handlerer() {
		mb_internal_encoding("UTF-8");
		mb_regex_encoding("UTF-8");
		$this -> snoopy = new Snoopy;
		$this -> snoopy -> accept = "application/json, text/javascript, */*; q=0.01";
		$this -> snoopy -> proxy_host = "localhost";
		$this -> snoopy -> proxy_port = "79";

	}

	/**Legge un libro scaricato già
	 *
	 */
	function leggi_testo($file) {
		$this -> book = file_get_contents($file);

	}

	/**Crea un array con i capitoli partendo dal testo letto
	 * I capitoli sono delineati da <capitolo_N{1,3}> </capitolo_N{1,3}>
	 *
	 */
	function parse_capitoli() {
		$flag = true;
		$i = 1;
		$off = 0;
		while ($flag) {

			$pos[$i][0] = mb_strpos($this -> book, "<capitolo_$i>", $off);
			//echo "analizzo < capitolo_$i > che si trova a {$pos[$i][0]}<br>";
			if ($pos[$i][0] !== false) {//Se trovo l'inizio
				//Allora cerca la fine
				$pos[$i][1] = mb_strpos($this -> book, "</capitolo_$i>", $pos[$i][0]);

				$this -> chapter[$i] = mb_substr($this -> book, $pos[$i][0], $pos[$i][1] - $pos[$i][0]);
				$off = $pos[$i][1];
				$i++;

			} else {
				//Altrimenti togli questo record e amen
				unset($pos[$i]);
				$flag = false;
				break;
			}

		}
		//$i--;
		//echo "trovati $i capitoli";

	}

	/**Crea un array coi versetti partendo da un capitolo
	 *I versetti sono un pò più scomodi da definire ma sempre facili
	 *
	 * Inizia dopo un
	 * 		<span id='vN{1,3}' class='dv'>
	 * seguito da un link e poi il </span>
	 *
	 * Può terminare
	 * 	Se inizia un altro versetto con uno </span>
	 * 	Se finisce il paragrafo con uno </p>
	 *	Se finiscono invece trovo un </div>
	 */
	function parse_versetti($capitolo) {
		$flag = true;
		$i = 1;
		$chapter = $this -> chapter[$capitolo];
		//printa($chapter);
		$off = strpos($chapter, "id=\"content\"");

		while ($flag) {

			$pos[$i][0] = mb_strpos($chapter, "</span>", $off) + 7;

			if ($pos[$i][0] < $off) {
				$flag = false;
				break;
			}
			//echo "<br> Leggo da $off e lo trovo a {$pos[$i][0]}";
			if ($pos[$i][0] !== false) {

				$ps = mb_strpos($chapter, "<span", $pos[$i][0] + 1);
				//finisce per primo comunque...
				$pp = mb_strpos($chapter, "</p>", $pos[$i][0] + 1);
				//$pd = mb_strpos($chapter, "</div>", $pos[$i][0] + 1);
				//echo "analizzo il versetto $i che si trova a {$pos[$i][0]} finisce a $ps o $pp ?<br>";
				//Controllo che uno dei due esista...
				if ($ps !== false || $pp !== false) {

					//E prendo il minore
					if ($ps !== false && $ps < $pp) {
						$pos[$i][1] = $ps;
					} else {
						$pos[$i][1] = $pp;

					}

					$off = $pos[$i][1];
					//echo "<br> finisce a " . $off;
					$this -> verse[$i] = mb_substr($chapter, $pos[$i][0], $pos[$i][1] - $pos[$i][0]);
					//printa($this -> verse[$i]);

					$i++;

				} else {
					$flag = false;
					break;
				}
			} else {
				$flag = false;
				break;
			}
			//echo"<hr>";
			//die();
		}
		//$i--;
		//echo "trovati $i versetti";
	}

	/**Pulisce alcune cose prima di analizzare i link
	 */
	function proper_parse_link() {
		unset($this -> margin_list);
		$this -> margin_list = array();
		$this -> margin_counter = 0;

		unset($this -> note_list);
		$this -> note_list = array();
		$this -> note_counter = 0;

	}

	/**Estrae i link, tutti da un versetto_n dell'array
	 * Crea una lista degli url dei link e un array con le posizioni
	 */
	function parse_link($versetto_id) {

		//Facciamo per prima le note a margine, nessun motivo specifico...
		$flag = true;
		$i = 0;

		$pos[0] = 0;
		$gl_m = array();

		$verse = $this -> verse[$versetto_id];
		//$pos[1]=0;
		$verse = preg_replace('/\s\s+/', ' ', $verse);
		$verse_link = str_replace("href='/it", "href='http://wol.jw.org", $verse);
		$verse = trim($this -> snoopy -> _striptext($verse));

		//echo "lavoriamo su $verse <br>";

		preg_match_all("/(https?|ftp|telnet):\/\/((?:[a-z0-9@:.-]|%[0-9A-F]{2}){3,})(?::(\d+))?((?:\/(?:[a-z0-9-._~!$&()*+,;=:@]|%[0-9A-F]{2})*)*)(?:\?((?:[a-z0-9-._~!$&'()*+,;=:\/?@]|%[0-9A-F]{2})*))?(?:#((?:[a-z0-9-._~!$&'()*+,;=:\/?@]|%[0-9A-F]{2})*))?/i", $verse_link, $aar, PREG_SET_ORDER);

		//printa($aar);

		$aar2 = mb_strpos_all($verse, "*");
		//printa($aar2);

		$aar3 = mb_strpos_all($verse, "+");
		//printa($aar3);

		$rip = array_flip_combine_plus($aar2, $aar3);
		//printa($rip);

		$lli = $this -> link_marry($rip, $aar);
		//printa($lli);
		//die();

		while ($flag == true) {

			@$pos[$i] = mb_strpos($verse, "+", $pos[abs($i - 1)] + 1);

			if ($pos[$i] == false) {
				$flag = false;
				unset($pos[$i]);
				break;
			} else {
				//$this -> margin_list[$this -> margin_counter][0] = $versetto_id;
				$this -> margin_list[$this -> margin_counter][1] = substr_count(mb_substr($verse, 0, $pos[$i]), ' ');
				$this -> margin_counter++;
				//echo "\n<br>$ccs spazi";
				//$gl_m[];
			}
			//	printa($pos);
			if ($i > 160) {
				break;
			}
			$i++;

		}
		//printa($this -> margin_list);

		$i = 0;
		unset($pos);
		$pos[0] = 0;
		$flag = true;

		while ($flag == true) {

			@$pos[$i] = mb_strpos($verse, "*", $pos[abs($i - 1)] + 1);
			//echo "<br> giro $i, $pos[$i]";
			if ($pos[$i] == false) {
				$flag = false;
				unset($pos[$i]);
				break;
			} else {
				//echo "<br> addo ";
				//$this -> note_list[$this -> note_counter][0] = $versetto_id;
				$this -> note_list[$this -> note_counter][1] = substr_count(mb_substr($verse, 0, $pos[$i]), ' ');
				$this -> note_counter++;
				//echo "\n<br>$ccs spazi";
				//$gl_m[];
			}
			//	printa($pos);
			if ($i > 160) {
				break;
			}
			$i++;

		}

		//printa($this -> note_list);
		if ($lli) {
			foreach ($lli as $key => $value) {
				//Se è una NOTA A MARGINE
				if ($value[1] == 1) {
					$lli[$key][4] = $this -> note_list[$lli[$key][2]][1];

					//Se è un RIFERIMENTO a Margine
				} elseif ($value[1] == 2) {
					$lli[$key][4] = $this -> margin_list[$lli[$key][2]][1];
				}
			}
			$this -> versetto_has_link[$versetto_id] = $lli;
		} else {
			$this -> versetto_has_link[$versetto_id] = false;
		}

		//printa(	$this->versetto_has_link[$versetto_id]);
		//die ();
	}

	/** Gruppa i link
	 */
	function link_marry($a1, $a2) {
		if (isset($a1[0])) {
			foreach ($a1 as $key => $value) {
				@$a1[$key][3] = $a2[$key];
			}
			return $a1;
		} else {
			return false;
		}

	}

	function mb_strpos_all() {

	}

	/**Scarica il testo di quel link dal wol per questa lingua
	 *
	 */
	function get_link($link) {

	}

	function db_push($verse_id) {
		foreach ($this->versetto_has_link[$verse_id] as $key => $value) {
			echo "<hr>";
			printa($value);

			//$this -> snoopy -> fetchtext($value[3][0]);
			//printa($this -> snoopy -> results);
			//Se è una NOTA A MARGINE
			if ($value[1] == 1) {
				$var = json_decode($this -> snoopy -> results);
				//load $var->content
			} elseif ($value[1] == 2) {
				//$var=json_decode($this->snoopy -> results);
				//$var = json_decode($txt);
				$var=$this->spam[$key];
				printa($var);

				foreach ($var->items as $key => $value) {
					$value -> content;
					echo $value -> content;
					$id_verse_init = verse_to_id($value->book, $value->first_chapter, $value->first_verse);
					echo "id versetto iniziale: $id_verse_init --";
					$id_verse_end = verse_to_id($value->book, $value->last_chapter, $value->last_verse);
				}
			}

		}

	}

	function antispam() {
		$spam = explode("\n", file_get_contents("spam_link1"));
		$last_link_note = 0;
		//printa($spam);
		foreach ($spam as $key => $value) {
			if ($value != "") {
				//	printa($value);
				$pos = strstr($value, "{");
				$su=strstr($value, $pos);
				$val = json_decode($su);
				//echo $val;
				//printa($val);
				$this->spam[] = $val;
			}
		}
	}

}
?>