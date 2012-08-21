<?php
/*
 * Deve essere in ajax, io metto nome o parte del cognome e lui mi tira fuori una lista a lato con N elementi
 * http://af-design.com/blog/2010/05/12/using-jquery-uis-autocomplete-to-populate-a-form/
 * http://www.nodstrum.com/2007/09/19/autocompleter/ + http://res.nodstrum.com/autoComplete/
 *
 * e compila il campo nascosto id_persona
 *
 */
class visite
{
	/**
	 * @var Nome dell'interessato
	 */
	var $nome;

	/**
	 * @var Cognome dell'interessato
	 */
	var $cognome;

	/**
	 * @var Il database
	 */
	var $db;

	/**
	 * @var Che lingue
	 */
	var $lang;

	//eventuale cache
	var $cache;

	/**
	 * Il costruttore, non fa nulla
	 */
	function visite(){return 1;}


	function get_param()
	{
		$flag=0; //Falg se sono stati mandati dei dati ?

		if (isset($_REQUEST['ins'])) //Ho inserito un form
		{//Ovvero voglio inserire una visita effettuata
			echo"si";

			//switch "$_REQUEST['ins']"
			/*
			* case "persona"
			* case "visita"
			* case "interesse"
			* case "dialogo"
			*/

			$this->nuova_visita();
			$flag=1;
		}
		if (isset($_REQUEST['ck'])) //Ho inserito un form di ricerca
		{//Ovvero voglio cercare delle visite
			$this->cerca_visite();
			$flag=1;
		}

		if ($flag==0) // Se non ho passato nessun parametro o form
		{
			$this->echo_form();
		}
	}

	function nuova_visita()
	{

		if (isset($_REQUEST['data']))
		{
			if ($_REQUEST['data']==false)
			{
				$this->data=time();
			}
			else
			{
				$dd=explode("/",$_REQUEST['data']);
				$data=mktime(0, 0, 0, $dd[1], $dd[0], $dd[2]);
				$this->data=$data;
			}
		}
		else
		{
			$this->data=time();
		}




		if (isset($_REQUEST['nome']))
		$this->nome=$_REQUEST['nome'];

		if (isset($_REQUEST['cognome']))
		$this->cognome=$_REQUEST['cognome'];

		if (isset($_REQUEST['via']))
		$this->via=$_REQUEST['via'];

		if (isset($_REQUEST['numero']))
		$this->numero=$_REQUEST['numero'];

		if (isset($_REQUEST['territorio']))
		$this->territorio=$_REQUEST['territorio'];

		if (isset($_REQUEST['lat']))
		$this->lat=$_REQUEST['lat'];

		if (isset($_REQUEST['lon']))
		$this->lon=$_REQUEST['lon'];

		if (isset($_REQUEST['lingua']))
		$this->lingua=$_REQUEST['lingua'];

		if (isset($_REQUEST['note_persona']))
		$this->note_persona=$_REQUEST['note_persona'];

		if (isset($_REQUEST['età']))
		$this->età=$_REQUEST['età'];

		if (isset($_REQUEST['argomento']))
		$this->argomento=$_REQUEST['argomento'];

		if (isset($_REQUEST['con']))
		$this->con=$_REQUEST['con'];

		if (isset($_REQUEST['note_visita']))
		$this->note_visita=$_REQUEST['note_visita'];

		if (isset($_REQUEST['materiale']))
		$this->materiale=$_REQUEST['materiale'];




		if (isset($_REQUEST['id_persona']) && $_REQUEST['id_persona']!=""){
			echo "id > {$_REQUEST['id_persona']}";
			$this->id_persona=$_REQUEST['id_persona'];
		}
		else{
			echo "<br>inz";
			$this->inserisci_coord();
			$this->inserisci_persona();
		}


		$this->inserisci_visita();
		dumpa($this);







	}

