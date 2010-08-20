<?php

/**
 * @author roy
 *
 */
class wordinfo
{
	var $db; //il riferimento al database...
	var $select_dimension=49; //Numeri dei campi da caricare nel select
	var $select_view=9; //Numeri dei campi visibili
	var $lang; //Lingua che si usa a questo giro
	/**
	* @var Suffisso per la frequenza
	*/
	var $lang_frequency_suffix="";

	/**
	 * @var La parola da trovare
	 */
	var $word; //La parola per fare casino

	/**
	 * @var La parola trovata
	 */
	var $wordfound;

	/**
	 * @var Frequenza con cui compare la parola
	 */
	var $wordfreq;

	/**
	 * @var del javascript da includere, alla fine
	 */
	var $js;
	
	/**
	 * @var Pagina cui puntano i link
	 */
	var $page="p";
	
	/**
	 * @var Pagina e GET
	 */
	var $page_get="p?w";

	function wordinfo()
	{
		GLOBAl $db;
		$this->db=$db;
		$this->select_dimension=49;
		$this->select_view=9;
		//nothing, for now!
		return true;
	}

	/**
	 * @param Parola (opzionale)
	 */
	function word($word)
	{
		/**/
		
		$req=(isset($_REQUEST ["w"]) ? $_REQUEST ["w"] : " ");
		
		$word = (empty($word) ? $req : $word);
		
		$word = (empty($word) ? " " : $word);
		if ($this->lang=="English")
		{
			$word=htmlentities($word,ENT_COMPAT,"UTF-8");
		}
		
		$l=strstr(",",trim($word));
		$word=substr($word,$l);
		$word=str_ireplace("´","",$word);
		$word=str_ireplace("·","",$word);
		

		//TODO intercetta qui sintassi come @marco "cercami"
		
		$this->word=$word;
	}

	
	
	/**
	 *Interecetta espressioni come  @marco "cercami" e le converte in espressioni sphinx come
	 *@libro 41 @testo cercami
	 */
	function query_fiel()
	{
		//explode(" "$this->word;
		
	}

	/**
	 * Imposta la lingua per la ricerca
	 */
	function lang()
	{
		$lang = (empty($_COOKIE['lang'])) ? 'italiano' : $_COOKIE['lang'];
		$this->lang=$lang;
		$this->lang_frequency=$lang.$this->lang_frequency_suffix;
		
		

		$n="";
		$i=1;
		while (isset($_COOKIE['lang'.$n]))
		{
			$i++;
				
			$this->lang_a[$i][0]=$_COOKIE['lang'.$n];
			$this->lang_a[$i][1]=$_COOKIE['lang'.$n]."_frequency"; //Non sò a cosa serva però...
			$n=$i;
		}

	
	
	
	}

	function wordlang()
	{
		$this->lang();
		$this->word();
	}

	function queryword()
	{
		//Che ID ha la mia parola ???//
		$sql="select id_word, frequency, word from $this->lang_frequency where word >= '$this->word' LIMIT 1";
		$fs = mysql_query($sql,$this->db);
		$rs=mysql_fetch_row($fs);
		//dumpa ($rs);
		$err=mysql_error($this->db);
		if ($err)
		{
			echo "<br>$sql <br> $err<hr>";
		}

		$id=$rs[0];
		$feq=$rs[1];
		//echo "<span>$word con id = $id e freq di $feq<br>$sql<br></span>";
		if ($id<=25)
		{
		 $idn=0;
		 $pos=$id-1;
		}
		else
		{
		 $idn=$id-26;
		 $pos=25;
		}
		$this->wordfreq=$feq;
		$this->id=$id;
		$this->idn=$idn;
		$this->pos=$pos;
		$this->wordfound=$rs[2];
	}


	function selectalpha($dim)
	{
		$dim=floor(($dim ? $dim : $this->select_dimension));
		$sql="select * from (select word from $this->lang_frequency where id_word > $this->idn order by `id_word` ASC limit $dim) as t2 order by word ASC ";
		$this->fsalpha = mysql_queryconerror($sql,$this->db,false);

	}


	function echoalpha($dim)
	{
		$dim=floor((isset($dim) ? $dim : $this->select_view)/2)+1;


		$this->id_alpha_select="prova";
		$this->class_alpha_select="selector";


		while ($rs=mysql_fetch_row($this->fsalpha))
		{
			$parole_less[]=$rs[0];
		}

		$sl="<select size=\"$dim\" id=\"$this->id_alpha_select\" class=\"$this->class_alpha_select\" ONCLICK=\"location = this.options[this.selectedIndex].value;\" >";
		$sl=$sl.$this->selecta_sl($parole_less,$this->pos)."</select>";

		//dumpa ($parole_less,1);
		$int=<<<EOD
<div id="phs">
<div id="selector1">
EOD;
		//echo $int.$sl."</div>";
		echo $sl;

	}

	function divalpha ()
	{
		$int=<<<EOD
        <div id="alfabetico">
            A
            <br>
            l
            <br>
            f
            <br>
            a
            <br>
            b
            <br>
            e
            <br>
            t
            <br>
            i
            <br>
            c
            <br>
            o
        </div>
<div id="selector1">
EOD;
		echo $int;
		$this->echoalpha();
		echo "\n</div>";
	}

