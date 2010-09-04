<?php


/**
 * @param any $what cosa devo dumpare
 * @param bool $rs dump o print
 * @return ti sbagli sempre...
 */
function dumpa ($what,$rs=false)
{
	echo "<pre>";
	if ($rs)
	{
		print_r($what);
	}
	else {
		var_dump($what);
	}
	echo "</pre>";
	return false;
}



/**
 * Inserisce $n <br> ovvero i ritorni a capo nell'html
 * @param $n
 * @return nulla.. scrive a schermo
 */
function exb ($n=1)
{for ($i = 1; $i <= $n; $i++)
{echo "<br>";}}
/**
 * Inserisce un <hr> ovvero la linea di interruzione nell'html
 * @param $n
 * @return nulla.. scrive a schermo
 */
function exh ()
{echo "<hr>";}


function html_add ($cosa,$dove)
{
	$dove=$dove.$cosa;
	return $dove;
}


/**
 * fa gli option ecc /option dei select nei form
 *
 * @param array di valori $iss
 * @param num, quale è selezionato, numero
 * @return gli option
 */

function selecta_sl($iss,$num=FALSE){
	$word_page_get="p2?w";
	$i=0;
	foreach ($iss as $value) {
		if ($i==$num)
		{
			$s =$s."<option selected=\"selected\" value=\"$word_page_get=$value\" >$value</option>\n";
		}
		else
		{
			$s =$s."<option value=\"$word_page_get=$value\" >$value</option>\n";
		}
		$i++;
	}
	unset($value); // break the reference with the last element
	return $s;
}

/**
 * fa gli option ecc /option dei select nei form
 *
 * @param array di valori $iss
 * @param num, quale è selezionato, numero
 * @return gli option
 */

function selecta_l($iss,$num=FALSE){
	$i=0;
	foreach ($iss as $value) {

		$s =$s."<option value=\"p?w=$value\" >$value</option>\n";

		$i++;
	}
	unset($value); // break the reference with the last element
	return $s;
}


function megafetcher ($testo,$cosa)
{
	preg_match_all($cosa,$testo,$out);
	return $out;
}



function initsphinx()
{
	$cl = new SphinxClient ();
	$cl->config_1_bibbia();
	return $cl;
}




/**
 * @param sphinx_id $cl
 * @param testo della query $q
 * @param indie da usare $i
 * @param verbositi level $v 1  3 4 5 6=debug
 * @param offset $o
 * @param quante $l
 */
function printquery($cl,$q,$i,$v,$o,$l)
{
	$max=$o+$l;
	$cl->SetLimits ( $o, $l, $max, 0 );
	$res = $cl->Query ( $q, $i );


	if ( $res===false)
	{
		print "Query failed: " . $cl->GetLastError() . ".\n";

	} else
	{
		if ( $cl->GetLastWarning() && $v>6 )
		{
			print "WARNING: " . $cl->GetLastWarning() . "\n\n";
		}
		if ($v>3)
		{
			print "<h2>Query <br>$q<br> retrieved $res[total] of $res[total_found] matches in $res[time] sec</h2>.\n";
			echo "<pre>";
			print "Query stats:\n";
			if ( is_array($res["words"]) )
			foreach ( $res["words"] as $word => $info )
			print "    '$word' found $info[hits] times in $info[docs] documents\n";
			print "\n";
			echo "</pre>";
		}
		if ( is_array($res["matches"]) )
		{
			$n = 1;
			if ($v>4)
			{
				print "Matches:\n";
			}
			foreach ( $res["matches"] as $docinfo )
			{
				if ($v>5)
				{
					print "$n. doc_id=$docinfo[id], weight=$docinfo[weight]";
				}
				//echo "</pre>";
				foreach ( $res["attrs"] as $attrname => $attrtype )
				{
					$value = $docinfo["attrs"][$attrname];
					if ( $attrtype & SPH_ATTR_MULTI )
					{
						$value = "(" . join ( ",", $value ) .")";
					} else
					{
						if ( $attrtype==SPH_ATTR_TIMESTAMP )
						$value = date ( "Y-m-d H:i:s", $value );
					}
					print ", $attrname=$value";
				}
				if ($v>=1)
				{
					print "\n";
					echo "<p style=\" font-family:inconsolata; font-size:20px; padding: 8px 0 0px 6px; margin: 0;\">il testo era: </p>\n";
					echo "<p style=\" width:95%; font-family:inconsolata; font-size:18px; padding: 6px 18px 22px 25px; margin: 0\">";

					$link="p?w=\\1";

					$action="";
					//$id="id=\"\\1\"";
					$id="";
					$pattern="/(\p{L}{3,})/u";
					$replace="<a $id href=\"$link\" $action>\\1</a>";

					$text=get_id($docinfo[id]);
					$text=preg_replace($pattern,$replace,$text);
					echo "$text";
					echo "</p>";
					echo "<hr>";
				}

				if ($v<1)
				{

					$link="p?w=\\1";
					$action="";
					//$id="id=\"\\1\"";
					$id="";
					$pattern="/(\p{L}{3,})/u";
					$replace="<a $id href=\"$link\" $action>\\1</a>";
					$text=get_id($docinfo[id]);
					$vers=get_vers($docinfo[id]);
					$text=preg_replace($pattern,$replace,$text);
					echo "$vers[0] $text";
				}

				$n++;
			}
		}
	}
}