	function inserisci_coord()
	{
		//echo "inserisco le coordinate";
		$sql = "INSERT INTO `聖書`.`gps` (`id_territorio`, `lat`, `lon`) VALUES ('$this->territorio', '$this->lat', '$this->lon');";
		mysql_queryconerror($sql,$this->db,1);
		$this->id_coord=mysql_insert_id($this->db);
	}



	function inserisci_persona()
	{
		$sql = "INSERT INTO `聖書`.`persone` (`name`, `surname`, `via`, `numero`, `id_gps`, `annotazioni`, `lingua`,`età`)	VALUES ('$this->nome', '$this->cognome', '$this->via', '$this->numero', '$this->id_coord', '$this->note_persona', '$this->lingua', '$this->età');";
		mysql_queryconerror($sql,$this->db);
		$this->id_persona=mysql_insert_id($this->db);
	}



	function inserisci_visita()
	{
		$sql = "INSERT INTO `聖書`.`visite` (`id_persone`, `data`, `argomento`, `con`, `note`, `materiale`)	VALUES ('$this->id_persona', '$this->data', '$this->argomento', '$this->con', '$this->note_visita', '$this->materiale');";
		mysql_queryconerror($sql,$this->db);
		$this->id_visita=mysql_insert_id($this->db);
	}


	function echo_form()
	{
		$html=<<<EOD
<FORM action="visite.php" method="POST" id="form_visite">
<div id="persona">

ID <br> <INPUT type="text" name="id_persona" id="id_persona"><br>
Nome <br> <INPUT type="text" name="nome" id="nome"><br>
Cognome<br> <INPUT type="text" name="cognome" id="cognome"><br>
Età<br> <INPUT type="text" name="età" id="età"><br>
Note (brevi)<br> <textarea  name="note_brevi" id="note_brevi"  rows="5" cols="44" ></textarea><br>
</div>

<div id="info">
Via <br><INPUT type="text" name="via"><br>
Numero <br><INPUT type="text" name="numero"><br>
Territorio <br><INPUT type="text" name="territorio"><br>
Lat <br><INPUT type="text" name="lat"><br>
Lon <br><INPUT type="text" name="lon"><br>
Lingua <br><INPUT type="text" name="lingua"><br>
Note (persona) <br><textarea name="note_persona" rows="5" cols="44"></textarea><br>
</div>
<div id="visita">
Data (gg/mm/aaaa)<br><INPUT type="text" name="data"><br>
Con chi  <br><INPUT type="text" name="con"><br>
Argomento <br><INPUT type="text" name="argomento"><br>
Note (visita) <br><INPUT type="text" name="note_visita"><br>
Materiale <br><INPUT type="text" name="materiale"><br>
</div>
<div id="clear"></div>
<INPUT type="submit" name="ins">
</FORM>

				<script type="text/javascript">

$(document).ready(function(){
	var ac_config = {
		source: "ajax/versetti.php?c=c",
		select: function(event, ui){
			$("#nome").val(ui.item.nome);
			$("#cognome").val(ui.item.cognome);
			$("#id_persona").val(ui.item.id_persona);
		},
		minLength:1
	};

		var ac_config2 = {
		source: "ajax/versetti.php?c=n",
		select: function(event, ui){
			$("#nome").val(ui.item.nome);
			$("#cognome").val(ui.item.cognome);
			$("#id_persona").val(ui.item.id_persona);
		},
		minLength:1
	};

		var ac_config_id = {
		source: "ajax/versetti.php?c=i",
		select: function(event, ui){
			$("#nome").val(ui.item.nome);
			$("#cognome").val(ui.item.cognome);
			$("#id_persona").val(ui.item.id_persona);
		},
		minLength:1
	};


	$("#id_persona").autocomplete(ac_config_id);
	$("#nome").autocomplete(ac_config2);
	$("#cognome").autocomplete(ac_config);
});





	//document.getElementById('nome').value='size';

</script>

EOD;
		echo $html;



	}










	//Fine della classeh
}

?>