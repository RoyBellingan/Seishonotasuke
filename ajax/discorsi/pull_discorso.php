<?php
include_once("../../util/top_foot_inc.php");
include_once("../../util/mysqlutil.php");
include_once("../../util/myhandler.php");
include_once("../../util/sphinxql.php");

connetti();

/*
 *
 {name: 'id', type: 'int'},
 {name: 'data', type: 'date', dateFormat: 'd/m/Y'},
 {name: 'argomento'},
 {name: 'oratore',},
 {name: 'testo'}
 */
if ($_POST['command']=="qq"){

	$id=$_POST['id'];
	if ($id){ //Una ricerca con un ID specifico vince sempre e riporta SOLTANTO quell'id', supporta cose come > e  range 110 - 150
		//TODO documentalo che non è solo singola chiave...

		$id=str_replace(" ","",$id);//falcia gli spazi

		//cerco se è un  range
		if (strpos($id, '-'))
		{
			//error_log("un -");
			/*
			* Da 12 - 13 porta a
			*
			*/
			$init=strstr($id, '-',true); // 12
			$end=substr(strstr($id, '-'),1);//    strstr (- 13) -> substr 13
			//error_log("$init e $end");
			//in questo caso niente handler,
			$sql="select id_discorso,titolo,oratore,data,testo,rating,riassunto from discorsi where id_discorso >= $init and id_discorso <= $end ";
			//error_log($sql);
			$res=mysql_query($sql,$db);
			while ($retval[]=mysql_fetch_array($res,MYSQL_NUM)){}
			array_pop($retval);

		}
		else
		{
			//Ok vado di handler

			$colonne[]="id_discorso"; //0
			$colonne[]="titolo";//1
			$colonne[]="oratore";//2
			$colonne[]="data";//3
			$colonne[]="testo";//4
			$colonne[]="rating";//5
			$colonne[]="riassunto";//6
			$hs=handler('discorsi',$colonne);

			//Ultimo controllo

			$op=substr($id,0,1);
			//error_log("un $op");
			if ($op=="<" || $op==">"){
				//error_log("un < o un >");
				$up=substr($id,1);
				$retval=hs_select($hs,1,$op,$up,15);
				//Metto un limite ai risultati con range...
			}
			else{
				//error_log("un =");
				$retval=hs_select($hs,1,"=",$id);
			}
		}

		foreach ($retval as $r){
			$array[]=array("id" =>$r[0], "data" => revdate($r[3],"-"), "titolo" =>  $r[1],"oratore" =>  $r[2],"testo2" =>  $r[4], "testo" =>  $r[4], "riassunto" =>  $r[6] );
		}
	}
	$asql="1 ";
	$flag=false; /* mi serve per sapere se cerco solo le parole o anche altre cose, in quel caso cambiano un pochino di cose....
	ovvero invece di avere i dati solo dalla query di mysql devo incrociare gli ID della query e di Sphinx e poi tramite handler
	prendere i dati
	TODO No non credo che con SphinxSE cambia nulla, ma valuta per bene la possibilità...
	*/

	$titolo=$_POST['title'];
	if ($titolo){
		error_log("titolo $titolo");
		$asql.="and titolo like '%$titolo%'";
		$flag=true;
	}
	$oratore=$_POST['oratore'];
	if ($oratore){
		$asql.="and oratore like '%$oratore%'";
		$flag=true;
	}
	//$titolo=$_POST['riassunto'];

	$data=$_POST['data'];
	$data2=$_POST['data2'];
	if ($data){
		if ($data2){
			$data2=revdate($data2);
			$asql.="and data between '$data' AND '$data2'";
			$flag=true;
		}
		else{
			$data=revdate($data);
			$asql.="and data = '$data'";
			$flag=true;
		}
		//TODO pare che sphinx supporti le date, se cosi fosse non sarebbe male provare  a fare la ricerca tutta da lui... ?
		//@title "bla bla" @oratore "bla bla" @testo "bla bla bla" ... ?
	}

	$parole=$_POST['parole'];
	if ($parole){
		error_log("parole $parole");

		$flog=true;

		$spql="select * from ita_discorsi_rt where match ('$parole')";
		$res=mysql_query($spql,$sdb);

		error_log($res);
		while ($tt1 = mysql_fetch_row($res)){
			//var_dump($res);
			//var_dump($tt1);
			$spid[]=$tt1[0];

		}
		error_log("un id a caso $tt1[0] + $spql");
	}

	if ($flag){//Almeno una richiesta SQL
		error_log("almeno una sql");
		if ($flog){//e una sphinx
			$colonne[]="id_discorso"; //0
			$colonne[]="titolo";//1
			$colonne[]="oratore";//2
			$colonne[]="data";//3
			$colonne[]="testo";//4
			$colonne[]="rating";//5
			$colonne[]="riassunto";//6
			$hs=handler('discorsi',$colonne);

			$sql = "select id_discorso from discorsi where $asql";
			$res=mysql_query($sql,$db);
			while ($tt1 = mysql_fetch_row($res)){
				$myid[]=$tt1[0];
			}

			//Incrocio gli id... ma come ???
			foreach ($myid as $id){
				$megabot[$id]=1;
			}
			foreach ($spid as $id){
				if ($megabot[$id]==1){
					$retval=hs_select($hs,1,'=',$id,1);
					foreach ($retval as $r){
						$array[]=array("id" =>$r[0], "data" => revdate($r[3],"-"), "titolo" =>  $r[1],"oratore" =>  $r[2],"testo2" =>  $r[4], "testo" =>  $r[4], "riassunto" =>  $r[6] );
					}
				}
			}
		}
		else{
			$sql = "select id_discorso,titolo,oratore,data,testo,rating,riassunto from discorsi where $asql";
			error_log($sql);

			$res=mysql_query($sql,$db);
			while ($retval[]=mysql_fetch_array($res,MYSQL_NUM)){}
			array_pop($retval);
			foreach ($retval as $r){
				$array[]=array("id" =>$r[0], "data" => revdate($r[3],"-"), "titolo" =>  $r[1],"oratore" =>  $r[2],"testo2" =>  $r[4], "testo" =>  $r[4], "riassunto" =>  $r[6] );
			}
		}
	}
	else{
		error_log("nessuna sql");
		//var_dump($spid);
		$colonne[]="id_discorso"; //0
		$colonne[]="titolo";//1
		$colonne[]="oratore";//2
		$colonne[]="data";//3
		$colonne[]="testo";//4
		$colonne[]="rating";//5
		$colonne[]="riassunto";//6
		$hs=handler('discorsi',$colonne);
		foreach ($spid as $id){
			$retval=hs_select($hs,1,'=',$id);
			foreach ($retval as $r){
				$array[]=array("id" =>$r[0], "data" => revdate($r[3],"-"), "titolo" =>  $r[1],"oratore" =>  $r[2],"testo2" =>  $r[4], "testo" =>  $r[4], "riassunto" =>  $r[6] );
			}
		}

	}

}
//$titolo=$_POST['categorie'];