/**
 * @param sphinx_id $cl
 * @param testo della query $q
 * @param indice da usare $i
 * @param offset $o
 * @param quante $l
 */
function getquery($cl,$q,$i,$o,$l)
{
	$max=$o+$l;
	$cl->SetLimits ( $o, $l, $max, 0 );
	$res = $cl->Query ( $q, $i );



	if ( $res===false)
	{
		print "Query failed: " . $cl->GetLastError() . ".\n";

	} else
	{

		foreach ( $res["matches"] as $docinfo )
		{

			$id[]=$docinfo['id'];
		}
	}
	return $id;
}



function text_hype ($testo)
{
	$link="p.php?w=\\1";

	$action="";
	//$id="id=\"\\1\"";
	$id="";
	$pattern="/(\p{L}{3,})/u";
	$replace="<a $id href=\"$link\" $action>\\1</a>";
	$text=preg_replace($pattern,$replace,$testo);
	return $text;
}


/**Inserisce un div e crea l'intestazione del CSS
 * @param  $text
 * @param  $class
 * @param  $id
 */
function divme ($text="",$class="",$id="")
{
	
	$testo="<div class=\"$class\" id=\"$id\">";
	$testo.=$text;
	$testo.="</div>";
	return $testo;
}


function hypavex ($libro,$libro_id,$capitolo,$versetto)
{
	$text=<<<EOD
	<a href="l?l=$libro_id&c=$capitolo&v=$versetto">$libro $capitolo:$versetto</a>
EOD;
return $text;
}




/**Cerca un valore in un array multidimensionale
 * @param  $array
 * @param  $cosa
 * @param  $non ho ben capito...
 */
function recursiveArraySearch($haystack, $needle, $index = null)
{
    $aIt     = new RecursiveArrayIterator($haystack);
    $it    = new RecursiveIteratorIterator($aIt);
   
    while($it->valid())
    {       
        if (((isset($index) AND ($it->key() == $index)) OR (!isset($index))) AND ($it->current() == $needle)) {
            return $aIt->key();
        }
       
        $it->next();
    }
   
    return false;
}


function id_mesi($mese)
{
	$mesi[1]="Gennaio";
	$mesi[2]="Febbraio";
	$mesi[3]="Marzo";
	$mesi[4]="Aprile";
	$mesi[5]="Maggio";
	$mesi[6]="Giugno";
	$mesi[7]="Luglio";
	$mesi[8]="Agosto";
	$mesi[9]="Settembre";
	$mesi[10]="Ottobre";
	$mesi[11]="Novembre";
	$mesi[12]="Dicembre";

	$mese=ucfirst(strtolower($mese));
	return array_search($mese,$mesi);
}



//End








