<?php

//Ok connettiamoci!

$db;
$db_host = 'localhost';
$db_user = '聖書';
$db_password = '聖書';
$db_name = '聖書';


function connetti ()
{

	GLOBAL $db_host, $db_password, $db_user, $db, $db_name;

	$db = mysql_connect($db_host, $db_user, $db_password); //PERSISTEBT CONNECTION!!!
	mysql_select_db($db_name);
	if ($db == FALSE)
	die ("Errore nella connessione. Verificare i parametri nel file mysqlutil.php");
	mysql_set_charset("utf8_unicode_ci",$db);
	//echo mysql_client_encoding($db);

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

	echo ($verbose ? "$sql" : "");
	$fs = mysql_query($sql,$db);
	//dumpa ($rs);
	$err=mysql_error($db);
	if ($err)
	{
		echo "<br>$sql <br> $err<hr>";
	}
	return $fs;
}












?>
