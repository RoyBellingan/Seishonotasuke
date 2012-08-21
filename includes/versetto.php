<?php

require_once ("./util/elenco_lib.php");

/**
 * @author roy
 *
 */
class trova_versetto
{


	var $libro;
	var $libro_id;
	var $capitolo;
	var $versetto;

	/**
	 * @var Se evidenziare il testo indicato, quindi carico tutto il capitolo e evidenzio quello
	 */
	var $evidenzia;

	/**
	 * @var Quanti cercarne
	 */
	var $estensione;

	/**
	 * @var Estensione di default di versetti da trovare
	 */
	var $estensione_def=1;

	/**
	 * @var Che ID sarebbe
	 */
	var $id_versetto;

	/**
	 * @var La lingua in questione
	 */
	var $lang;

	/**
	 * @var Che DB stò usando
	 */
	var $db;

	/**
	 * @var nome della colonna per il testo
	 */
	var $campo_text;
	/**
	 * @var Lista dei Libri
	 */
	var $libram;

	/**
	 * @var Lista delle abbreviazioni per i libri
	 */
	var $libram_rsx;

	/**
	 * @var Il testo del versetto in questione
	 */
	var $testo;

	/**
	 * @var Eventuale classe di appartenenza
	 */
	var $class_coord;

	/**
	 * @var Eventuale classe di appartenenza
	 */
	var $class_cit;

	/**
	 * @var Eventuale classe di appartenenza
	 */
	var $class_ver;

	/**
	 * @var Eventuale classe di appartenenza
	 */
	var $id_ver;

	/**
	 * @var Eventuale ID
	 */
	var $id_coord;

	/**
	 * @var Eventuale ID
	 */
	var $id_cit;

	/**
	 * @var Sintassi per incapsularlo
	 */
	var $html;

	/**
	 * @var Sintassi per incapsularlo
	 */
	var $class_p;

	/**
	 * @var Sintassi per incapsularlo
	 */
	var $id_p;

	/**
	 * @var verbose function ?
	 */
	var $echo_on;

	/**
	 * @var istanza della cache
	 */
	var $cache;

	/**
	 * @var testo estratto dai capitoli
	 */
	var $testo_cap;

	var $class_a_cap;

	var $id_a_cap;
	var $class_ver_sel;

	var $id_ver_sel;

	/**
	 * @var I delimitatori dei paragrafi nei capitoli
	 */
	var $spacer;

	/**
	 * @var Pagina su cui mandare i link
	 */
	var $page="p.php";

	/**Chiave del get per il link
	 * @var Chiave del get per il link
	 */
	var $getkey="w.php";

	/**
	 * Il Costruttore
	 */
	function trova_versetto()
	{
		GLOBAl $db,$libr,$libr_rsx;
		$this->db=$db;
		$this->lang();
		$this->libram($libr,$libr_rsx);
		$this->echo_on=false;
		//nothing, for now!
		return true;

	}

	/**
	 * @param Libro $l
	 * @param Capitolo $c
	 * @param Versetto $v
	 * @param Estensione $e
	 *
	 * Non posso fare l'overloading in php a quanto pare...
	 */
	function fetch_versetto($l,$c,$v,$e,$o,$check)
	{
		if ($o)
		{
			$this->evidenzia=TRUE;
		}

		if ($l && $c && $v && $e)
		{
			$this->versettoext($l,$c,$v,$e);
		}
		if ($l && $c && $v)
		{
			$this->versetto($l,$c,$v);
		}
		if ($l && $c)
		{
			$this->capitolo($l,$c);
		}
		if ($l)
		{
			//rimanda alla pagina per scegliere -.-
		}

	}


