<?php

//Ok connettiamoci!
/*
$db;
$db_host = 'localhost';
$db_user = 'archidea_seisho';
$db_password = '-Q~P7e%7T,M+';
$db_name = 'archidea_seisho';
*/
$db;
$db_host = 'localhost';
$db_user = '聖書';
$db_password = '聖書';
$db_name = '聖書';

/**Connettiti, soliti campi richiesti e se passi un true ti dice in modo esplicito come è andata
 * @param bool $val
 */
function connetti ($host,$user,$pass,$name,$val=false)
{

	GLOBAL $db_host, $db_password, $db_user, $db, $db_name;

	if ($_SERVER['SERVER_NAME']=="roy.selfip.org"){
		$db;
		$db_host = 'localhost';
		$db_user = '聖書';
		$db_password = '聖書';
		$db_name = '聖書';
	}
	$db = mysql_pconnect($db_host, $db_user, $db_password); //PERSISTENT CONNECTION!!!
	mysql_select_db($db_name);
	if ($db == FALSE)
	die ("Errore nella connessione. Verificare i parametri nel file mysqlutil.php");

	mysql_set_charset("utf8_unicode_ci",$db);
	//echo mysql_client_encoding($db);
	$sql='SET NAMES utf8';
	$fs=mysql_query($sql,$db);
	if ($val)
	{
		dumpa($db,1);
	}


}
/**
 * Serve per farsi dare la lista degli enum in un campo di mysql
 *
 * @param sarebbe la tabella a cui chiedere "lumi"
 * @param nelle tabelle ci sono i campi
 * @param alcuni le gradiscono in ordine...
 * @return un array con gli enum...
 */
function getEnumVals($table,$field,$sorted=true)
{
	echo "ciao Krotalo!";
	$result=mysql_query('show columns from '.$table.';');
	while($tuple=mysql_fetch_assoc($result))
	{
		if($tuple['Field'] == $field)
		{
			$types=$tuple['Type'];
			$beginStr=strpos($types,"(")+1;
			$endStr=strpos($types,")");
			$types=substr($types,$beginStr,$endStr-$beginStr);
			$types=str_replace("'","",$types);
			$types=split(',',$types);
			if($sorted)
			sort($types);
			break;
		}
	}
	return($types);
}


/**
 * Mi RITORNA un drop down con gli enum di un campo di una tabella mysql
 *
 *@param Il nome del form
 *@param La tabella da cui prelevare
 *@param Il campo con cui compilare
 *@return Il drop down
 */
