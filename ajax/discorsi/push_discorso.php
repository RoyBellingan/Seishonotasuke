<?php
include_once("../../util/top_foot_inc.php");
include_once("../../util/mysqlutil.php");
//include_once("../../util/myhandler.php");

connetti();


$titolo=$_POST['titolo'];
$oratore=$_POST['oratore'];
$data=explode("/",$_POST['data']);
$data2="$data[2]/$data[0]/$data[1]";
$data=$data2;

$testo=mysql_real_escape_string($_POST['testo']);
$riassunto=mysql_real_escape_string($_POST['riassunto']);



$rating=$_POST['rating'];


$sql="INSERT INTO `聖書`.`discorsi` (
`titolo` ,
`oratore` ,
`data` ,
`testo` ,
`rating` ,
`allegato`,
`riassunto`
)
VALUES (
'$titolo', '$oratore','$data', '$testo', '$rating', '','$riassunto'
);";

mysql_query($sql);
$id=last_id();

//header("Content-Type: application/json");
//echo '{"success":false,"error":"Errore sconosciuto"}';
echo "{'success':true,'success':'Inserito con id -> $id'}";




//endtime();

?>