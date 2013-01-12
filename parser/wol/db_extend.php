<?php
/** Un eccellino mi ha detto che il c++ non sà cosa farsene degli array del php...
 * Io gli credo...
 *
 * La sintassi per il c++ credo sia ok così:
 *
 * versetto_start,versetto_end-versetto_start,versetto_end-versetto_start,versetto_end
 *
 
 */
define("PATH", "../../");
include_once (PATH . "util/funkz.php");
include_once (PATH . "util/mysqlutil.php");
$db = new_mysqli();

for ($i = 1; $i < 72251; $i++) {
//	for ($i = 1; $i < 51; $i++) {
	$sql = "select cosa,ptext from riferimenti where id_riferimento = $i limit 1";
	$res = qrow($sql);
//printa($res);
	if ($res[0] == 1) {
		$txt=mysql_escape_string(trim($res[1]));
		$sql = "update riferimenti set ctext = '$txt' where id_riferimento = $i limit 1 ";
		qq($sql);
	} elseif ($res[0] == 2) {

		$res=unserialize($res[1]);
		$str = "";
		foreach ($res as $key => $value) {
			$str .= "$value[0],$value[1]-";
		}
		//tolgo la riga vuota
		$str = mysql_escape_string(trim(substr($str, 0,-1)));
		//echo $str;
		$sql = "update riferimenti set ctext = '$str' where id_riferimento = $i limit 1 ";
		qq($sql);
	}
}