//TODO Oratore dovrei mettere l'indice e la tabella di lookup ...

else{//Se non richiedo nulla di particolare...
	$colonne[]="id_discorso"; //0
	$colonne[]="titolo";//1
	$colonne[]="oratore";//2
	$colonne[]="data";//3
	$colonne[]="testo";//4
	$colonne[]="rating";//5
	$colonne[]="riassunto";//6
	$hs=handler('discorsi',$colonne);

	$retval=hs_select($hs,1,'<',50000000000,20);
	//Visualizzo le ultime 15 ...

	foreach ($retval as $r){
		$array[]=array("id" =>$r[0], "data" => revdate($r[3],"-"), "titolo" =>  $r[1],"oratore" =>  $r[2],"testo2" =>  $r[4], "testo" =>  $r[4], "riassunto" =>  $r[6] );
	}
}
//print_r($retval);
//Coverto in JSON

if (!$array)
{
	$array[]=array("id" =>$r[0], "data" => revdate($r[3],"-"), "titolo" =>  "Trovato Nada","oratore" =>  "-.-","testo2" =>  $r[4], "testo" =>  $r[4], "riassunto" =>  $r[6] );
}

echo json_encode($array);

function revdate($data,$dem="/"){
	$d=explode($dem,$data);
	$dd="$d[2]/$d[1]/$d[0]";
	return $dd;
}