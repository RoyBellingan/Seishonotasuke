<?php

die("non si lanciano a mozzo le cose...");


define('ABSPATH', dirname(__FILE__).'/');

include_once (ABSPATH."//util/elenco_lib.php");
include_once (ABSPATH."/util/top_foot_inc.php");


//Ricorda di mettere i nomi dei libri nella lingua giusta...

top();

//www.watchtower.org/i/bibbia/toc.htm
$error=false;
$counter=0;




//$libro="Esodo";
//$libro_a="ex";
dumpa($libram,1);
$dimex=count($libram)+1;
$lingua="Español"; //Lingua che ci si appresta a scaricare
$lang="s";  //Abbreviazione
$bib="biblia"; //Nome della Bibbia usato nel sito web
echo $dime;

echo (mkdir("libri/$lang") ? "cartella creata" : "Warn nessuna cartella verifica che non esista gia !!!!") ;


for ($jj=1; $jj<$dimex; $jj++)
{
	$libro="libri/$lang/".$libr["$lingua"][$jj];
	$libro_a=$libram[$jj];
	echo "<h2> Now Parsing $libro in $lingua</h2>";

	$fp = fopen("$libro", 'w');
	echo $fp;
	$error=false;
	$counter=0;
	while ($error==false)
	{
		$counter++;
		if ($counter <10)
		{$number="00".$counter;}
		elseif ($counter==10 || $counter <100)
		{$number="0".$counter;}
		else
		{$number=$counter;}
		$url="http://watchtower.org/$lang/$bib/".$libro_a."/chapter_".$number.".htm";
		echo $url;

		$cod=$testo[$libro][$counter]=file_get_contents($url);
		//echo $cod;
		$dime=strlen($cod);

		if ($dime==0)
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

	}



}


foot();


?>
";
