<?php

/**
 * fa gli option ecc /option dei select nei form
 *
 * @param array di valori $iss
 * @param le rende già selezionati TUTTI
 * @return gli option
 */
function selecta($iss, $ck = FALSE, $out = false) {
	$sel = $ck ? 'selected="selected" ' : '';
	foreach ($iss as $value) {
		$s = $s . "<option " . $sel . "value=\"$value\" class=\"optimax\">$value</option>\n";
	}
	unset($value);
	// break the reference with the last element
	echo($out ? $s : "");
	return $s;
}

/**
 * fa gli option ecc /option dei select nei form
 *
 * @param array di valori $iss
 * @param num, quale è selezionato stringa
 * @return gli option
 */
function selecta_one($iss, $num) {
	foreach ($iss as $value) {
		if ($value == $num) {
			$s = $s . "<option selected=\"selected\" class=\"optimax\">$value</option>";
		} else {
			$s = $s . "<option class=\"optimax\">$value</option>";
		}
	}
	unset($value);
	// break the reference with the last element
	return $s;
}

/**
 * fa gli option ecc /option dei select nei form
 *
 * @param array di valori $iss
 * @param num, quale è selezionato, numero
 * @return gli option
 */
function selecta_two($iss, $num) {
	$i = 0;
	foreach ($iss as $value) {
		if ($i == $num) {
			$s = $s . "<option selected=\"selected\" class=\"optimax\">$value</option>";
		} else {
			$s = $s . "<option class=\"optimax\">$value</option>";
		}
		$i++;
	}
	unset($value);
	// break the reference with the last element
	return $s;
}

/**
 * Fa solo la instezazione
 *
 * @param $campi
 * @return select $campi
 */
function select_ins($campi) {
	$select = <<<EOD
	<select $campi >
EOD;
	return $select;
}

/**
 * Fa solo la instezazione
 *
 * @param $campi ovvero cose da intestare (style ecc)
 * @return select $campi
 */
function text_ins($size, $nome, $class) {
	$s = <<<EOD
	<input type="text" size="$size" $nome class=$class />
EOD;
	return $s;
}

function tabella_art($iss) {
	Global $campi_numerici_option;
	Global $campi_bool_option;
	Global $campi_real_option;
	Global $campi_testo_option;

	$head = <<<EOD
<br>
<div id="field_ins">
<h2>Ricerca Articolata</h2>
<table class="testo_16" cellspacing="5">
	<thead>
		<tr class="thead">
			<th>Campo</th>
			<th>Tipo</th>
			<th>Nome</th>
			<th>Operatore</th>
			<th>Chiave</th>
		</tr>
	</thead>
<tbody>
EOD;

	$todd = <<<EOD
<tr class="odd">
EOD;

	$teven = <<<EOD
<tr class="even">
EOD;

	$td = <<<EOD
	<td>
EOD;

	$tdd = <<<EOD
</td>\n

EOD;

	$trr = <<<EOD
</tr>

EOD;

	$th = <<<EOD
	<th align="left">
EOD;

	$thh = <<<EOD
</th>
EOD;

	$selectt = <<<EOD
</select>
EOD;

	$foot = <<<EOD
</tbody>
</table>
<div align="right" onmouseout="attiva('submit2')"><INPUT type="submit" name="submit2" id="submit2" value="Ricerca" size="10em" onclick="this.disabled=true" onmouseout="this.enabled=true" style="font-size : 180%;"></div>
</div>
EOD;
	$chiave = "chiave";

	$tabella = $head;
	$odd = 1;
	foreach ($iss as $value) {
		switch ($value[3]) {
			case 'int' :
				// fall-through
				$option = $campi_numerici_option;
				$option_l = sizeof($campi_numerici_option);
				break;
			case 'real' :
				$option = $campi_real_option;
				$option_l = sizeof($campi_real_option);
				break;
			case 'char' :
				$option = $campi_testo_option;
				$option_l = sizeof($campi_testo_option);
				break;
			case 'bool' :
				$option = $campi_bool_option;
				$option_l = sizeof($campi_bool_option);
				break;
			case 'data' :
				$option = $campi_numerici_option;
				$option_l = sizeof($campi_bool_option);
				break;
			default :
				$campi_numerici_option = "<option value=\"=\">Errore</option>";
				$option_l = 1;
		}
		$name = "name=\"$value[0]\"";
		$classe = " class=\"selecta\" style=\"padding:1px; width:10em\"";
		$campi = $name . $classe;
		$select = select_ins($campi);
		$name = "name=\"$value[0]_chiave\"";
		$chiave = text_ins(40, $name, "testo_16");

		if ($odd == 1) {//ciclo numeri dispari
			$tabella = $tabella . $todd . $th . $value[0] . $thh . $td . $value[2] . $tdd . $td . $value[1] . $tdd . $td . $select . $option . $selectt . $tdd . $td . $chiave . $tdd . $trr;
			$odd = 0;
		} else {//ciclo pari
			$tabella = $tabella . $teven . $th . $value[0] . $thh . $td . $value[2] . $tdd . $td . $value[1] . $tdd . $td . $select . $option . $selectt . $tdd . $td . $chiave . $tdd . $trr;
			$odd = 1;
		}
	}
	// $arr is now array(2, 4, 6, 8)
	unset($value);
	// break the reference with the last element
	$tabella = $tabella . $foot;
	return $tabella;
}

