<?php 
define('ABSPATH', dirname(__FILE__).'/');


include_once (ABSPATH."/util/top_foot_inc.php");

//include_once ("elenco_lib.php");
top2();



$lang=$_POST['lang'];
$lang1=$_POST['lang1'];
echo $lang." + ".$lang1;
setcookie ("lang", $lang, "0", "/");
setcookie ("lang1", $lang1, "0", "/");


foot();?>