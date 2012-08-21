<?php

die("non si lanciano a mozzo le cose...");

ini_set("display_errors","1");
ERROR_REPORTING(E_ALL);

define('ABSPATH', dirname(__FILE__).'/');

include_once ("../../util/funkz.php");
include_once ("../../util/elenco_lib.php");



$error=false;

$counter=0;



//Percorso Base:

// http://	wol.jw.org	/it	/wol	/b	/r6		/lp-i	/20		/23
// vabbè	sito		lingua	serve	bo	versione?	cosa	sottopagina	sottopagina2
$lingua="italiano"; //Lingua che ci si appresta a scaricare
$lang="it";  //Abbreviazione

echo "mi apresto a Scaricare la bibbia in $lingua";
//printa($libr["$lingua"]);



//echo (mkdir("libri/$lang") ? "cartella creata" : die("Warn nessuna cartella verifca che non esista gia !!!!")) ;



//I libri sono 66, nota il simbolo di inferiore e pensa prima di chiedere!

//TODO e se lo fai che si possa parallelizzare coi pthreads ^_^
/* Ti metto un primer... un fork per ogni pagina è chiedere troppo ? 
 * No dai poi pare che stiamo cercando di zergare il server... diciamo 4 processi paralleli ci possono bastare...
 //Chiudi TUTTO quello che è sharato 
 $pid = pcntl_fork();

  //Ora riaprili	

		if ($pid == -1) {
			exo("could not fork");
			$this -> reason = "could not fork";
			return false;

		} else if ($pid) {
			//Papà
			$posixProcessID = posix_getpid();
			exo("fork fatto! pid $pid, io sono l PADRE $posixProcessID");
			//Diamo un leggero vantaggio al download iniziale...

			//sleep(2);

			return true;

		} else {
			//Figghio
 */ 
 
for ($jj=41; $jj<67; $jj++)
{
	$bite=0;
	$libro="libri/$lang/".$libr["$lingua"][$jj];
	$libro_a=$libram[$jj];
	echo "<h2> Now Parsing $libro in $lingua</h2>";

	$fp = fopen("$libro", 'w');
	//echo $fp;
	$error=false;
	$counter=0;
	while ($error==false)
	{
		$counter++;
		/*
		if ($counter <10)
		{$number="00".$counter;}
		elseif ($counter==10 || $counter <100)
		{$number="0".$counter;}
		else
		{$number=$counter;}
		*/
		$url="http://wol.jw.org/$lang/wol/b/r6/lp-i/$jj/$counter";
		//http://watchtower.org/$lang/$bib/".$libro_a."/chapter_".$number.".htm";
		echo $url;
		exb();

		//TODO metti un controllo se non riesce ad aprire lo stream...
		$cod=$testo[$libro][$counter]=file_get_contents($url);
		
		//echo $cod;
		exb();
		//die();
		$dime=strlen($cod);

		if ($dime<8000) //Se è una pagina di errore //Un capitolo "corto" è sui 14K di caratteri invece..
		{
			echo "<br>Libro Finito<br>";
			$error=true	;
			$cod="<libro_end>";
			$len = fwrite($fp,$cod);
			$bite+=$len;
		}
		else
		{
			$cod="<capitolo_$counter>".$cod."</capitolo_$counter>\n";
			$len = fwrite($fp,$cod);
			$bite+=$len;
		}
		echo "\n<br>wrote $bite bytes to $libro.testo-raw<br><br>";
		exb();
	}



}


//foot();


?>