function strippa($array, $cosa) {
	$s = "`" . $cosa . "` IN (";
	$l = sizeof($array) - 1;
	for ($i = 0; $i < $l; $i++) {
		$s = $s . "'" . $array[$i] . "',";
	}
	$s = $s . "'" . $array[$i] . "')";
	return $s;
}

function strippa2($selettati, $valore) {
	if (!$selettati) {// primo ciclo, perchè è vuoto il campo
		$selettati = "`" . $valore . "`";
	} else {// dal secondo in poi si mette la virgola
		$selettati = $selettati . ",`" . $valore . "`";
	}
	return $selettati; ;
}

function strippa3($wherati, $nome, $tipo, $chiave) {
	if (!$wherati) {// primo ciclo, perchè è vuoto il campo
		$wherati = "`" . $nome . "` " . $tipo . " '" . $chiave . "'";
	} else {// dal secondo in poi si mette la virgola
		$wherati = $wherati . " AND `" . $nome . "` " . $tipo . " '" . $chiave . "'";
	}
	return $wherati; ;
}

function c_box($nome, $class, $ischeck) {
	$nome = $nome . "ck";
	if ($ischeck) {
		$s = <<<EOD
		<INPUT type="checkbox" checked name="$nome" class="$class">
EOD;
	} else {
		$s = <<<EOD
		<INPUT type="checkbox" name="$nome" class="$class">
EOD;
	};
	return $s;
}

/**
 * @param unknown_type $iss
 * @return unknown_type
 */
function tabella_campicerca($iss) {

	$head = <<<EOD
<TABLE widht="100%">
  <caption>Click sui campi che vuoi veder visualizzati</caption>
  <tbody>
EOD;

	$todd = <<<EOD
<tr class="odd">
EOD;

	$teven = <<<EOD
<tr class="even">
EOD;

	$td = <<<EOD
<td>
EOD;

	$tdd = <<<EOD
</td>\n

EOD;

	$trr = <<<EOD
</tr>

EOD;

	$th = <<<EOD
	<th align="left"  class="testo_14">
EOD;

	$thh = <<<EOD
</th>
EOD;

	$selectt = <<<EOD
</select>
EOD;

	$foot = <<<EOD
</tbody>
</table>
</div>
EOD;

	$tabella = $head;
	$odd = 1;
	$le = sizeof($iss) - 1;
	for ($i = 0; $i < $le; ) {
		$j = $i;
		$i++;
		$imp1 = c_box($iss[$j][0], "", $iss[$j][4]);

		if ($iss[$i][1]) {
			$imp2 = c_box($iss[$i][0], "", $iss[$i][4]);
			$block2 = $th . $iss[$i][1] . $thh . $td . $imp2 . $tdd;
		}

		if ($odd == 1) {//ciclo numeri dispari
			$tabella = $tabella . $todd . $th . $iss[$j][1] . $thh . $td . $imp1 . $tdd . $block2 . $trr;
			$odd = 0;
		} else {//ciclo pari
			$tabella = $tabella . $teven . $th . $iss[$j][1] . $thh . $td . $imp1 . $tdd . $block2 . $trr;
			$odd = 1;
		}
		$i++;
	}
	// $arr is now array(2, 4, 6, 8)
	$tabella = $tabella . $foot;
	return $tabella;

}

/**
 * Inserisce $n <br> ovvero i ritorni a capo nell'html
 * @param $n
 * @return nulla.. scrive a schermo
 */
