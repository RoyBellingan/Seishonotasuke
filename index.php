<?php
include_once ("util/top_foot_inc.php");
top2();


$html=<<<EOD
<div
	class="centrale"
	align="center"
>

<TABLE class="testo_18">
<th>
<td>
<br><br><br><br><br><br><br><br><br>
Il sito al momento è ancora in sviluppo, la versione attuale è la 0.13 beta, sono funzionanti solo la ricerca <br>
e il visualizzatore dei versetti/capitoli
<br><br>
Al lavoro su : <a href="http://roy.selfip.org:81/i?l=1&c=32">Interlineare</a>! 4%
<br><br><br>
<a href="c">Ricerca Libera</a> (in fase di sviluppo)
<br><br>
<a href="p">Concordanza Alfabetica</a> (decente dai)
<!--
<br><br>
<a href="i">Interlineare!</a> (1%)
-->
<br><br>
<a href="request">Richieste Varie</a> (quanto basta)
<br><br><br><br><br><br><br><br>
</td
</th>
<!--<tr><td><a href="parse.php">Parser!!!</a></td></tr>
	<tr><td><a href="loader.php">Loader!!!</a></td></tr>
		<tr><td><a href="gui.php">gui</a></td></tr>
		<tr><td><a href="prove">Prove</a></td></tr>
		<tr><td><a href="semantica">Semantica</a></td></tr>-->
		 

		
</TABLE>
</div>
EOD;

echo $html;

/*
$uriArr = explode('/',$_SERVER['REQUEST_URI']); 
dumpa($uriArr,1);
$article = $uriArr[1];
$article = urldecode($article); 
 */
//echo $article;

foot();