	/**
	 * Recupera Libro e Capitolo in cui è un certo id_versetto
	 * @param ID $id
	 * @param recupera il testo $t
	 *
	 * Non posso fare l'overloading in php a quanto pare...
	 */
	function fetch_versetto_id($id,$t=FALSE)
	{
		if ($t)
		{

			$sql="select libro,capitolo,versetto,$this->campo_text from versetti where id_versetti=$id Limit 1";
			$fs = mysql_query($sql,$this->db);
			$rs=mysql_fetch_row($fs);
			$this->id_versetto=$id;
			$this->libro_id=$rs[0];

			$this->id_to_lib();
			$this->capitolo=$rs[1];
			$this->versetto=$rs[2];
			$this->testo=$rs[3];
		}
		else
		{
			$sql="select libro,capitolo,versetto from versetti where id_versetti=$id Limit 1";
			$fs = mysql_query($sql,$this->db);
			$rs=mysql_fetch_row($fs);
			$this->id_versetto=$id;
			$this->libro_id=$rs[0];
			$this->id_to_lib();
			$this->capitolo=$rs[1];
			$this->versetto=$rs[2];
		}
	}


	/**
	 * @param Scrive una serie di ID (versetti) formattati $idx
	 * @param Scrive anche la coordinata Biblica $ext
	 */
	function form_verse_id($idx,$ext=false)
	{


		foreach ($idx as $id)
		{
			$idn=$id."cit".$this->lang;
			$text=$this->cache->select($idn);
			if ($text==False)
			{

				$this->fetch_versetto_id($id,1);

				$text="<div class=\"$this->class_p\" id=\"$this->id_p\">\n";
				if ($ext)
				{
					$text.="<div class=\"$this->class_coord\" id=\"$this->id_coord\">\n";
					$text.=$this->hypavex($this->libro,$this->libro_id,$this->capitolo,$this->versetto);
					$text.="</div>\n";
				}
				$text.="<div class=\"$this->class_cit\" id=\"$this->id_cit\">\n";
				$text.=$this->text_hype($this->testo);
				$text.="</div>\n";
				$text.="</div>\n";
				$this->cache->insert($idn,$text);

			}
			if ($this->echo_on)
			{
				echo $text;
			}
		}


	}


	/**Scrive il versetto con la formattazione per i capitoli
	 *
	 */
	function verse_int()
	{
		$i=0;
		foreach ($this->testo_cap[$this->libro_id][$this->capitolo] as $testo)
		{
			//echo "<br> $testo";
			$i++;
			if (isset($this->spacer[$this->libro_id][$this->capitolo][$i]))
			{
				if ($i==1)
				{
					$text="<p>\n";
				}
				else
				{
					$text.="</p>\n<p>\n";
				}
			}

			$text.="<span class=\"$this->class_a_cap\" id=\"$this->id_a_cap\">";
			$text.=$i;
			$text.="</span>\n";
			if ($i==$this->versetto) //Se è versetto selezionato
			{
				$text.="<span class=\"$this->class_ver_sel\" id=\"$this->id_ver_sel\">\n";
			}
			else
			{
				$text.="<span class=\"$this->class_ver\" id=\"$this->id_ver\">\n";
			}
			$text.=$this->text_hype($testo);
			$text.="</span>\n";

		}
		$text.="</p>\n";
		$this->testo_cap[1]=$text;
	}


