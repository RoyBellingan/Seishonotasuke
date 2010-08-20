<?php
//die (" Non si lanciano gli script a mozzo!!!");
//error_reporting (9);
/*
 * Compila una lista delle parole su una tabella
 *
 *aggiungendo la lunghezza delle parole
 *
 */

include_once ("../util/top_foot_inc.php");
top();
connetti();
$error=false;



//$tabella="Русский";
$lingua="italiano";
$text=$lingua."_text";

$table=$lingua;





$sql = "SELECT COUNT(*) FROM `$table`";
$frok=mysql_query($sql);
$row=mysql_fetch_array($frok);

echo "Ben $row[0] parole trovate...";

	$sql = "UPDATE `聖書`.`$table` SET `length` =  '1' WHERE `$table`.`word` IS NULL";
	$frok=mysql_query($sql);
	$err=mysql_error($db);
	if ($err)
	{
		echo "<br>$sql <br> $err<hr>";
	}




$i=0;
$siz=1;
while ($siz>0)

//for ($i=0;$i<50;$i++)
{
	
	$x=str_repeat("_", $i);
	echo $x;
	$sql = "UPDATE `聖書`.`$table` SET `length` =  '$i' WHERE `$table`.`word` LIKE '$x'";
	$frok=mysql_query($sql);
	
	
	$err=mysql_error($db);
	if ($err)
	{
		echo "<br>$sql <br> $err<hr>";
	}
	
	$sql="select count(*) from $table where length = 0";
	$frok=mysql_query($sql);
	$row=mysql_fetch_array($frok);
	$siz=$row[0];
	$err=mysql_error($db);
	if ($err)
	{
		echo "<br>$sql <br> $err<hr>";
	}
	$i++;
}