function exn($n = 1) {
	for ($i = 1; $i <= $n; $i++) {echo "\n";
	}
}

/**
 * Inserisce $n <br> ovvero i ritorni a capo nell'html
 * @param $n
 * @return nulla.. scrive a schermo
 */
function exb($n = 1) {
	for ($i = 1; $i <= $n; $i++) {echo "<br>";
	}
}

/**
 * Inserisce un <hr> ovvero la linea di interruzione nell'html
 * @param $n
 * @return nulla.. scrive a schermo
 */
function exh() {echo "<hr>";
}

function string_to_ascii($string) {
	$ascii = NULL;

	for ($i = 0; $i < strlen($string); $i++) {
		$ascii[$i] = ord($string[$i]);
	}

	return ($ascii);
}

function cancella_conf($findme, $verbose = false) {

	$file = 'Util/config.php';
	// Apro il file di configurazione
	$fr = fopen($file, 'r+');
	// In lettura + scrittura, con il puntatore all'inizio del file

	$my_file = file_get_contents($file);
	// E lo leggo
	$lenght = strlen($findme);
	// quanto è lunga
	$pos = strpos($my_file, $findme);
	//cerco la cosa da cancellare

	if ($pos === false)// se non c'è amen
	{
		echo($verbose ? "The string '$findme' was not found in the string Util/config.php" : "");
	} else {
		echo($verbose ? "The string '$findme' was found in the string Util/config.php" : "");
		echo($verbose ? " and exists at position $pos <br>" : "");
		fseek($fr, $pos + $lenght, SEEK_SET);
		$byte = fread($fr, 2);
		$nbyte = string_to_ascii($byte);

		if ($nbyte[0] == 13) {//scritto da windows, mac
			if ($nbyte[1] == 10) {//scritto da windows

				echo($verbose ? "the (ASCII 13 + 10 (0x0D + 0x0A)), carriage return and new line (line feed) Alias WINDWOS new line were found " : "");

				$newfile = substr_replace($my_file, "", $pos, $lenght + 2);
				//$newfile=preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $newfile);
				rewind($fr);
				ftruncate($fr, 0);
				fwrite($fr, $newfile);

			} else {//scritto dal mac
				echo($verbose ? "the (ASCII 13 (0x0D)) a carriage return  Alias MACHINTOSH new line was found " : "");
				$newfile = substr_replace($my_file, "", $pos, $lenght + 1);
				//$newfile=preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $newfile);
				rewind($fr);
				ftruncate($fr, 0);
				fwrite($fr, $newfile);
			}

		} else {//scritto da linux
			echo($verbose ? "the (ASCII 10 (0x0A)) a new line (line feed) Alias UNIX new line  was found " : "");
			$newfile = substr_replace($my_file, "", $pos, $lenght + 1);
			//$newfile=preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $newfile);
			rewind($fr);
			ftruncate($fr, 0);
			fwrite($fr, $newfile);
		}

		fclose($fr);
	}
	$verbose ? exb(3) : "";
}

function inserisci_conf($findme, $valore, $verbose = FALSE) {

	$file = 'Util/config.php';
	// Apro il file di configurazione
	$fileT = 'Util/configTEMP.php';
	//Testing purpose only
	$fr = fopen($file, 'r+');
	// In lettura + scrittura, con il puntatore all'inizio del file
	$frT = fopen($fileT, 'r+');
	//Testing purpose only

	$my_file = file_get_contents($file);
	// E lo leggo
	$lenght = strlen($findme);
	// quanto è lunga
	$pos = strpos($my_file, $findme);
	//cerco la cosa da cancellare

	if ($pos === false)// se non c'è amen
	{
		echo "The string '$findme' was not found in the string Util/config.php";
	} else {
		echo($verbose ? "The string '$findme' was found in the string Util/config.php" : "");
		echo($verbose ? " and exists at position $pos <br>" : "");
		fseek($fr, $pos - $lenght, SEEK_SET);

		$PPP = PHP_EOL;
		$newfile = substr_replace($my_file, "$valore$PPP", $pos, 0);
		ftruncate($fr, 0);
		rewind($fr);
		$newfile = removeEmptyLines($newfile);
		fwrite($fr, $newfile);

		fclose($fr);
		fclose($frT);
	}
}

