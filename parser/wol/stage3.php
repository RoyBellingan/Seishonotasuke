<!DOCTYPE html>
<html  lang="it">
<head>
<title>Genesi 1 &mdash; BIBLIOTECA ONLINE Watchtower</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style>
	
	b{
		font-size:22px;
	}
</style>
</head>
<body>
<textarea id="tt" cols="80" rows="8" style="overflow-y:scroll; "></textarea><br>

<?php

ini_set("display_errors", "1");
ERROR_REPORTING(E_ALL);
define("PATH", "../../");

include_once (PATH . "util/funkz.php");
include_once (PATH . "util/elenco_lib.php");
include_once (PATH . "includes/snoopy.php");
include_once (PATH . "util/mysqlutil.php");
include_once (PATH . "util/elenco_lib.php");

$db = new_mysqli();

$sql = "select id_versetti,italiano_text from versetti where id_versetti < 31 order by id_versetti ASC limit 30";

$vv = qr($sql, MYSQLI_NUM);

foreach ($vv as $key => $value) {

	$vv_text = $value[1];
	//echo $vv_text;
	$id_vv = $key + 1;
	$sql = "SELECT id_versetto,offset,cosa,text FROM `riferimenti` where id_versetto = $id_vv ORDER BY `riferimenti`.`id_versetto` ASC, offset DESC";
	//echo $sql;
	$rf = qr($sql, MYSQLI_NUM);
	//printa($rf);

	//$text=reposition();
	$w_pos = mb_strpos_all($vv_text, " ");
	$le = sizeof($w_pos);
	$w_pos[$le] = mb_strlen($vv_text);
	//$w_pos = array_reverse($w_pos);
	//printa($w_pos);

	$mk = 0;
	foreach ($rf as $rf_key => $rf_value) {

		if ($rf_value[2] == "margine") {
			$row = unserialize($rf_value[3]);
			$rep = "+";
			$rrr = "";
			//printa($row);
			
			foreach ($row as $r_key => $r_value) {
				$init=$r_value[0];
				$end=$r_value[1];
				$init_t=id_to_verse($r_value[0]);
				$end_t=id_to_verse($r_value[1]);
				
				 
				//printa($init_t);
				if ($init==$end){
					$init_tt="{$libr["italiano"][$init_t[0]]} $init_t[1]:$init_t[2]";
					$sql="select italiano_text from versetti where id_versetti = $init limit 1";
					$res=qx($sql);
					
					//printa($res);
					$rrr.="$init_tt \n$res\n";
				}else{
					
				}
			}
		} else {
			$rrr = $rf_value[3];
			$rep = "#";
		}

		//printa($row);

		$bla = $w_pos[$rf_value[1]];

		$stra = mb_substr($vv_text, 0, $bla);
		$strb = mb_substr($vv_text, $bla);

		$text = rawurlencode(trim($rrr));

		$html = <<<EOD
<span onmouseover="document.getElementById('tt').innerHTML=decodeURIComponent('$text')"><b>$rep</b></span>
EOD;
		$vv_text = $stra . $html . $strb;

		//die();
	}
	echo "<h3>$id_vv</h3>".$vv_text . "<br>\n";

}
