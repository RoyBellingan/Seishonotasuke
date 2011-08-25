<?php
//Handler Socket here, no time waste plz
$hshost = 'localhost';
$hsport = 9998;
$hsport_wr = 9999;
$hsdbname = '聖書';
//$table = 'Persone';

/*
 $hs = new HandlerSocket($host, $port);
 if (!($hs->openIndex(1, $dbname, $table, HandlerSocket::PRIMARY, 'Nome,Cognome')))
 {
 echo $hs->getError(), PHP_EOL;
 die();
 }
 */


/**
 * @param tabella $table
 * @param colonne $colonne
 */
function handler($table,$colonne)
{
	$col="";
	foreach ($colonne as $colonna)
	{
		$col.="$colonna,";
	}
	$col=substr($col,0,-1); //$rest = substr("abcdef", 0, -1);  // returns "abcde" // In questo caso mozzo l'ultima virgola

	//echo $col;


	GLOBAL $hshost, $hsport, $hsport_wr, $hsdbname;
	$hs = new HandlerSocket($hshost, $hsport);
	//print_r($hs);
	if (!($hs->openIndex(1, $hsdbname, $table, HandlerSocket::PRIMARY, $col)))
	{
		echo $hs->getError(), PHP_EOL;
		die();
	}
	return $hs;
}

/**
 * @param handler socket $hs
 * @param indece da usare $index
 * @param operatore matematico $operation
 * @param numero riga $val
 * @param quanti campi $lenght
 * @param offset $offset
 */
function hs_select ($hs,$index=1,$operation="=",$val,$lenght=1,$offset=0){
	$size=sizeof($val);

	if ($size==1){
		$retval = $hs->executeSingle($index, $operation, array($val), $lenght, $offset);
	}
	else{
		$multi="";
		foreach ($val as $row){
			$multi[]=array($index, $operation, array($row), $lenght, $offset);
		}
		$retval = $hs->executeMulti($multi);
	}
	return $retval;
}


/*
 $colonne[]="id_versetti";
 $colonne[]="italiano_text";
 $colonne[]="español_text";
 $colonne[]="日本語_text";


 $hs=handler('versetti',$colonne);



 $righe[]=34;
 $righe[]=45;


 for ($i=0; $i<=30; $i++)
 {
 $righe[]=rand(10,30000);
 }


 //$retval=select($hs,1,'=',34);
 $retval=hs_select($hs,1,'=',$righe);

 echo "<pre>";
 print_r($retval);
 echo "</pre>";
 */

class handler{
	//statici
	var $host = 'localhost';
	var $port = 9998;
	var $port_wr = 9999;
	var $dbname = '聖書';


	function handler($table,$column){
		//Instanzia un hs per una tabella specifica simile alla funzione
		$col="";
		foreach ($colonne as $colonna)
		{
			$col.="$colonna,";
		}
		$col=substr($col,0,-1); //$rest = substr("abcdef", 0, -1);  // returns "abcde" // In questo caso mozzo l'ultima virgola

		//echo $col;



		$this->hs = new HandlerSocket($hshost, $hsport);
		//print_r($hs);
		if (!($hs->openIndex(1, $hsdbname, $table, HandlerSocket::PRIMARY, $col)))
		{
			echo $hs->getError(), PHP_EOL;
			die();
		}
		return $hs;
	}

}


?>