function info_grate($t, $p) {
	GLOBAL $sez_grate_tipo;
	$siz = sizeof($sez_grate_tipo) - 1;
	for ($i = 0; $i <= $siz; $i++) {
		if ($sez_grate_tipo[$i] -> sez == $t && $sez_grate_tipo[$i] -> tipo == $p) {
			break;
		}
	}

	return $i;
}

function pari($i) {
	if (is_int($i / 2)) {
		return TRUE;
	} else {
		return FALSE;
	}
}

function removeEmptyLines($string) {
	return preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $string);
}

function unix_eol($string) {
	$eol = array("\r\n", "\r", "\n");
	$data = str_replace($eol, "\n", $string);

	return $data;
}

function conf_fix_eol($verbose = FALSE) {

	$file = 'Util/config.php';
	// Apro il file di configurazione
	//$fileT='Util/configTEMP.php';    //Testing purpose only
	$fr = fopen($file, 'r+');
	// In lettura + scrittura, con il puntatore all'inizio del file
	//$frT = fopen($fileT, 'r+');		 //Testing purpose only

	$my_file = file_get_contents($file);
	// E lo leggo
	$my_file = unix_eol($my_file);
	ftruncate($fr, 0);
	rewind($fr);
	fwrite($fr, $my_file);
	fclose($fr);
	//fclose($frT);
}

function iddizza($ora) {

	$ora = time();
	$sql = "INSERT INTO `form` (`ext` )  VALUES  ('$ora')";
	$frok = mysql_query($sql);
	$query = "SELECT LAST_INSERT_ID( )";
	$frok = mysql_query($query);
	$row = mysql_fetch_array($frok);
	$lastid = $row[0];
	return $lastid . "+" . $ora;
}

function lowera($what) {

	$what = explode(" ", $what);

	foreach ($what as $parte) {

		$char = ($var ? " " : "");
		$var = $var . $char . str_replace("*", " ", ucfirst(strtolower($parte)));

	}
	return $var;
}

function split_località($via) {
	$arr['via'] = $via;
	$arr['si'] = 0;
	$cercami = array("località", "Loc.", "Loc", "presso", "zona", "vicino", "(");
	$arr[via] = $via;
	foreach ($cercami as $key) {//echo "$key";
		$yep = stripos($via, $key);
		//echo "<br>$key - # $yep ---";
		if ($yep !== false) {
			//echo "<br>prol und $key @ $yep<br>";
			$arr[via] = substr($via, 0, $yep);
			$arr[loc] = substr($via, $yep);
			$arr[si] = true;
			return $arr;
		}
	}
	$cercami = array("-");
	$arr[via] = $via;
	foreach ($cercami as $key) {//echo "$key";
		$yep = stripos($via, $key);
		//echo "<br>$key - # $yep ---";
		if ($yep !== false) {	$dime = strlen($key);
			//echo "<br>prol und $key @ $yep<br>";
			$arr[via] = substr($via, 0, $yep);
			$arr[loc] = substr($via, $yep + $dime);
			$arr[si] = true;
			return $arr;
		}
	}

	return $arr;
	dumpa($arr, 1);

}

/**
 * Cerca con la regex i numeri, se lo trova riporta tutto cio che ne viene dopo
 *
 * @param unknown_type $via
 * @return unknown_type
 */

/**
 * Riporta la data in formato unix, esplode le /
 * @param gg/mm/aaaa $data
 * @return il timestam o FALSE se è prima del 2002 (1009839600)
 */
function datalo($data) {
	$ar = explode("/", $data);
	//dumpa($ar);
	$unix = mktime(0, 0, 0, $ar[1], $ar[0], $ar[2]);

	if ($unix < 1009839600)//prima del 2002
	{
		/* @var string */
		$unix = "";
	}
	return $unix;
}

// aggiungi le date
function datalo2($data) {
	$ar = explode("-", $data);
	//dumpa($ar);
	$mesi = array("gen", "feb", "mar", "apr", "mag", "giu", "lug", "ago", "set", "ott", "nov", "dic");
	$numeri = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
	$ar = str_replace($mesi, $numeri, $ar);
	$unix = mktime(0, 0, 0, $ar[1], $ar[0], 2009);

	if ($unix < 1073257200)//prima del 2004
	{
		$unix = "";
	}
	return $unix;
}

