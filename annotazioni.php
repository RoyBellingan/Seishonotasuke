<?php
include_once("util/top_foot_inc.php");


connetti();


$css=<<<EOD
	<link rel="stylesheet" type="text/css" href="./css/ext-all.css"/>
	<link rel="stylesheet" type="text/css" title="access"    href="./css/xtheme-access.css" />
	<link rel="stylesheet" type="text/css" href="./cssforms.css"/>
EOD;

$js=<<<EOD
	<script type="text/javascript" src="js/ext-base.js"></script>
	<script type="text/javascript" src="js/ext-all.js"></script>
	<script type="text/javascript" src="js/annotazioni.js"></script>
EOD;


top_text($css,$js);

echo "<div id=\"boxxoso\"></div>";


foot();