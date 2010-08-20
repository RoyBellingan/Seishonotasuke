<?php
include ("elenco_lib.php");
include ("funzioni.php");
$i=0;
foreach ($libr["italiano"] as $libro)
{
	$i++;
	foreach ($lib_class as $libram)
	{

		if (($i<=$libram[1]) && ($i>=$libram[0]))
		{
			$nome[$i]=$libro;
			$class[$i]=$libram[2];
			$color[$i]=$libram[3];
			break;
		}
	}

}

foreach ($lib_class as $libram)
{
	$text.="<li id=\"$libram[2]\"> $libram[2] <dl>\n";
	for ($i=$libram[0];$i<$libram[1]+1;$i++)
	{
		$text.="<dt> <a id=\"$class[$i]\" name=\"$nome[$i]\" href=\"l?l=$i\" rel=\"l2?l=$i\" class=\"jtip\" >$nome[$i]</a> </dt>";
	}
	$text.="</dl></li>\n";
}

echo $text;
die();
?>
<dt><a
	rel="l2?l=13"
	href="l?l=13"
	id="Storici"
	class="jtip"
>1 Cronache</a></dt>


/*Classi di gestione interna */ $lib_class['Pentateuco'][0]=1; //Genesi $lib_class['Pentateuco'][1]=5; // Deuteronomio $lib_class['Pentateuco'][2]='Pentateuco'; // Deuteronomio //$t_lang['$lang']['Pentateuco'] $lib_class['Pentateuco'][3]='#FFC341'; // Deuteronomio

<li id="Pentateuco">Pentateuco
<dl>
	<dt><a
		id="Pentateuco"
		name="Genesi"
		href="l?l=1"
	>Genesi</a></dt>
	<dt><a
		id="Pentateuco"
		href="l?l=2"
	>Esodo</a></dt>
	<dt><a
		id="Pentateuco"
		href="l?l=3"
	>Levitico</a></dt>

	<dt><a
		id="Pentateuco"
		href="l?l=4"
	>Numeri</a></dt>
	<dt><a
		id="Pentateuco"
		href="l?l=5"
	>Deuteronomio</a></dt>
</dl>
</li>




dumpa($class); echo "prova"; ?>

<li id="Pentateuco">Pentateuco
<dl>
	<dt><a
		id="Pentateuco"
		name="Genesi"
		href="l?l=1"
	>Genesi</a></dt>
	<dt><a
		id="Pentateuco"
		name="Esodo"
		href="l?l=2"
	>Esodo</a></dt>
	<dt><a
		id="Pentateuco"
		name="Levitico"
		href="l?l=3"
	>Levitico</a></dt>
	<dt><a
		id="Pentateuco"
		name="Numeri"
		href="l?l=4"
	>Numeri</a></dt>
	<dt><a
		id="Pentateuco"
		name="Deuteronomio"
		href="l?l=5"
	>Deuteronomio</a></dt>
</dl>
</li>

<li id="Storici">Storici
<dl>
	<dt><a
		id="Storici"
		name="Giosuè"
		href="l?l=6"
	>Giosuè</a></dt>
	<dt><a
		id="Storici"
		name="Giudici"
		href="l?l=7"
	>Giudici</a></dt>
	<dt><a
		id="Storici"
		name="Rut"
		href="l?l=8"
	>Rut</a></dt>
	<dt><a
		id="Storici"
		name="1 Samuele"
		href="l?l=9"
	>1 Samuele</a></dt>
	<dt><a
		id="Storici"
		name="2 Samuele"
		href="l?l=10"
	>2 Samuele</a></dt>
	<dt><a
		id="Storici"
		name="1 Re"
		href="l?l=11"
	>1 Re</a></dt>
	<dt><a
		id="Storici"
		name="2 Re"
		href="l?l=12"
	>2 Re</a></dt>
	<dt><a
		id="Storici"
		name="1 Cronache"
		href="l?l=13"
	>1 Cronache</a></dt>
	<dt><a
		id="Storici"
		name="2 Cronache"
		href="l?l=14"
	>2 Cronache</a></dt>
	<dt><a
		id="Storici"
		name="Esdra"
		href="l?l=15"
	>Esdra</a></dt>
	<dt><a
		id="Storici"
		name="Neemia"
		href="l?l=16"
	>Neemia</a></dt>
	<dt><a
		id="Storici"
		name="Ester"
		href="l?l=17"
	>Ester</a></dt>
	<dt><a
		id="Storici"
		name="Giobbe"
		href="l?l=18"
	>Giobbe</a></dt>
</dl>
</li>

<li id="Poetici">Poetici
<dl>
	<dt><a
		id="Poetici"
		name="Salmi"
		href="l?l=19"
	>Salmi</a></dt>
	<dt><a
		id="Poetici"
		name="Proverbi"
		href="l?l=20"
	>Proverbi</a></dt>
	<dt><a
		id="Poetici"
		name="Ecclesiaste"
		href="l?l=21"
	>Ecclesiaste</a></dt>
	<dt><a
		id="Poetici"
		name="Il Cantico dei Cantici"
		href="l?l=22"
	>Il Cantico dei Cantici</a></dt>