function fetch_valvola($cosa) {
	$bam = explode(" ", $cosa);
	$ar = explode("/", $bam[4]);
	$info['marca'] = $bam[0];
	$info['tipo'] = $bam[1] . $bam[2];
	$info['seriale'] = $bam[3];
	$info['revisione'] = $bam[4];
	$info['timestamp_rev'] = mktime(0, 0, 0, $ar[1], $ar[0], "20" . $ar[2]);
	return $info;
}

function fetch_fabrica($cosa) {
	$bam = explode(" ", $cosa);
	$ar = explode("-", $bam[1]);
	$info['fabrica'] = $bam[0];
	$info['anno'] = $bam[1];
	$info['timestamp_fab'] = mktime(0, 0, 0, $ar[0], 1, $ar[1]);
	return $info;
}

function fetch_matricola($cosa) {
	//dumpa($cosa);
	$num = preg_match("/[A-z]/", $cosa, $m, PREG_OFFSET_CAPTURE);
	$pos = stripos($cosa, "-");
	if ($num) {//dumpa($m);
		$ban['matricola'] = substr($cosa, 0, $m[0][1]);
		$ban['costruttore'] = substr($cosa, $m[0][1], $pos - $m[0][1]);
		$anno = substr($cosa, $pos + 1);
		if ($anno > 20) {
			$ban['anno'] = "19" . $anno;
		} else {
			$ban['anno'] = "20" . $anno;
		}
		$ban['timestamp_anno'] = mktime(0, 0, 0, 1, 1, $ban['anno']);
		//dumpa($ban);
	}

	return $ban;
}

function checknote($nota) {
	$flag = "";
	//echo "entro<br>";
	$cercami = array("ritirato", "ritiro", "ritirare", "ritir");
	foreach ($cercami as $key) {//echo "$key in $nota<br>";
		//echo "cerco i ritiri<br>";
		$yep = stripos($nota, $key);
		if ($yep !== false) {//echo "<h3> Th@ Way</h3>";
			$flag = "ritirare";
			//echo "\t trovato un ritiro <br>";
			return $flag;
			goto end;
		}
	}
	//echo "e adesso ???<br>";
	$yep = preg_match("/[0-9]../", $nota, $m);
	//dumpa($m,1);
	if ($m != false) {
		$flag = "cellulare";
		//echo "ma che ti prokki ???<br>";
		return $flag;
		goto end;
	}

	$cercami = array("sottovalvolva", "sotto valvola", "cambiare s valvola", "cambiare");
	foreach ($cercami as $key) {
		$yep = stripos($nota, $key);
		if ($yep !== false) {
			$flag = "sottovalvola";
			return $flag;
			goto end;
		}
	}

	$cercami = array("possiede", "non hanno");
	foreach ($cercami as $key) {
		$yep = stripos($nota, $key);
		if ($yep !== false) {
			$flag = "possiede";
			return $flag;
			goto end;
		}
	}

	$cercami = array("fatta", "cambiata", "sostituita");
	foreach ($cercami as $key) {
		$yep = stripos($nota, $key);
		if ($yep !== false) {
			$flag = "fatta";
			return $flag;
			goto end;
		}
	}

	$cercami = array("entrare", "indisposto");
	foreach ($cercami as $key) {
		$yep = stripos($nota, $key);
		if ($yep !== false) {
			$flag = "indisposto";
			return $flag;
			goto end;
		}
	}

	$cercami = array("sprofondato");
	foreach ($cercami as $key) {
		$yep = stripos($nota, $key);
		if ($yep !== false) {
			$flag = "impossibile";
			return $flag;
			goto end;
		}
	}

	end:
	//sintatti valida, da errore devi aggiornare l'editor a php 5.3 (goto)

}

function eval_val($r) {
	switch ($r) {
		case "x" :
			return true;
			break;
		case "X" :
			return true;
			break;
		default :
			return false;
	}

}

function fetch_matricola2($r) {
	$rr = explode(" ", $r);
	$ma['fabrica'] = $rr[0];
	$ma['costruttore'] = $rr[1];
	return $ma;
}

/**
 * Importa la località e fix i LOC LOC. in Località
 * @param unknown_type $loc
 * @return unknown_type
 */

/**Echo
 * @param $cosa
 * @param $verbose
 * @param $soglia
 */
function echa($cosa, $si = 0, $level) {
	if ($si >= $level) {
		echo $cosa;
	}
}

/**Echo condizionale, if globale[] as $tipo == locale
 * @param $cosa
 * @param $livello globale
 * @param $livello locale
 */
