<?php
include_once("util/top_foot_inc.php");
/*
 Per creare una categoria puoi usare queste scorciatoie:



: / È usato per definire una gerarchia
:; Città/Parigi

: , È usato per separare vari tag
:; Parigi, Monumenti/Notre Dame

Esempi

Ho queste categorie

/
	Città
		Parigi
		Roma
	Monumenti
		Storici
		Moderni
	Conoscenti
	Veicoli
		auto
		moto
			giapponesi
			italiane

Se voglio creare un'altra città scriverò:
	Città/Frascati

Se voglio aggiungere qualcosa alle moto giapponesi
	click su giapponesi e poi il nome
	Oppure
	giapponesi/honda
	Oppure
	/Veicoli/moto/giapponesi/honda
Usate il primo metodo, al massimo il secondo...
 */

$css=<<<EOD
	<link rel="stylesheet" type="text/css" title="access"    href="./css/ext4-all-access.css" />
EOD;

$js=<<<EOD
	<script type="text/javascript" src="js/ext4-all.js"></script>
	<script type="text/javascript" src="js/categorie.js"></script>
EOD;


top_text($css,$js);

echo "<br><br><br><br><br><div id=\"boxxoso\">some</div>";


foot();