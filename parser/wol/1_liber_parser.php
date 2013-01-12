<?php

$lang="Deutsch";
//Link alla biblica pagina

$url="http://wol.jw.org/de/wol/binav/r10/lp-x";

$html=file_get_contents($url);

$off1=strpos($html,"books hebrew");
$off2=strpos($html,"contentFooter");

//echo "init @ $off1 end ad $off2";

$raw1=substr($html,$off1,($off2-$off1));
//$raw1='<li class="book"><a href="/de/wol/binav/r10/lp-x/1">1. Mose</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/2">2. Mose</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/3">3. Mose</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/4">4. Mose</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/5">5. Mose</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/6">Josua</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/7">Richter</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/8">Ruth</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/9">1. Samuel</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/10">2. Samuel</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/11">1. Könige</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/12">2. Könige</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/13">1. Chronika</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/14">2. Chronika</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/15">Esra</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/16">Nehemia</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/17">Esther</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/18">Hiob</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/19">Psalm</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/20">Sprüche</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/21">Prediger</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/22">Hohes Lied</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/23">Jesaja</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/24">Jeremia</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/25">Klagelieder</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/26">Hesekiel</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/27">Daniel</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/28">Hosea</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/29">Joel</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/30">Amos</a></li><li class="book"><a href="/de/wol/b/r10/lp-x/31/1">Obadja</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/32">Jona</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/33">Micha</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/34">Nahum</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/35">Habakuk</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/36">Zephanja</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/37">Haggai</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/38">Sacharja</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/39">Maleachi</a></li></ul><ul class="books greek"><li class="book"><a href="/de/wol/binav/r10/lp-x/40">Matthäus</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/41">Markus</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/42">Lukas</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/43">Johannes</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/44">Apostelgeschichte</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/45">Römer</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/46">1. Korinther</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/47">2. Korinther</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/48">Galater</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/49">Epheser</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/50">Philipper</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/51">Kolosser</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/52">1. Thessalonicher</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/53">2. Thessalonicher</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/54">1. Timotheus</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/55">2. Timotheus</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/56">Titus</a></li><li class="book"><a href="/de/wol/b/r10/lp-x/57/1">Philemon</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/58">Hebräer</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/59">Jakobus</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/60">1. Petrus</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/61">2. Petrus</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/62">1. Johannes</a></li><li class="book"><a href="/de/wol/b/r10/lp-x/63/1">2. Johannes</a></li><li class="book"><a href="/de/wol/b/r10/lp-x/64/1">3. Johannes</a></li><li class="book"><a href="/de/wol/b/r10/lp-x/65/1">Judas</a></li><li class="book"><a href="/de/wol/binav/r10/lp-x/66">Offenbarung</a></li></ul></ul></div></div>';
                   

preg_match_all("/<[^>]*>([^<]+)/", $raw1,$raw2);

echo "//$lang \n";
$i=0;
foreach ($raw2[1] as $key => $value) {
	$i++;
	echo '$libr["'.$lang.'"]['.$i.']="'.$value.'";'."\n";	
	if ($i==66){
		break;
	}
}





