<?php
include_once("../../util/top_foot_inc.php");
include_once("../../util/mysqlutil.php");
include_once("../../util/sphinxql.php");
//include_once("../../util/myhandler.php");

connetti();

$neu=$_GET['neu'];
$up=$_GET['up'];
$del=$_GET['del'];




if ($neu==1)
{

	$titolo=$_POST['titolo'];
	$oratore=$_POST['oratore'];
	$data=explode("/",$_POST['data']);
	$data2="$data[2]/$data[0]/$data[1]";
	$data=$data2;

	$categorie=$_POST['categorie'];

	$categorie=strstr($categorie,"*/");
	$categorie=substr($categorie,2);



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
`riassunto`,
`categorie`
)
VALUES (
'$titolo', '$oratore','$data', '$testo', '$rating', '','$riassunto','$categorie'
);";

	mysql_query($sql,$db);
	$id=last_id();



	$sql="insert into ita_discorsi_rt values ($id,'$titolo','$testo')";
	$res=mysql_query($sql,$sdb);




	//header("Content-Type: application/json");
	//echo '{"success":false,"error":"Errore sconosciuto"}';
	echo "{'success':true,'success':'Inserito con id -> $id'}";

}

if ($up==1)
{
	$id=$_POST['id'];
	$titolo=$_POST['titolo'];
	$oratore=$_POST['oratore'];
	$data=explode("/",$_POST['data']);
	$data2="$data[2]/$data[0]/$data[1]";
	$data=$data2;

	$testo=mysql_real_escape_string($_POST['testo']);
	$riassunto=mysql_real_escape_string($_POST['riassunto']);



	$rating=$_POST['rating'];


	$sql="REPLACE INTO `聖書`.`discorsi` (
`id_discorso`,
`titolo` ,
`oratore` ,
`data` ,
`testo` ,
`rating` ,
`allegato`,
`riassunto`
)
VALUES (
'$id','$titolo', '$oratore','$data', '$testo', '$rating', '','$riassunto'
);";

	mysql_query($sql,$db);


	$err=mysql_error($db);
	if ($err)
	{
		error_log($err.$sql);
	}




	$spql="replace into ita_discorsi_rt values ($id,'$titolo','$testo')";
	$res=mysql_query($spql,$sdb);




	//header("Content-Type: application/json");
	//echo '{"success":false,"error":"Errore sconosciuto"}';
	echo "{'success':true,'success':'Aggiornato id -> $id'}";


}


if ($del==1)
{

	$id=$_POST['id'];
	$sql= "delete from `聖書`.`discorsi` where id_discorso = $id";
	mysql_query($sql,$db);

	$spql= "delete from ita_discorsi_rt where id = $id";
	mysql_query($spql,$sdb);

	echo "{'success':true,'success':'Cancellato id -> $id'}";
}
//var_dump($GLOBALS);
//endtime();














?>