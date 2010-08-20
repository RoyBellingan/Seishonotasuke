<?php
//die ('Non si lanciano gli script a mozzo');
//include_once ("util/top_foot_inc.php");

include_once("util/top_foot_inc.php");

top();
$testo="@marco testo da cercare";
echo $testo;

$preg="/@\p{L}{1,}/";
	$pattern="/(\p{L}{3,})/u";
	$replace="<a $id href=\"$link\" $action>\\1</a>";
	$text=preg_replace($pattern,$replace,$testo);
	
	
$arr=preg_match_all($preg,$testo,$arr2);
dumpa (preg_last_error(),1);
dumpa($text,1);

dumpa($arr2);



foot();
?>
case $campo
	libro 
	