</dl>
</li>
<li id="Profetici">Profetici
<dl>

	<dt><a
		id="Profetici"
		name="Isaia"
		href="l?l=23"
	>Isaia</a></dt>
	<dt><a
		id="Profetici"
		name="Geremia"
		href="l?l=24"
	>Geremia</a></dt>
	<dt><a
		id="Profetici"
		name="Lamentazioni"
		href="l?l=25"
	>Lamentazioni</a></dt>
	<dt><a
		id="Profetici"
		name="Ezechiele"
		href="l?l=26"
	>Ezechiele</a></dt>
	<dt><a
		id="Profetici"
		name="Daniele"
		href="l?l=27"
	>Daniele</a></dt>
	<dt><a
		id="Profetici"
		name="Osea"
		href="l?l=28"
	>Osea</a></dt>
	<dt><a
		id="Profetici"
		name="Gioele"
		href="l?l=29"
	>Gioele</a></dt>
	<dt><a
		id="Profetici"
		name="Amos"
		href="l?l=30"
	>Amos</a></dt>
	<dt><a
		id="Profetici"
		name="Abdia"
		href="l?l=31"
	>Abdia</a></dt>
	<dt><a
		id="Profetici"
		name="Giona"
		href="l?l=32"
	>Giona</a></dt>
	<dt><a
		id="Profetici"
		name="Michea"
		href="l?l=33"
	>Michea</a></dt>
	<dt><a
		id="Profetici"
		name="Naum"
		href="l?l=34"
	>Naum</a></dt>
	<dt><a
		id="Profetici"
		name="Abacuc"
		href="l?l=35"
	>Abacuc</a></dt>
	<dt><a
		id="Profetici"
		name="Sofonia"
		href="l?l=36"
	>Sofonia</a></dt>
	<dt><a
		id="Profetici"
		name="Aggeo"
		href="l?l=37"
	>Aggeo</a></dt>
	<dt><a
		id="Profetici"
		name="Zaccaria"
		href="l?l=38"
	>Zaccaria</a></dt>
	<dt><a
		id="Profetici"
		name="Malachia"
		href="l?l=39"
	>Malachia</a></dt>
</dl>
</li>

<li id="Vangeli">Vangeli
<dl>
	<dt><a
		id="Vangeli"
		name="Matteo"
		href="l?l=40"
	>Matteo</a></dt>
	<dt><a
		id="Vangeli"
		name="Marco"
		href="l?l=41"
	>Marco</a></dt>
	<dt><a
		id="Vangeli"
		name="Luca"
		href="l?l=42"
	>Luca</a></dt>
	<dt><a
		id="Vangeli"
		name="Giovanni"
		href="l?l=43"
	>Giovanni</a></dt>
	<dt><a
		id="Vangeli"
		name="Atti"
		href="l?l=44"
	>Atti</a></dt>
</dl>
</li>

<li id="Lettere">Lettere
<dl>
	<dt><a
		id="Lettere"
		name="Romani"
		href="l?l=45"
	>Romani</a></dt>
	<dt><a
		id="Lettere"
		name="1 Corinti"
		href="l?l=46"
	>1 Corinti</a></dt>
	<dt><a
		id="Lettere"
		name="2 Corinti"
		href="l?l=47"
	>2 Corinti</a></dt>
	<dt><a
		id="Lettere"
		name="Galati"
		href="l?l=48"
	>Galati</a></dt>
	<dt><a
		id="Lettere"
		name="Efesini"
		href="l?l=49"
	>Efesini</a></dt>
	<dt><a
		id="Lettere"
		name="Filippesi"
		href="l?l=50"
	>Filippesi</a></dt>
	<dt><a
		id="Lettere"
		name="Colossesi"
		href="l?l=51"
	>Colossesi</a></dt>
	<dt><a
		id="Lettere"
		name="1 Tessalonicesi"
		href="l?l=52"
	>1 Tessalonicesi</a></dt>
	<dt><a
		id="Lettere"
		name="2 Tessalonicesi"
		href="l?l=53"
	>2 Tessalonicesi</a></dt>
	<dt><a
		id="Lettere"
		name="1 Timoteo"
		href="l?l=54"
	>1 Timoteo</a></dt>
	<dt><a
		id="Lettere"
		name="2 Timoteo"
		href="l?l=55"
	>2 Timoteo</a></dt>
	<dt><a
		id="Lettere"
		name="Tito"
		href="l?l=56"
	>Tito</a></dt>
	<dt><a
		id="Lettere"
		name="Filemone"
		href="l?l=57"
	>Filemone</a></dt>
	<dt><a
		id="Lettere"
		name="Ebrei"
		href="l?l=58"
	>Ebrei</a></dt>
	<dt><a
		id="Lettere"
		name="Giacomo"
		href="l?l=59"
	>Giacomo</a></dt>
	<dt><a
		id="Lettere"
		name="1 Pietro"
		href="l?l=60"
	>1 Pietro</a></dt>
	<dt><a
		id="Lettere"
		name="2 Pietro"
		href="l?l=61"
	>2 Pietro</a></dt>
	<dt><a
		id="Lettere"
		name="1 Giovanni"
		href="l?l=62"
	>1 Giovanni</a></dt>
	<dt><a
		id="Lettere"
		name="2 Giovanni"
		href="l?l=63"
	>2 Giovanni</a></dt>
	<dt><a
		id="Lettere"
		name="3 Giovanni"
		href="l?l=64"
	>3 Giovanni</a></dt>
	<dt><a
		id="Lettere"
		name="Giuda"
		href="l?l=65"
	>Giuda</a></dt>
	<dt><a
		id="Lettere"
		name="Rivelazione"
		href="l?l=66"
	>Rivelazione</a></dt>
</dl>
</li>

