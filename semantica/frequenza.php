<?php
die (" Non si lanciano gli script a mozzo!!!");
error_reporting (9);
/*
 * Compila una lista delle parole su una tabella
 *
 * {{LINGUA}}_frequenza
 * CREATE TABLE `聖書`.`italiano_frequenza` (
 * `id_parola` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
 * `parola` TINYTEXT NOT NULL ,
 * `frequenza` SMALLINT UNSIGNED NOT NULL ,
 * PRIMARY KEY ( `id_parola` )
 * ) ENGINE = MYISAM ;
 *
 *
 */

include_once ("../util/top_foot_inc.php");
top();
connetti();
$error=false;



$parola="zorobabele’";

$pattern = "/’$/";
$replacement = ' ';
$parola=preg_replace($pattern, $replacement, $parola);
echo $parola;





//Connetto e inizio a leggere i versetti, uno alla volta fino alla fine per ognuno lo prendo e lo spezzo
//nelle parole che lo costituiscono e compilo la relativa tabella.

$end=31103; //uno in più cosi non devo fare il controllo di uguaglianza !"!!!!11!1
//$end=300;
//$tabella="Русский";
$lingua="English";
$text=$lingua."_text";

$table=$lingua."_frequency";

$sql="TRUNCATE TABLE `$table`";
mysql_query($sql);

for ($i=0;$i<$end;$i++)
{
	$sql = "select $text from versetti where id_versetti=$i";
	$frok=mysql_query($sql);
	$err=mysql_error($db);
	if ($err)
	{
		echo "<br>$sql <br> $err<hr>";
		ob_flush();
	}

	$res=mysql_fetch_row($frok);
	$parola=$res[0];


	$parola=str_replace("&nbsp;"," ",$parola);
	$parola=str_replace("&nbsp"," ",$parola);

	$parola=str_replace("—"," ",$parola);

	$parola=str_replace("?"," ? ",$parola);
	$parola=str_replace("!"," ! ",$parola);
	$parola=str_replace(":"," ",$parola);
	$parola=str_replace(","," ",$parola);
	$parola=str_replace("."," ",$parola);
	$parola=str_replace("; "," ",$parola);
	$parola=str_replace("‘"," ",$parola);
	$parola=str_replace("’","’ ",$parola);
	$parola=str_replace("\n","’ ",$parola);
	$parola=str_replace("„","’ ",$parola);
	$parola=str_replace("»","’ ",$parola);
	$parola=str_replace("«","’ ",$parola);
	$parola=str_replace("; "," ",$parola);	/*$parola=str_replace("„","’ ",$parola);
	 $parola=str_replace("„","’ ",$parola);
	 */


	$parola=str_replace("”"," ",$parola);
	$parola=str_replace("“"," ",$parola);
	$parola=str_replace("["," ",$parola);
	$parola=str_replace("]"," ",$parola);
	$parola=str_replace("("," ",$parola);
	$parola=str_replace(")"," ",$parola);
	$parola=str_replace("-"," ",$parola);




	$ris=explode(" ",$parola);
	//dumpa($ris);

	foreach ($ris as $parola)
	{

		$pbak=$parola;

		
		$parola=strtolower($parola);




		//$parola=str_replace("’","",$parola);




		$pattern = "/’$/";
		$replacement = ' ';
		$parola=preg_replace($pattern, $replacement, $parola);
		
		$pattern = "/\;$/";
		$replacement = ' ';
		$parola=preg_replace($pattern, $replacement, $parola);



		if ($parola=="zorobabele")
		{
			echo $pbak;
		}

		/*$parola=str_replace("‘","",$parola);
		 $parola=str_replace("‘","",$parola);
		 $parola=str_replace("‘","",$parola);*/

		$parola=str_replace("; "," ",$parola);
		$parola=trim($parola);
		$sql="insert into $table (word, frequency) Values ('$parola',1) ON DUPLICATE key UPDATE frequency=frequency+1";
		$frok=mysql_query($sql);
		$err=mysql_error($db);
		if ($err)
		{
			echo "<br>$sql <br> $err<hr>";
			ob_flush();
		}
	}
}








foot();