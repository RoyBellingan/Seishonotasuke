<?php
/*
 * Draft di come dovrebbe all'incirca venire a livello logico la cosa...
 *

 */

include_once ("util/top_foot_inc.php");
//include_once ("elenco_lib.php");
top2();

//Leggo un capitolo e tutti i versetti in esso e creo i link

connetti();

$memcache = new Memcache;
$memcache->connect('localhost', 11211);
$testo=$memcache->get("Genesi");

foot();
 $sql="select text from cache where `key` = 'Genesi' ";
 $fs = mysql_query($sql);
 $rs=mysql_fetch_row($fs);
 //dumpa ($rs);
 $err=mysql_error($db);
 if ($err)
 {
 	echo "<br>$sql <br> $err<hr>";
 }
 foot();
 $testo=$rs[0];

// $testo="";
//$testo=$rs[0];
foot();
if (!$testo)
{

	$sql="select ita_text from versetti where libro = 1 and capitolo = 1 order by versetto asc";
	$frok = mysql_query($sql);
	$testo="";
	$raw="";
	$i=0;
	$pattern="/\p{L}+/";
	while ($row[$i]=mysql_fetch_row($frok))
	{
		$tex=$tex.$row[$i][0];
		$i++;
		//dumpa ($riga);
	}

	//preg_match_all($pattern,$tex,$parole);

	//dumpa ($parole,1);

	$i=0;
	//	foreach ($parole[0] as $parola)
	//	{
	//		$i++;
	//		$siz=strlen($parola);
	//		if ($siz>2)
	//		{
	//			$sql="select id_word from ita_frequency where word = '$parola'";
	//			//echo "$sql";
	//			$fs = mysql_query($sql);
	//			$rs=mysql_fetch_row($fs);
	//			//dumpa ($rs);
	//			$err=mysql_error($db);
	//			if ($err)
	//			{
	//				echo "<br>$sqlb <br> $err<hr>";
	//			}
	//			$id=$rs[0];
	//			//echo "<br> $id";
	//			$gank["$parola"]=$id;
	//
	//		}
	//	}

	//dumpa ($gank);

	$i=0;




	//<a href="nulla.html" onmouseover="alert(this.id)" id="ciao">del testo insulso</a>

	$link="c?w=\\1";
	$action="";
	//$id="id=\"\\1\"";
	$id="";
	$pattern="/(\p{L}{3,})/u";
	$replace="<a $id href=\"$link\" $action>\\1</a>";
	$testo="<div>";
	foreach ($row as $riga)
	{
	    
	    if ($j==15)
	    {
	        $html="\n</div><div>";
	        $testo=html_add($html,$testo);
	        $j=0;
	       }
		$i++;
		$j++;
		$html="\n<h3>$i</h3>";


		$testo=html_add($html,$testo);
		$html="\n$riga[0]";


		//$pattern2 = "/(\PZ)’/";
		//$replacement2 = "\\1'";
		//$html=preg_replace($pattern2, $replacement2, $html);

		$html=preg_replace($pattern,$replace,$html);

		$testo=html_add($html,$testo);

	}
	echo $testo;
	//INSERT INTO `聖書`.`cache` (`key`,`text`) VALUES ('Genesi', 'item')
	$memcache->set ('Genesi',$testo);
	$testo2=$testo;
	//dumpa ($testo2);
	$sql="Replace into cache (`key`,`text`) values ('Genesi','$testo2')";
	$fs = mysql_query($sql);
	$err=mysql_error($db);
	if ($err)
	{
		echo "<br>$sql <br> $err<hr>";
	}


	//dumpa($raw);
}
else
{
	echo $testo;
}


foot();