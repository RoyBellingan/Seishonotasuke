<?php 
include ('../util/mysqlutil.php');
connetti();
header("Content-Type: text/css");

if(isset($_REQUEST['user'])) 
{
	  $get=$_REQUEST['user'];
	  if ($get=="Dario")
{

	$sql="select config from usercss where id_user=1";
	$fs=mysql_queryconerror($sql,$db);
	$rs=mysql_fetch_row($fs);

	$arr=explode("\n",$rs[0]);   //Faccio array riga per riga
	$le=sizeof($arr);
	$findme="=";
	foreach ($arr as $riga)
	{
	$riga=explode($findme,$riga);
	//var_dump($riga);
	$text.="$riga[0]{\n$riga[1]\n}\n";
	}

echo $text;
}
}


?>