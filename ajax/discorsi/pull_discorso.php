<?php
include_once("../../util/top_foot_inc.php");
include_once("../../util/mysqlutil.php");
include_once("../../util/myhandler.php");

connetti();

		    	/*
		    	 *
		    	 {name: 'id', type: 'int'},
		    	{name: 'data', type: 'date', dateFormat: 'd/m/Y'},
		    	{name: 'argomento'},
		    	{name: 'oratore',},
		    	{name: 'testo'}
		    	*/

$rq = (isset($_GET['rq']) ? $_GET['rq'] : false);

//Se non ricevo "get strani" nella richiesta mando soltanto gli ultimi N discorsi, altrimenti cerco come si deve, sphinx, ecc
if (!$rq){
	$colonne[]="id_discorso"; //0
	$colonne[]="titolo";//1
	$colonne[]="oratore";//2
	$colonne[]="data";//3
	$colonne[]="testo";//4
	$colonne[]="rating";//5
	$colonne[]="riassunto";//6
	$hs=handler('discorsi',$colonne);

	$retval=select($hs,1,'<',50000000000,15);
/*
	echo "<pre>";
	print_r($retval);
	echo "</pre>";
*/
}


//Coverto in JSON
foreach ($retval as $r){
	$array[]=array("id" =>$r[0], "data" => revdate($r[3],"-"), "argomento" =>  $r[1],"oratore" =>  $r[2],"testo2" =>  $r[4], "testo" =>  $r[4], "riassunto" =>  $r[6] );
}


echo json_encode($array);


function revdate($data,$dem="/"){
	$d=explode($dem,$data);
	$dd="$d[2]/$d[1]/$d[0]";
	return $dd;
}