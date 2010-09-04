<?php
include_once ("util/top_foot_inc.php");
include ("includes/caching.php");
connetti();
$cache=new cache();
$cache->flush();
dumpa($cache,1);

top2();


$html=<<<EOD
<div
	class="centrale"
	align="center"
>

Cache Scaricata

EOD;

echo $html;

foot();
?>