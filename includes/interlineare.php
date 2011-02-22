<?php

class inter
{
	/**
	 * @var Classe dei versetti
	 */
	var $vv;

	/**
	 * @var Il database
	 */
	var $db;

	/**
	 * @var Che lingue
	 */
	var $lang;

	var $cache;






	/**
	 * Il costruttore
	 */
	function inter()
	{

	}

	/**
	 * Recupera le N lingue in cui fare l'interlineare
	 */
	function lang()
	{
		$n="";
		$i=0;
		while (isset($_COOKIE['lang'.$n]))
		{
			$i++;
				
			$this->lang[$i][0]=$_COOKIE['lang'.$n];
			$this->lang[$i][1]=$this->lang[$i][0]."_frequency"; //Non sò a cosa serva però...
			$n=$i;
		}

	}

	/**
	 * @param Array dei libri $libri
	 * @param Abbreviazione $libri_rsx
	 */
	function libram($libri,$libri_rsx)
	{
		$this->libram=$libri[$this->lang];
		if (isset($libri_rsx[$this->lang]))
		{
			$this->libram_rsx=$libri_rsx[$this->lang];
		}
	}


	/**
	 * Analizza le richieste che son state mandate 
	 */
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
	 * @param scrive ilcapitolo interlinearizzato
	 */
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

}