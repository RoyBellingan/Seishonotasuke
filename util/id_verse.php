<?php
//Per fare dei cambiamenti una tantum alla struttura del db
/*
Passo la tabella spacer da libro ; capitolo ; verso a id_verso

*/

$db;
$db_host = 'localhost';
$db_user = '聖書';
$db_password = '聖書';
$db_name = '聖書';
	$db= new mysqli($db_host, $db_user, $db_password, $db_name);
	$sql='SET NAMES utf8';
	$db->query($sql);
	
$sql="select * from spacer";

$ar=qr($sql);
foreach ($ar as $row){


$in=verse_to_id($row[1],$row[2],$row[3]);
$en=verse_to_id($row[1],$row[2],$row[5]);

if ($en<$in){
$en=$in;
}



$sql="UPDATE `聖書`.`spacer` SET `id_verse_init` = '$in', `id_verse_end` = '$en' WHERE `spacer`.`id_spacer` =$row[0];";
$db->query($sql);
echo $sql."\n";

}


function verse_to_id($book, $chapter, $verse) {
	GLOBAL $pack;
	if ($pack == "") {
		$pack = unserialize(file_get_contents("../libri/pack"));
	}
	return $pack[$book][$chapter][$verse];
}

function id_to_verse($id) {
	GLOBAL $pack_r;
		if ($pack_r == "") {
		$pack_r = unserialize(file_get_contents("../libri/pack_r"));
	}
	return $pack_r[$id];
}

function qr($sql,$asso=MYSQLI_BOTH,$db=false){


	if ($db===false){
		GLOBAL $db;
	}

	$res=$db->query($sql);

	if ($db->error){
		echo "<br>\n $sql \n<br>".$db->error."\n<br>";
		$err=true;

		unset($db->error);

		return false;
	}else{
		$val=$res->fetch_all($asso);
		return $val;
	}
}