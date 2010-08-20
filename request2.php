<?php 
include_once("util/top_foot_inc.php");

//include ("includes/caching.php");
//include ("includes/versetto.php");
top();


$data=<<<EOD
<br><br><br><br>
<div class="testo_18" style="position:static;margin:auto;width:450px;" >
EOD;
echo $data;

$data=addslashes(trim($_POST['omg']));
$ip=$_SERVER["REMOTE_ADDR"];
$sql = "INSERT INTO `聖書`.`request` (`testo`,`ip`) VALUES ('$data','$ip');";
mysql_queryconerror($sql,$db);
$rif=last_id();

echo "Richiesta inserita con riferimento $rif <br> Grazie della collaborazione </div> <br><br><br><br>";

foot();
?>