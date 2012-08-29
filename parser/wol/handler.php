<?php
class handlerer {

	/**
	 Array
	 (
	 [0] => Caratteri dall'inizio non serve
	 [1] => tipo
	 [2] => incremental tipo
	 [3] => Array del link
	 \------ [0] => URL
	 \------ [2] => HOST
	 \------ [4] => PATH
	 [4] => offset in spazi bianchi dall'inizio
	 )
	 */
	var $versetto_has_link;

	/**Stuff init and usual related things...
	 *
	 */
	function handlerer() {
		mb_internal_encoding("UTF-8");
		mb_regex_encoding("UTF-8");

		//TODO crea un array di look up
		$this -> id_lang = 0;
		//Default ita

		$this -> snoopy = new Snoopy;
		$this -> snoopy -> accept = "application/json, text/javascript, */*; q=0.01";
		//$this -> snoopy -> proxy_host = "localhost";
		//$this -> snoopy -> proxy_port = "79";

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
	 * @param capitolo da analizzare
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
	 *
	 * TODO se vuoi fare qualcosa NG che mantenga la sotto formattazione è da qua che devi partire...
	 */
	function parse_versetti($capitolo) {
		$this -> capitolo_id = $capitolo;
		unset($this -> verse);
		$this -> verse = array();
		$flag = true;
		$i = 1;
		unset($chapter);
		//echo $chapter;
		$chapter = "";
		//echo $chapter;
		$chapter = $this -> chapter[$capitolo];
		//echo $chapter;
		unset($pos);
		$pos = array();
		//printa($chapter);
		$off = mb_strpos($chapter, "id=\"content\"");

		$fine = mb_strpos($chapter, "</div></div>", $off);

		while ($flag) {

			// <span class="dv" id="v\n{1,3}"><a href="/it/wol/dx/r6/lp-i/232"><b><sup>27</sup></b>&nbsp;</a></span>

			if ($i == 1) {
				$spanme = "<span id='v$i' class='dc'>";
			} else {
				$spanme = "<span id='v$i' class='dv'>";
			}

			$pos[$i][0] = mb_strpos($chapter, "$spanme", $off) + 7;

			$pos[$i][1] = mb_strpos($chapter, "</span>", $pos[$i][0]) + 7;

			$delta = $pos[$i][1] - $pos[$i][0];
			//echo "$spanme @ {$pos[$i][0]} + {$pos[$i][1]} = $delta\n";

			if ($pos[$i][1] < $off || $pos[$i][0] == false) {
				$pos[$i][0] = $fine;
				$flag = false;
				break;
			} else {

				$off = $pos[$i][1];
				$i++;
			}
		}

		$pos[][0] = 0;
		//Per non far uscire l'errore della variabile mancante
		$j = $i;
		for ($i = 1; $i < $j; $i++) {
			//echo "$i da {$pos[$i][1]} a {$pos[$i+1][0]}\n";

			$txt = trim(mb_substr($chapter, $pos[$i][1], $pos[$i + 1][0] - $pos[$i][1]));
			$txt = str_replace("\n", " ", $txt);
			$txt = str_replace("<span i", " ", $txt);
			$txt = str_replace("</p>", " ", $txt);
			$txt = str_replace("</div>", " ", $txt);
			$txt = str_replace("<p class='sp'>", " ", $txt);
			$txt = str_replace("<p class='sb'>", " ", $txt);
			$txt = str_replace("<p class='sl'>", " ", $txt);
			$txt = str_replace("<p class='sz'>", " ", $txt);
			$txt = preg_replace("/<div id='p[0-9]+' class='par'>/", " ", $txt);
			$txt = no_double_space($txt);
			$this -> verse[$i] = trim($txt);

		}
		unset($this -> verse[$i]);

		/*
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
		 */

		//echo"<hr>";
		//die();

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

		$this -> inc_gg = 0;
		$this -> last_aar = 0;

		unset($this -> versetto_has_link);
		$this -> versetto_has_link = array();

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
		unset($this -> list);
		$this -> list = array();
		$verse = $this -> verse[$versetto_id];
		//$pos[1]=0;
		$verse = preg_replace('/\s\s+/', ' ', $verse);
		$verse_link = str_replace("href='/it", "href='http://wol.jw.org", $verse);
		$verse = trim($this -> snoopy -> _striptext($verse));

		//echo "lavoriamo su $verse <br>";
		unset($aar);
		preg_match_all("/(https?|ftp|telnet):\/\/((?:[a-z0-9@:.-]|%[0-9A-F]{2}){3,})(?::(\d+))?((?:\/(?:[a-z0-9-._~!$&()*+,;=:@]|%[0-9A-F]{2})*)*)(?:\?((?:[a-z0-9-._~!$&'()*+,;=:\/?@]|%[0-9A-F]{2})*))?(?:#((?:[a-z0-9-._~!$&'()*+,;=:\/?@]|%[0-9A-F]{2})*))?/i", $verse_link, $aar, PREG_SET_ORDER);

		/*
		 foreach ($aar as $key => $value) {
		 //echo "<br> aar numero $key";
		 @$aar[$key][5] = $this -> spam[$key + $this -> last_aar];
		 }
		 */
		$jj = 0;
		$num = mb_substr_count($verse, ' ');

		while ($flag == true) {

			@$pos[$i] = mb_strpos($verse, "+", $pos[abs($i - 1)] + 1);

			if ($pos[$i] == false) {
				$flag = false;
				unset($pos[$i]);
				break;
			} else {
				//$this -> margin_list[$this -> margin_counter][0] = $versetto_id;
				$stri = mb_substr($verse, 0, $pos[$i]);
				$bla = mb_substr_count($stri, ' ');
				$sle = mb_strlen($stri);
				$this -> list[$sle][0] = 2;
				$this -> list[$sle][1] = $bla;

				//$this -> list[$bla][1] = $bla;

				//echo "<br>stringa: $stri, spazi : $bla";

				//echo "\n<br>$ccs spazi";
				//$gl_m[];
			}
			//	printa($pos);
			if ($i > 160) {
				break;
			}
			$i++;

		}

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
				$stri = mb_substr($verse, 0, $pos[$i]);
				$bla = mb_substr_count($stri, ' ');
				$sle = mb_strlen($stri);
				$this -> list[$sle][0] = 1;
				$this -> list[$sle][1] = $bla;
				//$this -> list[$bla][1] = $bla;
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

		//printa($this -> list);
		ksort($this -> list);
		//printa($this -> list);

		$i = 0;
		foreach ($this -> list as $key => $value) {
			$aar[$i][6] = $value;

			$i++;

		}

		$this -> last_aar = $i + $this -> last_aar;
		//echo "versetto $versetto_id";
		//printa($aar);

		//die();
		//printa($this -> versetto_has_link);
		$this -> versetto_has_link[$versetto_id] = $aar;

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
		$id_versetto = verse_to_id($this -> libro_id, $this -> capitolo_id, $verse_id);
		//echo "\n Capitolo $this->capitolo_id : $verse_id as $id_versetto";

		//printa($id_versetto);
		//die();

		//alcuni versetti non hanno annotazioni
		if (isset($this -> versetto_has_ref[$verse_id])) {

			foreach ($this->versetto_has_ref[$verse_id] as $key => $value) {
				
				//se è marco 16 : 8 i primi due link sono ok, il resto è d fare a mano...
				if ($this-> libro_id == 41 && $this->capitolo_id == 16 && $verse_id == 8 && $key==2){
					break;
				}
				
				//echo "\n $key ° link";
				//	printa($value);
				//die();
				//echo "<br>il val è $value";
				//printa($value);

				//$this -> snoopy -> fetchtext($value[3][0]);
				//printa($this -> snoopy -> results);
				//Se è una NOTA A MARGINE

				if (!isset($value[1])){
					echo "errore in $this->libro $this->capitolo_id : $verse_id as $id_versetto - $key \n";
					printa($value);
				}
				
				if ($value[1][0] == 1) {
					//echo " nota";
					$var = $value[2] -> content;
					//printa($var);
					$var = mysql_escape_string($var);
					//die();
					//$var = json_decode($this -> snoopy -> results);
					//load $var->content
					$sql = "INSERT INTO `聖書`.`riferimenti`
				( `id_lang`, `id_versetto`, `offset`, `cosa`, `text`)
				 VALUES
				($this->id_lang, $id_versetto, '{$value[1][1]}', 1, '$var');
				";

					qi($sql);

				} elseif ($value[1][0] == 2) {
					//echo " margine";
					//$var=json_decode($this->snoopy -> results);
					//$var = json_decode($txt);

					$var = $value[2];

					//die();
					$i = 0;
					unset($mini);
					$mini = array();

					if (!isset($var -> items)) {
						echo "errore in $this->libro $this->capitolo_id : $verse_id as $id_versetto  a chiedere gli item del json associato $verse_id $key \n";
						printa($this->versetto_has_link[$verse_id]);
						printa($this->versetto_has_ref[$verse_id]);
					} else {

						foreach ($var->items as $key => $link) {

							$txt = str_replace("*", "", $link -> content);
							$txt = str_replace("+", "", $txt);
							//echo $txt;

							//Se chiamo un intero salmo
							if ($link -> book == 0 || $link -> first_chapter == 0 || $link -> first_verse == 0) {
								//echo "errore a chiedere l'id da parte di $this->libro $this->capitolo_id : $verse_id as $id_versetto  Ha chiesto $link->book $link->first_chapter:$link->first_verse\n";
								$id_verse_init = verse_to_id($link -> book, $link -> first_chapter, 1);
							} else {
								$id_verse_init = verse_to_id($link -> book, $link -> first_chapter, $link -> first_verse);
							}

							//Se chiamo un intero salmo
							if ($link -> book == 0 || $link -> last_chapter == 0 || $link -> last_verse == 0) {
								//echo "errore a chiedere l'id da parte di $this->libro $this->capitolo_id : $verse_id as $id_versetto Ha chiesto $link->book $link->last_chapter:$link->last_verse\n";
								$id_verse_end = verse_to_id($link -> book, $link -> last_chapter, 1);
							} else {

								$id_verse_end = verse_to_id($link -> book, $link -> last_chapter, $link -> last_verse);
							}
							//echo "id versetto iniziale: $id_verse_init --";

							$mini[$i][0] = $id_verse_init;
							$mini[$i][1] = $id_verse_end;

							//var_dump($txt);
							//die;
							//$mini[$i][2] = trim($txt);

							$i++;
						}
					}
					$min = mysql_escape_string(serialize($mini));
					//printa($value);
					$sql = "INSERT INTO `聖書`.`riferimenti`
				( `id_lang`, `id_versetto`, `offset`, `cosa`, `text`)
				 VALUES
				($this->id_lang, $id_versetto, '{$value[1][1]}', 2, '$min');
				";

					qi($sql);

				}

			}
		}

	}

	/**Riciclo la roba scaricata
	 *
	 */
	function antispam() {

		unset($this -> spam);
		//printa($this);
		//die;
		$path = "libri/it/spam/" . $this -> libro . "_" . $this -> capitolo_id;
		//	echo $path;
		$spam = explode("\n", file_get_contents($path));
		$e_flag = false;

		$last_link_note = 0;
		//printa($spam);
		$jj = 0;

		foreach ($spam as $key => $value) {
			//echo "$key -> $value <br>";
			$subs = substr($value, 0, 6);
			if ($value != "" && $subs == "@link ") {

				preg_match("/([0-9]+)-([0-9]+)/", $value, $roba);

				if ($roba[1] > $this -> versetti_num) {
					//Se il bug ridicolo dei versetti fantasma è presente
					$e_flag = true;
				} else {

					//	printa($value);

					$pos = strstr($value, "{");

					if (!$pos) {
						goto jsonerror;
					}
					$su = strstr($value, $pos);
					$val = json_decode($su);

					if (json_last_error() != JSON_ERROR_NONE || $val == "") {
						jsonerror:
						$e_flag = true;
						//Riscaricalo

						echo "huston abbiamo un problema @ $value -> tracciabile a";
						preg_match("/([0-9]+)-([0-9]+)/", $value, $roba);
						printa($roba);
						printa($this -> versetto_has_link[$roba[1]][$roba[2]]);

						$this -> snoopy -> fetchtext($this -> versetto_has_link[$roba[1]][$roba[2]][0]);
						//$this -> snoopy -> results = "nyan cat";
						$val = json_decode($this -> snoopy -> results);

						if (json_last_error() != JSON_ERROR_NONE || $val == "") {
							goto jsonerror;
						} else {

							$this -> spam[$jj][0] = $val;
							$this -> spam[$jj][1] = $roba;
							$jj++;
							echo "$this->libro ($this->libro_id) -$this->capitolo_id-$roba[1]-$roba[2]\n";
						}

					} else {
						$this -> spam[$jj][0] = $val;
						$this -> spam[$jj][1] = $roba;
						$jj++;
						//echo $val;
						//printa($val);

					}
				}

			}
		}

		if ($e_flag) {
			$fp = fopen($path, "w");
			foreach ($this -> spam as $key => $value) {
				$len = fwrite($fp, "@link {$value[1][1]}-{$value[1][2]}" . json_encode($value[0]) . "\n\n");

			}
			fclose($fp);
			//die();
		}

	}

	function load_spam() {

		unset($this -> spam);
		//printa($this);
		//die;
		$path = "libri/it/spam/" . $this -> libro . "_" . $this -> capitolo_id;
		//	echo $path;
		$spam = explode("\n", file_get_contents($path));
		$e_flag = false;

		$last_link_note = 0;
		//printa($spam);
		$jj = 0;

		foreach ($spam as $key => $value) {
			//echo "$key -> $value <br>";
			$subs = substr($value, 0, 6);
			if ($value != "" && $subs == "@link ") {

				preg_match("/([0-9]+)-([0-9]+)/", $value, $roba);

				if ($roba[1] > $this -> versetti_num) {
					//Se il bug ridicolo dei versetti fantasma è presente
					$e_flag = true;
				} else {

					//	printa($value);

					$pos = strstr($value, "{");

					if (!$pos) {
						goto jsonerror;
					}
					$su = strstr($value, $pos);
					$val = json_decode($su);

					if (json_last_error() != JSON_ERROR_NONE || $val == "") {
						echo "versetto $roba[1] - link $roba[2] - errore json";
						echo json_last_error();
						printa($val);
						//die();
						jsonerror:
						$e_flag = true;
						//Riscaricalo

						echo "huston abbiamo un problema @ $value -> tracciabile a";
						preg_match("/([0-9]+)-([0-9]+)/", $value, $roba);
						printa($roba);
						printa($this -> versetto_has_link[$roba[1]][$roba[2]]);

						$this -> snoopy -> fetchtext($this -> versetto_has_link[$roba[1]][$roba[2]][0]);
						//$this -> snoopy -> results = "nyan cat";
						$val = json_decode($this -> snoopy -> results);

						if (json_last_error() != JSON_ERROR_NONE || $val == "") {
							goto jsonerror;
						} else {

							$this -> spam[$roba[1]][$roba[2]][0] = $val;
							$this -> spam[$roba[1]][$roba[2]][1] = $roba;
							//$this -> spam[$jj][1] = $roba;
							$jj++;
							echo "$this->libro ($this->libro_id) -$this->capitolo_id-$roba[1]-$roba[2]\n";
						}

					} else {
						$this -> spam[$roba[1]][$roba[2]][0] = $val;
						$this -> spam[$roba[1]][$roba[2]][1] = $roba;
						//$this -> spam[$jj][0] = $val;
						//$this -> spam[$jj][1] = $roba;
						$jj++;
						//echo $val;
						//printa($val);

					}
				}

			}
		}

		$e_flag = false;
		if ($e_flag) {
			$this -> fix_link();
		}

	}

	function fix_link() {
		$path = "libri/it/spam/" . $this -> libro . "_" . $this -> capitolo_id;
		$fp = fopen($path, "w");

		foreach ($this -> spam as $key => $value) {
			foreach ($value as $l_k => $l_v) {

				$len = fwrite($fp, "@link {$key}-{$l_k}" . json_encode($l_v[0]) . "\n\n");
			}
		}
		fclose($fp);
	}

	/**Tutti i link trovati in versetto_has_link
	 * TODO parallelizzami plz
	 */
	function fetch_link() {
		$fp = fopen("libri/it/spam/" . $this -> libro . "_" . $this -> capitolo_id, 'w');
		foreach ($this->versetto_has_link as $versetto_num => $link_arr) {

			if (!$fp) {
				die();
			}
			foreach ($link_arr as $link_key => $link) {
				$this -> snoopy -> fetchtext($link[0]);
				//$this -> snoopy -> results = "nyan cat";
				$len = fwrite($fp, "@link $versetto_num-$link_key" . $this -> snoopy -> results . "\n\n");
				echo "$this->libro ($this->libro_id) -$this->capitolo_id-$versetto_num-$link_key\n";
			}

		}
	}

	function db_clean() {
		$sql = "truncate table riferimenti";
		qq($sql);
	}

	function link_fullati() {

		echo "controllo se è fullato $this->libro\n";

		for ($i = 1; $i <= $this -> chapter_count; $i++) {

			if (file_exists("libri/it/spam/" . $this -> libro . "_" . $i)) {

			} else {
				$this -> last_book = $i;
				$this -> link_fullati = false;
				$flag = false;
				return false;
			}
		}

		$this -> link_fullati = true;
		return true;
	}

	/** Faccio il merge dei link e dei json
	 *
	 */
	function link_merge() {
		//se ci sono link scaricati da aggiugnere poi al testo
		$e_flag = false;
		//Per ogni versetto
		foreach ($this->versetto_has_link as $key => $value) {
			//Per ogni link nel versetto
			foreach ($value as $l_k => $l_v) {

				//printa($l_v);
				//die();
				//Prendo il link
				$this -> versetto_has_ref[$key][$l_k][0] = $l_v[0];
				//Prendo la posizione
				if (!isset($l_v[6])) {
					echo "manca la posizione a $this->libro $this->capitolo_id : $key  - $l_k \n";
				} else {
					$this -> versetto_has_ref[$key][$l_k][1] = $l_v[6];
				}

				//SE NON è presente nei link scaricati
				if (!isset($this -> spam[$key][$l_k])) {
					$e_flag = true;
					//echo "prok $key";
					//Scarico
					$this -> snoopy -> fetchtext($l_v[0]);
					$val = json_decode($this -> snoopy -> results);
					//E lo inserisco
					$this -> spam[$key][$l_k][0] = $val;
					$this -> spam[$key][$l_k][1][0] = $key;
					$this -> spam[$key][$l_k][1][1] = $l_k;
				}
				$pack1 = $this -> spam[$key][$l_k][0];
				$pack2 = $this -> spam[$key][$l_k][1];

				$this -> versetto_has_ref[$key][$l_k][2] = $pack1;
				$this -> versetto_has_ref[$key][$l_k][3] = $pack2;

			}

		}

		if ($e_flag) {
			$this -> fix_link();
		}
	}

}
?>