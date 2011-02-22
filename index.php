<?php
include_once ("util/top_foot_inc.php");
top2();


$html=<<<EOD
<div 	class="centrale"	align="center" >

<TABLE class="testo_18">
<th>
<td>
<br><br><br><br><br>
Il sito al momento è ancora in sviluppo, la versione attuale è la 0.13 beta, sono funzionanti solo la bibbia e la interlineare
<br><br>

Al lavoro su : <a href="i.php?l=1&c=32">Interlineare</a>!<br>
(ma prima scegli in che <a href="lang.php">lingue</a> e ricorda di premere F5 per pulire la cache delle pagine) <br>

<br><br><br>
<!-- 
<a href="c.php">Ricerca Libera</a> (in fase di sviluppo)

<br><br>
<a href="p.php">Concordanza Alfabetica</a> (decente dai)


<br><br>
<a href="i.php">Interlineare!</a> (1%)
-->
<br><br>
<a href="request.php">Richieste Varie</a> (quanto basta)
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
?>