	function selectfeq($dim)
	{

		$dim=floor(($dim ? $dim/2 : $this->select_dimension));
		/************/
		/*
		 * Per orindare con le frequenze devo prima vedere 24 item prima che frequenza ci stà quindi un 
		 * select freq < $feqn limit 24,1
		 */
		//UNa unica non va bene perchè non sò quanti risultati ci sono in una sola...
		//$sql="(select word from ita_frequency where frequency = $feq and word <= '$word' order by word DESC limit 24) UNION (select word from ita_frequency where frequency = $feq and word > '$word' order by word ASC limit 24) order by word ASC";
		$sql="select word from (select word from $this->lang_frequency where frequency = $this->wordfreq and word <= '$this->wordfound' order by word DESC limit $dim)as t2 order by word ASC" ;
		$this->fsfreq = mysql_queryconerror($sql,$this->db,false);

		$sql="select word from (select word from $this->lang_frequency where frequency = $this->wordfreq and word > '$this->wordfound' order by word ASC limit $dim)as t2 order by word ASC" ;
		$this->fsfreq2 = mysql_queryconerror($sql,$this->db,false);
	}


	function echofreq ($dim)
	{

		$this->id_freq_select="prova2";
		$this->class_freq_select="selector";

		$dim=floor((isset($dim) ? $dim : $this->select_view)/2)+1;
		$i=0;
		while ($rs=mysql_fetch_row($this->fsfreq))
		{
			$parole_feq[]=$rs[0];
			$i++;
		}

		while ($rs=mysql_fetch_row($this->fsfreq2))
		{
			$parole_feq[]=$rs[0];
		}

		$i--;
		$sl="<select size=\"$dim\" id=\"$this->id_freq_select\"  class=\"$this->class_freq_select\" ONCHANGE=\"location = this.options[this.selectedIndex].value;\" >";
		$sl=$sl.$this->selecta_sl($parole_feq,$i)."</select>";
		$int=<<<EOD
<div id="selector2">
EOD;

		//echo $int.$sl."</div>"."</div>";
		echo $sl;


	}


	function divfreq ()
	{
		$int=<<<EOD
        <div id="frequenza">
            F
            <br>
            r
            <br>
            e
            <br>
            q
            <br>
            u
            <br>
            e
            <br>
            n
            <br>
            z
            <br>
            a
        </div>
<div id="selector2">
EOD;
		echo $int;
		$this->echofreq();
		echo "\n</div>";
	}


	function jsadd ($cosa)
	{
		$this->js.=$cosa;
	}

	function jsselect()
	{
		$cosa=<<<EOD
		<script type="text/javascript">
window.onload = function()
{
	document.getElementById('prova').size=9;
	document.getElementById('prova2').size=9;
}</script>
EOD;
		$this->jsadd($cosa);
	}

	function jsecho()
	{
		echo $this->js;
	}


	/**
	 *Scrive i select grezzi
	 */
	function echoaf()
	{
		$this->echoalpha();
		$this->echofreq();
	}


	/**
	 * Crea il DIV per la pAgina P
	 */
	function divafi()
	{
		echo "<div id=\"phs\">";
		$this->divcerca();
		$this->divalpha();
		$this->divfreq();	
		$this->divparola();
		echo "</div>";
	}


	function divcerca()
	{

		$int=<<<EOD
<form style="" margin: 0px; padding: 0px" action="$this->page" method="post" name="quest" id="quest">
<input id="cerca" name="w" type"text"><input name="submit" type="submit" value="Go"></form>
EOD;
            echo $int;
	}


	/**
	 * Si occupa di scrivere info sulla parola, vedi bug 17 -> http://susi/bugzilla/show_bug.cgi?id=17
	 */
	function divparola()
	{
		$this->infoparola();
		$word=ucfirst($this->wordfound);
		$int=<<<EOD
		<div id="infoparola">
            <h2 align="center">$word</h2>
            $this->infoparola_html
        </div>
EOD;
            echo $int;
	}


	/**
	 * 
	 */
	function infoparola()
	{

		$int=<<<EOD
		<li>Frequenza : $this->wordfreq</li>
		<br>
            Qui ci metto una descrizione breve, con link alla lunga
            <br>
            Traduzione nelle lingue scelte
            <br>
            vedi bug <a href="http://susi/bugzilla/show_bug.cgi?id=17">http://susi/bugzilla/show_bug.cgi?id=17</a><br>
            <a href="http://susi/WikiRoy/index.php/BibbiaDB/Bug/17">http://susi/WikiRoy/index.php/BibbiaDB/Bug/17</a>
            <br>
EOD;
       //echo $int;
       $this->infoparola_html=$int;

	}





/**
 * Crea il link al capitolo da cui è estratto il versetto
 * @param unknown_type $iss
 * @param unknown_type $num
 * @return string
 */
function selecta_sl($iss,$num=FALSE){
	$this->page_get;
	$i=0;
	$s="";
	foreach ($iss as $value) {
		if ($i==$num)
		{
			$s =$s."<option selected=\"selected\" value=\"$this->page_get=$value\" >$value</option>\n";
		}
		else
		{
			$s =$s."<option value=\"$this->page_get=$value\" >$value</option>\n";
		}
		$i++;
	}
	unset($value); // break the reference with the last element
	return $s;
}




















	//End CLasse!
}







?>