	/**Scrive il versetto con la formattazione per i capitoli dell'interlingua
	 *
	 */
	function verse_inter()
	{
		$i=0;
		$le=sizeof($this->testo_cap[$this->lang][$this->libro_id][$this->capitolo])+1;

		//echo "<br>".$le;
		for ($l=1;$l<$le;$l++)
		{

			if (isset($this->spacer[$this->libro_id][$this->capitolo][$l]))
			{
				if ($i==1)
				{
					$text="<p>\n";
				}
				else
				{
					$text.="</p>\n<p>\n";
				}
			}
			$text.="<div class=\"cpp\">";
			$text.="<div class=\"$this->class_a_cap\" id=\"$this->id_a_cap\">";
			$text.=$l;
			$text.="</div>\n";
			$cc=0;
			foreach ($this->lang_a as $lang)
			{
				$cc++;
				$ver_sel=$this->class_ver_sel.$cc;
				//$this->id_ver_sel.$cc;
				$ver=$this->class_ver.$cc;
				//$this->id_ver.$cc;
				$this->lang=$lang[0];


				if ($l==$this->versetto) //Se è versetto selezionato
				{
					$text.="<span class=\"$ver_sel\">\n";
				}
				else
				{
					$text.="<span class=\"$ver\">\n";
				}
				$text.=$this->text_hype($this->testo_cap[$this->lang][$this->libro_id][$this->capitolo][$l]);
				$text.="</span>\n";

				//echo $this->testo_cap[$this->lang][$this->libro_id][$this->capitolo][$l]."<br>";
			}
			$text.="<div style=\"clear:both;\"></div>";
			$text.="</div>\n";
			//	echo "$l";
		}
		$text.="</p>\n <div style=\"clear: both\"></div>";
		$this->testo_cap[1]=$text;




		//		foreach ($this->testo_cap[$this->lang][$this->libro_id][$this->capitolo] as $testo)
		//		{
		//			$i++;
		//			if (isset($this->spacer[$this->libro_id][$this->capitolo][$i]))
		//			{
		//				if ($i==1)
		//				{
		//					$text="<p>\n";
		//				}
		//				else
		//				{
		//					$text.="</p>\n<p>\n";
		//				}
		//			}
		//
		//			$text.="<span class=\"$this->class_a_cap\" id=\"$this->id_a_cap\">";
		//			$text.=$i;
		//			$text.="</span>\n";
		//			if ($i==$this->versetto) //Se è versetto selezionato
		//			{
		//				$text.="<span class=\"$this->class_ver_sel\" id=\"$this->id_ver_sel\">\n";
		//			}
		//			else
		//			{
		//				$text.="<span class=\"$this->class_ver\" id=\"$this->id_ver\">\n";
		//			}
		//			$text.=text_hype($testo);
		//			$text.="</span>\n";
		//
		//		}
		//		$text.="</p>\n";
		//		$this->testo_cap[1]=$text;

	}

	function libram($libri,$libri_rsx)
	{
		$this->libram=$libri[$this->lang];
		$this->libram_rsx=$libri_rsx[$this->lang];
	}

	function versetto($l,$c,$v,$e)
	{
		if ($this->evidenzia)
		{

		}
		else
		{

		}

	}

	function lang()
	{
		$lang = (empty($_COOKIE['lang'])) ? 'italiano' : $_COOKIE['lang'];
		$this->lang=$lang;
		$this->lang_frequency=$lang."_frequency";
		$this->campo_text=$lang."_text";


		$i=1;
		while (isset($_COOKIE['lang'.$i]))
		{


			$this->lang_a[$i][0]=$_COOKIE['lang'.$i];
			//$this->lang_a[$i][1]=$this->lang[$i][0]."_frequency"; //Non sò a cosa serva però...
			$i++;
		}


	}

	function request()
	{


		if (isset($_REQUEST['lib']))
		{//Ovvero ho passato un GET da valutare
			$lib=ucfirst(strtolower($_REQUEST['lib']));
			$lib=trim($lib);
			$lib=explode(" ",$lib);
			//dumpa ($lib,1);
			if (is_numeric ($lib[0]))
			{
				//Se mando un numero (sintassi ridotta del codice) convertilo nel libro relativo
				$this->libro=$this->libram[$lib[0]];
				$this->libro_id=$lib[0];
			}

			else
			{
				//Se invece è una stringa faccio l'iverso per accedere al db...
				//Potrei usare una sintassi abbreviata però!
				$this->libfetch($lib[0]);
				//$this->libro=$lib[0];
				//$this->libro_id=array_search($lib[0],$this->libram);
			}



			if (is_numeric ($lib[1]))
			{//Se passo un solo capitolo (Matteo 5)
				$this->capitolo=$lib[1];
			}
			else
			{
				$liba=explode(":",$lib[1]);
				$this->capitolo=$liba[0];
				$this->versetto=$liba[1];

				$fv=true;
			}

			if (is_numeric ($lib[2]) && (!$fv))
			{//Se non è passato il versetto allora è nella forma matteo 23 34 (senza il :
				$this->versetto=$lib[2];
			}
			else
			{//Allora è nella forma matteo 23:34 12 (versetti in evidenza)
				$this->evidenzia=$lib[2];
			}

			if (is_numeric ($lib[3]))
			{//Allora è nella forma matteo 23 34 12 (versetti in evidenza e senza il :)
				$this->evidenzia=$lib[3];

			}
		}
		else
		{
			//echo "niente GET";
			//Sempre Numerico lo passo
			$this->libro=$this->libram[$_REQUEST['l']] ;
			$this->libro_id=$_REQUEST['l'];
			$this->capitolo=(isset($_REQUEST['c']) ? $_REQUEST['c'] : 1);
			$this->versetto=(isset($_REQUEST['v']) ? $_REQUEST['v'] : "");
			$this->estensione= (isset($_REQUEST['e']) ? $_REQUEST['e'] : 1);
		}

	}

