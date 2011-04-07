<?php
include_once ("util/top_foot_inc.php");
include_once ("util/elenco_lib.php");
include_once ("includes/versetto.php");
include_once ("includes/caching.php");

connetti();
top2();


$cc=new trova_versetto();
$cache=new cache();
$cc->cache=$cache;
$cc->db=$db;



$cc->lang();
$cc->libram($libr,$libr_rsx); //Carica i riferimenti dei libri


$cc->request();

$cc->get_inter_cap();

//dumpa($cc,1);

foot();
?>