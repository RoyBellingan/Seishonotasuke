<?php
/*
 * Draft di come dovrebbe all'incirca venire a livello logico la cosa...
 *


 */
//TODO Meti un header che dice in termini umani dove ci si trova plz ?

include_once ("util/top_foot_inc.php");
include_once ("util/elenco_lib.php");
include_once ("includes/versetto.php");
include_once ("includes/caching.php");
connetti();
top2();

$v= new trova_versetto();
$cache=new cache();
$v->cache=$cache;

$v->lang();
$v->libram($libr,$libr_rsx); //Carica i riferimenti dei libri

$v->request();
$v->db=$db;


if ($chk=="CHECKED")
{
	$v->page="i";
	$v->get_inter_cap();

}
else
{
	$v->page="l";
	$v->evidenzia=True;

	$v->get_cap();
}
	//dumpa($v,1);
	//dumpa($GLOBALS);
	foot();