	/**
	 * @param Cerca se è un abbreviazione
	 */
	function libfetch ($lib)
	{
		$this->libro_id=array_search($lib,$this->libram);
		if ($this->libro_id>0)
		{//Ok il libro era nella forma "normale"
			$this->libro=$lib;
		}
		else
		{
			$i=0;
			foreach ($this->libram_rsx as $libram)
			{
				$i++;
				//dumpa ($libram);

				$k=array_search($lib,$libram);
				//dumpa ($k);

				if (!($k===FALSE))
				{
					$this->libro_id=$i;
					$this->libro=$this->libram[$this->libro_id];
					break;
				}

			}
		}
	}

	/**
	 * Converte dall'ID del libro al libro che lo contiene
	 */
	function id_to_lib()
	{
		$this->libro=$this->libram[$this->libro_id];
	}


	/**Carica un capitolo, se passo un id di un versetto, si ricava il capitolo contenente, altrimenti usa quello in $this->capitolo
	 * Evidenzia il versetto in $id, altrimenti usa $this->versetto (se presente) e se $this->evidenzia=true
	 * @param il versetto $id
	 */

	function fetch_cap()
	{

		if ($this->fetch_capitolo()==-1)
		{
			$this->cap_h1();
			$this->testo_cap[1]="Peccato non esiste...";
		}
		else
		{
			$this->fetch_spacer();

			$this->class_a_cap="cpp";
			$this->class_ver_sel="sel";
			$this->class_ver="ver";
			$this->page="l.php";
			$this->cap_h1();
			$this->verse_int();
		}

	}

	function cap_h1()
	{

		$text=$this->hypavex2("<",$this->libro_id,$this->capitolo-1)." ";

		$text.=$this->hyper_title($this->libro);
		$text.=" ".$this->capitolo;
		$text.=" ".$this->hypavex2(" >",$this->libro_id,$this->capitolo+1);

		$this->testo_cap[0]=$text;
	}

	function hyper_title()
	{

		$text="<a href=\"l.php?l=$this->libro_id\" rel=\"l2.php?l=$this->libro_id\" class=\"jtip\" >$this->libro</a>";
		return $text;
	}

	function get_cap($id=false)
	{
		//dumpa($this,1);
		if ($id)
		{
			$this->fetch_versetto_id($id);

		}

		//		$cac="capitolo_ita_".$this->libroid."_".$this->capitolo."_".$this->versetto;
		$cac="capitolo_ita_".$this->libro_id."+c_".$this->capitolo.$this->versetto;
		$cac_c=$this->cache->select($cac);
		if ($cac_c!=False)
		{

			echo $cac_c;
		}
		else
		{

			$this->fetch_cap();
			$t=divme($this->testo_cap[0],"capitolo_h1");
			$t.=divme($this->testo_cap[1],"capitolo");
			$this->cache->insert($cac,$t);
			echo $t;
		}
	}