function mysql_form1 ($nomeF,$table,$field)
{
	$t = mysql_query("DESCRIBE $table $field");
	$s = mysql_fetch_row($t);

	ereg("\((.*)\)", stripslashes($s[1]), $t);

	$s = str_replace("','", "</option>
<option>", $t[1]);
	$s = "<select name=\"$nomeF\" size=\"3\" onChange='change_Modello$table(this.value)'>
	<option>Scegliere Prego</option>
	<option>" .
	substr($s, 1, strlen($s) - 2) . "</option></select>";
	return $s;
}

/**
 * Mi crea un drop down con gli enum di un campo di una tabella mysql
 *
 *@param Il nome del form
 *@param La tabella da cui prelevare
 *@param Il campo con cui compilare
 *@return Il drop down
 */
function mysql_form1_P ($nomeF,$table,$field)
{
	$t = mysql_query("DESCRIBE $table $field");
	$s = mysql_fetch_row($t);

	ereg("\((.*)\)", stripslashes($s[1]), $t);

	$s = str_replace("','", "</option>
<option>", $t[1]);
	$s = "<select name=\"$nomeF\" size=\"3\" onChange='change_Modello$table(this.value)'>
	<option>Scegliere Prego</option>
	<option>" .
	substr($s, 1, strlen($s) - 2) . "</option></select>";
	print $s;
}


/**
 * Mi crea un drop down con i valori contenuti in un campo di una tabella mysql
 *
 *@param Il nome del form
 *@param La tabella da cui prelevare
 *@param Il campo con cui compilare
 *@return Il Drop Down
 */
function mysql_form2_P ($nomeF,$table,$field)
{
	$query = "SELECT id,$field,Nome FROM $table ORDER BY $field ";
	$result = mysql_query($query);

	echo "<select name=\"$nomeF\" onchange=\"document.form1.NCT.checked=false\"'>
	<option>Scegliere Prego</option>";

	while ($row = mysql_fetch_array($result)){
		echo "<option value=\"$row[$field] $row[Nome]\">$row[$field] $row[Nome]</option>";}
		echo "</select>";
}

/**
 * Mi crea una serie di option con i valori in un campo con Where
 *
 *@param Il nome della tabella
 *@param Il campo da cui prelevare
 *@param Il campo del Where
 *@param Il valore del Where
 *@return Il Drop Down
 */
function mysql_opti ($table,$field,$field2,$dove)
{
	$query = "SELECT id,$field FROM $table WHERE $field2='$dove'";
	//echo $query;
	$result = mysql_query($query);


	while ($row = mysql_fetch_array($result)){
		echo "<option value=\"$row[$field]\">$row[$field]</option>";}
}


function db_info()
{
	Global $db;


	$frok=mysql_query("SHOW STATUS",$db);

	echo "<pre>";
	while ($row=mysql_fetch_array($frok))
	{
		dumpa ($row);
	}

}

/**
 * @param Id univoco $id
 * Visualizza l'id inserito
 */
function show_id($id)
{
	Global $db;

	$sql="select italiano_text from versetti where id_versetti=$id";
	$frok=mysql_query($sql,$db);
	$row=mysql_fetch_array($frok);
	$err=mysql_error($db);
	if ($err)
	{
		echo "<br>$sql <br> $err<hr>";
	}
	echo $row[0];
}

/**
 * @param Id univoco $id
 * Ritorna il testo dell'id scelto
 */
function get_id($id)
{
	Global $db;

	$sql="select italiano_text from versetti where id_versetti=$id";
	$frok=mysql_query($sql,$db);
	$row=mysql_fetch_array($frok);
	$err=mysql_error($db);
	if ($err)
	{
		echo "<br>$sql <br> $err<hr>";
	}
	return $row[0];
}


/**
 * @param Id univoco $id
 * Ritorna in che versetto stà
 */
function get_vers($id)
{
	Global $db;

	$sql="select libro,capitolo,versetto from versetti where id_versetti=$id";
	$frok=mysql_query($sql,$db);
	$row=mysql_fetch_array($frok);
	$err=mysql_error($db);
	if ($err)
	{
		echo "<br>$sql <br> $err<hr>";
	}
	$res[1]=$row[0];
	$res[2]=$row[1];
	$res[3]=$row[2];
	$res[0]="$row[0] $row[1]:$row[2]";
	return $res;
}



/**
 * Ritorna l'ultimo ID inserito
 */
function last_id()
{
	Global $db;

	$frok=mysql_query("SELECT LAST_INSERT_ID( )",$db);

	$row=mysql_fetch_array($frok);

	return $row[0];
}


/**
 * Stampa sempre l'errore
 * @param La query $sql
 * @param DB da usare $db
 * @param se vero stampa la query $verbose
 * @return resource
 */
function mysql_queryconerror ($sql,$db,$verbose=FALSE)
{

	echo ($verbose ? "$sql<br>" : "");
	$fs = mysql_query($sql,$db);
	//dumpa ($rs);
	$err=mysql_error($db);
	if ($err)
	{
		echo "<br>$sql <br> $err<hr>";
	}
	return $fs;
}


/** Usata di solito per le stored procedure, che ne posso avere solo una alla volta attiva
 */  
function new_mysqli(){
	GLOBAL $db_host,$db_user,$db_password,$db_name;
	$dbi= new mysqli($db_host, $db_user, $db_password, $db_name);
	return $dbi;
}




/**Fa la query e mi ritorna l'errore
 * @param unknown_type $sql
* @param unknown_type $db
*/
function qq($sql,$db=false){

	//echo $sql."<br>";
	if ($db===false){
		GLOBAL $db;
	}

	$res=$db->query($sql);


	if ($db->error){
		echo "\n<br> \n<br>".$db->error."\n<br>";
		$err=true;

		unset($db->error);

		$res= false;
	}
	return $res;
}


/**Fa la query di inserimento e mi ritorna l'errore o l'id di inserimento
 * @param unknown_type $sql
* @param unknown_type $db
*/
function qi($sql,$db=false){

	//echo $sql."<br>";
	if ($db===false){
		GLOBAL $db;
	}

	$res=$db->query($sql);


	if ($db->error){
		echo "\n<br> \n<br>".$db->error."\n<br>";
		echo $sql;
		$err=true;

		unset($db->error);

		return false;
	}
	//print_r($db);
	return $db->insert_id;
}




/**Fai la query e dai i risultati
 * RICORDA!
 * ANCHE se richiedi un solo valore è sempre un ARRAY!!!
 * se vuoi l'array "normale" chiama invece la funziona qr_proper($sql)
 *
 * @param query $sql
* #param defaul MYSQLI_NUM oppure MYSQLI_ASSOC e MYSQLI_BOTH
* @param un db fra tanti... oppure legge l'unico $db
*/
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



/**
 Fai la query e dai i risultati
* RICORDA! usa una singola colonna!!!!
* ritorna questo
    [0] => 31.7.176.2
    [1] => 31.7.176.3
    [2] => 31.7.176.4
    [3] => 31.7.176.5
    [4] => 31.7.176.6

    invece che il


    (
    [0] => Array
        (
            [0] => 31.7.176.2
        )

    [1] => Array
        (
            [0] => 31.7.176.3
        )

    [2] => Array
        (
            [0] => 31.7.176.4
        )

    [3] => Array
        (
            [0] => 31.7.176.5
        )

    [4] => Array
        (
            [0] => 31.7.176.6


* @param query $sql
* #param defaul MYSQLI_NUM oppure MYSQLI_ASSOC e MYSQLI_BOTH
* @param un db fra tanti... oppure legge l'unico $db
*/
function qr_proper($sql,$asso=MYSQLI_BOTH,$db=false){


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


		$b=array();
		foreach ($val as $value) {
			$b[]=$value[0];
		}
		return $b;

	}
}

/**Fai la query e dai il primo risultato
 * @param query $sql
* @param un db fra tanti... $db
*/
function qx($sql,$db=false){


	if ($db===false){
		GLOBAL $db;
	}

	$res=$db->query($sql);

	if ($db->error){
		echo "<br>\n<br> $sql \n<br>".$db->error."\n<br>";
		$err=true;

		unset($db->error);

		return false;
	}else{
		$val=$res->fetch_row();
		return $val[0];
	}
}

/**Fai la query e dai la prima riga
 * @param query $sql
* @param un db fra tanti... $db
*/
function qrow($sql,$asso=MYSQLI_BOTH,$db=false){


	if ($db===false){
		GLOBAL $db;
	}

	$res=$db->query($sql);

	if ($db->error){
		echo "<br>\n<br> $sql \n<br>".$db->error."\n<br>";
		$err=true;

		unset($db->error);

		return false;
	}else{
		$val=$res->fetch_all($asso);

			$b=$val[0];
		return $b;

	}
}

/**Fai una query di modifica (update o delete) e mi dice quante righe ha fatto
 * @param query $sql
* @param un db fra tanti... $db
*/
function qmod($sql,$asso=MYSQLI_BOTH,$db=false){


	if ($db===false){
		GLOBAL $db;
	}

	$res=$db->query($sql);

	if ($db->error){
		echo "<br>\n<br> $sql \n<br>".$db->error."\n<br>";
		$err=true;

		unset($db->error);

		return false;
	}else{
		$val=$res->affected_rows;

		return $val;

	}
}

/**Chiude la connessione
 * utile per quando uso i forkkkk
 */
function qclose(){
	GLOBAL $db;
	$db->close();
}







?>
