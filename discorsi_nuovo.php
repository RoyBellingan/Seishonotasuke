<?php
include_once("util/top_foot_inc.php");


//connetti();


$css=<<<EOD
	<link rel="stylesheet" type="text/css" title="access"    href="./css/ext4-all-access.css" />
EOD;

$js=<<<EOD
	<script type="text/javascript" src="js/ext4-all.js"></script>
	<script type="text/javascript" src="js/discorsi_nuovo.js"></script>
EOD;


top_text($css,$js);

echo "<br><br><br><br><br><div id=\"boxxoso\"></div>";
echo "<br><br><br><br><br><div id=\"tre\"></div>";


foot();