	function fetch_capitolo()
	{
		$sql="select $this->campo_text from versetti where libro='$this->libro_id' and capitolo=$this->capitolo ORDER by id_versetti";
		$fs = mysql_queryconerror($sql,$this->db);
		$i=0;
		while ($rs=mysql_fetch_row($fs))
		{
			$i++;
			$this->testo_cap[$this->libro_id][$this->capitolo][$i]=$rs[0];
		}
		//dumpa ($this->testo_cap[$this->libro_id][$this->capitolo],1);
		if ($i==0) //se nn ha trovato nessuna riga!
		{
			return -1; //non esiste...
		}
	}


	function fetch_spacer()
	{

		$sql="select versetto,end from spacer where libro='$this->libro_id' and capitolo=$this->capitolo ORDER by id_spacer";
		$fs = mysql_queryconerror($sql,$this->db);
		$i=0;
		while ($rs=mysql_fetch_row($fs))
		{
			$i++;

			$this->spacer[$this->libro_id][$this->capitolo][$rs[0]]=true;
			$tmp=$rs[1];
		}
		$this->spacer[$this->libro_id][$this->capitolo][$tmp]=true;

	}



	function text_hype ($testo)
	{
		$link="$this->page?$this->getkey=\\1";
		$link="p.php?w=\\1";

		$action="";
		//$id="id=\"\\1\"";
		$id="";
		$pattern="/(\p{L}{3,})/u";
		$replace="<a $id href=\"$link\" $action>\\1</a>";
		$text=preg_replace($pattern,$replace,$testo);
		return $text;
	}


	function hypavex ($libro,$libro_id,$capitolo,$versetto)
	{
		$text=<<<EOD
	<a href="l.php?l=$libro_id&c=$capitolo&v=$versetto">$libro $capitolo:$versetto</a>
EOD;
		return $text;
	}


	function hypavex2 ($testo,$libro_id,$capitolo,$versetto)
	{
		$page=$this->page;
		$page="l.php";
		$text=<<<EOD

	<a href="$page?l=$libro_id&c=$capitolo&v=$versetto">$testo</a>
EOD;
		return $text;
	}



	function get_inter_cap($id=false)
	{
		//dumpa($this,1);
		if ($id)
		{//Recupera la coordinata Biblica
			$this->fetch_versetto_id($id);

		}


		/*
		 *
		 * Leggi il primo capitolo e poi while l'altro lingua
		 */


		$cac="capitolo_inter_".$this->libro_id."+c_".$this->capitolo.$this->versetto;
		$cac_c=$this->cache->select($cac);
		$cac_c=False;
		if ($cac_c!=False)
		{

			echo $cac_c;
		}
		else
		{

			$this->lang_a[0][0]=$this->lang;
			ksort($this->lang_a);

			$i=0;
			foreach ($this->lang_a as $lang)
			{
				$this->lang=$lang[0];
				$this->lang_update();
				$this->fetch_raw_cap();
			}
			$this->fetch_spacer();

			$this->class_a_cap="ver_inter_c";
			$this->class_ver_sel="sel_inter";
			$this->class_ver="ver_inter";
			$this->page="i";
			$this->cap_h1(); //Creo l'header per sopra

			$this->verse_inter();


			$t=divme($this->testo_cap[0],"capitolo_h1");
			$t.=divme($this->testo_cap[1],"capitolo_inter");
			//$this->cache->insert($cac,$t);
			echo $t;



			//$this->fetch_cap();
			//$t=divme($this->testo_cap[0],"capitolo_h1");
			//$t.=divme($this->testo_cap[1],"capitolo");
			//$this->cache->insert($cac,$t);
			//}
		}
	}

	function fetch_raw_cap()
	{
		$sql="select $this->campo_text from versetti where libro='$this->libro_id' and capitolo=$this->capitolo ORDER by id_versetti";
		$fs = mysql_queryconerror($sql,$this->db);
		$i=0;
		while ($rs=mysql_fetch_row($fs))
		{
			$i++;
			$this->testo_cap[$this->lang][$this->libro_id][$this->capitolo][$i]=$rs[0];
		}
		if ($i==0) //se nn ha trovato nessuna riga!
		{
			return -1; //non esiste...
		}
	}


	function lang_update()
	{
		$this->campo_text=$this->lang."_text";
	}

	//Fien della classe
}
