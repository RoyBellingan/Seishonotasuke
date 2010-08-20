<?php
/*
 * Draft di come dovrebbe all'incirca venire a livello logico la cosa...
 *
 *
 */
include_once ("util/top_foot_inc.php");

$addizionali=4;

$lang = (empty($_COOKIE['lang'])) ? 'italiano' : $_COOKIE['lang'];

//$lang="ita";
$lang_frequency=$lang."_frequency";

echo "$lang";





include_once ("util/top_foot_inc.php");
//dumpa ($GLOBALS,1);
//include_once ("elenco_lib.php");
top2();
connetti();
$word=$_GET['w'];
$word=htmlentities($word,ENT_COMPAT,"UTF-8");

$sql="select id_word, frequency from $lang_frequency where word >= '$word'";
$fs = mysql_query($sql);
$rs=mysql_fetch_row($fs);
//dumpa ($rs);
$err=mysql_error($db);
if ($err)
{
	echo "<br>$sql <br> $err<hr>";
}
$id=$rs[0];
$feq=$rs[1];
echo "<span>$word con id = $id e freq di $feq<br>$sql<br></span>";





//  $parole_less="";
// $parole_over="";
// $sql="select * from (select word from ita_frequency where id_word > $id order by `id_word` ASC limit $addizionali) as t2 order by word ASC ";
//  $fs = mysql_query($sql);
//
// //dumpa ($rs);
// $err=mysql_error($db);
// if ($err)
// {
// 	echo "<br>$sql <br> $err<hr>";
// }
//
//  while ($rs=mysql_fetch_row($fs))
//  {
//  	$parole_over[]=$rs[0];
//  }
//
//  $sql="select * from (select word from ita_frequency where id_word < $id order by `id_word` DESC limit $addizionali) as t2 order by word ASC ";
//  $fs = mysql_query($sql);
//
// //dumpa ($rs);
// $err=mysql_error($db);
// if ($err)
// {
// 	echo "<br>$sql <br> $err<hr>";
// }
//
//
//  while ($rs=mysql_fetch_row($fs))
//  {
//  	$parole_less[]=$rs[0];
//  }

if ($id<=25)
{
$idn=1;
$pos=$id-2;
}
else
{
$idn=$id-25;	
$pos=24;
}

$sql="select * from (select word from $lang_frequency where id_word > $idn order by `id_word` ASC limit 51) as t2 order by word ASC ";
$fs = mysql_query($sql);

//dumpa ($rs);
$err=mysql_error($db);
if ($err)
{
	echo "<br>$sql <br> $err<hr>";
}

$i=0;
while ($rs=mysql_fetch_row($fs))
{

	$parole_less[]=$rs[0];
	if ($i==$pos )
	{
	//$parole_less[] ="Id parola: $id, appare con frequenza di $feq";
	}
	$i++;
}
$sl="<select size=\"5\" id=\"prova\"  ONCLICK=\"location = this.options[this.selectedIndex].value;\" >";
?>
<!-- 
<select size="5" >
<optgroup label="az"></optgroup>
<option selected="selected">ciao</option>
<option></option>
</select>
 -->
<?php 
$sl=$sl.selecta_sl($parole_less,$pos)."</select>";

//dumpa ($parole_less,1);
echo "Alfabetica<br>";
echo $sl;


/************/
/*
 * Per orindare con le frequenze devo prima vedere 24 item prima che frequenza ci stà quindi un 
 * select freq < $feqn limit 24,1
 * 
 * 
 * 
 * 
 * 
 */

//$feq


//UNa unica non va bene perchè non sò quanti risultati ci sono in una sola...
//$sql="(select word from ita_frequency where frequency = $feq and word <= '$word' order by word DESC limit 24) UNION (select word from ita_frequency where frequency = $feq and word > '$word' order by word ASC limit 24) order by word ASC";
$sql="select word from (select word from $lang_frequency where frequency = $feq and word <= '$word' order by word DESC limit 24)as t2 order by word ASC" ; 
$fs = mysql_query($sql);
echo "<br>$sql <br> $err<hr>";
//dumpa ($rs);
$err=mysql_error($db);
if ($err)
{
	echo "<br>$sql <br> $err<hr>";
}

$i=0;
while ($rs=mysql_fetch_row($fs))
{
	//dumpa ($rs);
	$parole_feq[]=$rs[0];
	if ($i==24 )
	{
	//$parole_less[] ="Id parola: $id, appare con frequenza di $feq";
	}
	$i++;
}
$i--;
$sl="<select size=\"5\" id=\"prova2\"  ONCHANGE=\"location = this.options[this.selectedIndex].value;\" >";
$sl=$sl.selecta_sl($parole_feq,$i);

$sql="select word from (select word from $lang_frequency where frequency = $feq and word > '$word' order by word ASC limit 24)as t2 order by word ASC" ; 
$fs = mysql_query($sql);
echo "<br>$sql <br> $err<hr>";
//dumpa ($rs);
$err=mysql_error($db);
if ($err)
{
	echo "<br>$sql <br> $err<hr>";
}
$parole_feq="";
$i=0;
while ($rs=mysql_fetch_row($fs))
{
	//dumpa ($rs);
	$parole_feq[]=$rs[0];
	if ($i==24 )
	{
	//$parole_less[] ="Id parola: $id, appare con frequenza di $feq";
	}
	$i++;
}
$sl=$sl.selecta_l($parole_feq)."</select>";

//dumpa ($parole_feq,1);
echo "<br>Frequenza<br>";
echo $sl;





//echo $word;
//echo "<br>Id parola: $id, appare con frequenza di $feq";
//dumpa ($parole_over,1);
foot();
?>
<script type="text/javascript">
window.onload = function()
{
	document.getElementById('prova').size=9;
	document.getElementById('prova2').size=9;
}</script>