function exa($cosa, $level, $si = false) {
	GLOBAL $vG;

	if ($si === False) {
		$si = $vG;
	}
	$siz = sizeof($si);
	if ($siz == 1) {
		if ($si == $level) {
			echo $cosa;
		}
	} else {
		foreach ($si as $tipo) {
			//			echo "$tipo and $level<br>";
			if ($tipo === $level) {
				echo $cosa;
			}
		}
	}
}

/**Cerca un valore in un array, partendo da start ed eventualmente finendo a stop o trovati "quanti" oppure dopo "tot" righe
 * @param $array L'array da spizzare
 * @param $hay	Cosa Cercare
 * @param $start Da dove parto
 * @param $stop Quando mi fermo
 * @param $quanti Quanti te ne trovo
 * @param $tot Dopo quanti bloccotti di array mi fermo
 * @return la chiave, o le chiavi[]
 */
function array_risearch($array, $hay, $start = 0, $stop = 0, $quanti = 1, $tot = 0) {
	$trovati = false;

	$le = count($array);
	if ($tot == 0 && $stop == 0) {
		$stop = $le;
	}
	if ($tot > 1 && $stop > 1) {
		echo "O Tot o Stop, non entrambi nabbo";
		return false;
	}
	if ($tot > 1 && $stop == 0) {
		$stop = $le - $start - $tot;
	}

	if ($start >= $stop) {
		echo "bei parametri che passi...";
		echo "<br>$start e $stop :<br>";
		return false;
	}

	if ($start == False) {
		echo "bei parametri che passi su $ start";
		return false;
	}

	$found = 0;

	//dumpa ($array,1);
	for ($i = $start; $i <= $stop; $i++) {
		//echo "\n<br>$array[$i]";
		if ($array[$i] == $hay) {
			$trovati[] = $i;
			$found++;
			if ($found >= $quanti && $quanti != 0) {
				break 1;

			}
		}

	}
	//dumpa ($trovati);
	if ($trovati[1] == 0) {
		$trovati = $trovati[0];
	}

	//dumpa ($trovati);
	return $trovati;

}

/**printa a schermo
 *
 */
function printa($cosa) {
	echo "<pre>";
	print_r($cosa);
	echo "</pre>";
}

/**Rimuove gli spazi doppi
 */
function no_double_space($text) {
	$tags = preg_replace('/\s\s+/', ' ', $tags);
}

/**Ritorna un array con le posizioni
 *
 */
function mb_strpos_all($testo, $cosa) {
	$cosa_le = mb_strlen($cosa);
	$str_le = mb_strlen($testo);
	$off = 0;
	$flag = true;
	$i = 0;
	while ($flag) {
		$pos[$i] = mb_strpos($testo, $cosa, $off);
		if ($pos[$i] == false) {
			$flag = false;
			unset($pos[$i]);
			break;
		} else {
			$off = $pos[$i] + $cosa_le;
			$i++;
		}
		//

	}
	return $pos;

}

/** Combina gli array mantenendone in qualche modo l'ordine,
 * e passando l'attuale indice come valore...
 */
function array_flip_combine_plus($a1, $a2,$inc_gg=0) {

	$a1 = array_flip($a1);
	$a2 = array_flip($a2);


	foreach ($a1 as $key => $value) {

		$le[$key][0] = $key;
		$le[$key][1] = 1;
		$le[$key][2] = $value;
	
	}
	foreach ($a2 as $key => $value) {

		$le[$key][0] = $key;
		$le[$key][1] = 2;
		$le[$key][2] = $value;
		
	}
	@sort($le);
	
	//printa($le[2]);
	//die();
	
	$si=sizeof($le);
	$kk=array();
	for ($i=0; $i < $si; $i++) { 
		$kk[$i]=$le[$i];
		$kk[$i][5]=$inc_gg;
		$inc_gg++;
	}
	

	return $kk;

}


//print_r($pack[66][22]);

function verse_to_id($book, $chapter, $verse) {
	GLOBAL $pack;
	if ($pack == "") {
		$pack = unserialize(file_get_contents(PATH . "libri/pack"));
	}
	return $pack[$book][$chapter][$verse];
}

function id_to_verse($id) {
	GLOBAL $pack_r;
		if ($pack_r == "") {
		$pack_r = unserialize(file_get_contents(PATH . "libri/pack_r"));
	}
	return $pack_r[$id];
}
?>