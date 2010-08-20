<?php
ob_start();
error_reporting (9);


header("Cache-Control: must-revalidate, max-age=3600");
header("Vary: Accept-Encoding");




$NOW1=microtime(true);


require_once ("mysqlutil.php");
//require_once ("funkz.php");
require_once ("funzioni.php");
require ("sphinxapi.php");
//require_once ("./ajax/ins_ajax.php");
//include_once ($_SERVER['DOCUMENT_ROOT'] ."/ProjectEVA/util/mysqlutil.php");




$host=$_SERVER['HTTP_HOST'];
$percorso=$_SERVER['SCRIPT_NAME'];


$SITE_PATH="http://$host/";


$path='SITE_PATH';
$path2='SITE_PATH2';
$PTitle="聖書の助け";
$NomeP="Sistema semantico/inferenziale per lo studio personale";
//$società="Smea";


/**
 * Carica il Top della Pagina HTML + Il Titolo
 *
 */

function top()
{
	top2();
	connetti();
}

function top2()
{
	GLOBAL $PTitle;
	if (isset ($_SERVER['HTTP_REFERER'] ))
	{
		$ref=$_SERVER['HTTP_REFERER'];
	}

	$html=<<<EOD
<head>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//IT" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it" dir="ltr">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="generator" content="聖書の助け" />
	<title>$PTitle</title>
	

	<link rel="stylesheet" href="./css/1.css" type="text/css" />
	<link rel="stylesheet" href="./css/2.css" type="text/css" />
	<link rel="stylesheet" href="./css/p1.php" type="text/css" />
	
	<script type="text/javascript" src="js/jquery.js">

        </script>
        <script type="text/javascript">
            
        /*    function sleep(delay){
                var start = new Date().getTime();
                while (new Date().getTime() < start + delay);
            }*/
            
            $(document).ready(function(){
            
                
            $("ul.subnav").parent().append("<span></span>"); //Only shows drop down trigger when js is enabled - Adds empty span tag after ul.subnav
            

            
                $("ul.topnav li").bind('mouseenter',
                 function(){ //When trigger is clicked...
                    //Following events are applied to the subnav itself (moving subnav up and down)
                    //nao.stop(true, true).slideUp(1);
                    var neu = $(this).find("ul.subnav")
                    neu.fadeIn('fast').show(); //Drop down the subnav on click

                    $('#lib').focus();
                    
                  /*  $(this).hover(function(){
                     },
                    function(){
                       // var nao = $(this).find("ul.subnav")
                        //neu.stop(true, true).slideUp(1);
                        //When the mouse hovers out of the subnav, move it back up
                    
                    });*/
                    
                    $("#corpo").hover(function(){
                    neu.stop(true, true).fadeOut(1);
                    },
                    function(){
                    neu.stop(true, true).fadeOut(1);
                         //When the mouse hovers out of the subnav, move it back up
                    });
                    
                     /*           $(".container").hover(function(){
                    neu.stop(true, true).fadeOut(1);
                    },
                    function(){
                    neu.stop(true, true).fadeOut(1);
                         //When the mouse hovers out of the subnav, move it back up
                    });*/
                    
                    
                    
                    //Following events are applied to the trigger (Hover events for the trigger)
                });

                $("#full a").bind('mouseenter',
                 function(){
                  //When trigger is clicked...
                    //Following events are applied to the subnav itself (moving subnav up and down)
                    //var neu = $(this).
                    //alert ($(this).attr("name"))
                    });
                
                    
         $('.jtip').cluetip({
		  cluetipClass: 'jtip', 
		  arrows: true, 
		  showTitle: false,
		  positionBy: 'bottomTop',
		  topOffset: 10,     
		  dropShadow: false,
		  hoverIntent: false,
		  sticky: true,
		  mouseOutClose: true,
		 // closePosition: 'title',
		  closeText: ''
		});
                
            });
        </script>
	
	
	
	</head>
<body>

<div class="container" >
            <div id="header">
                <ul class="topnav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a >Libri</a>
                        <ul class="subnav" style="width:750px;" >
                            <div id="full" >
                                <ul>
                                <form style=" margin: 0px; padding: 0px" action="l.php" method="post" name="quest" id="quest">
                                <input id="lib" name="lib" type"text" style="margin: 0px 0 0 20px;" value="">
                                <input name="submit" type="submit" value="cerca">
                                </form>
<li id="Pentateuco">
    Pentateuco 
    <dl>
        <dt>
            <a id="Pentateuco" name="Genesi" href="l?l=1" rel="l2?l=1" class="jtip">Genesi</a>
        </dt>
        <dt>
            <a id="Pentateuco" name="Esodo" href="l?l=2" rel="l2?l=2" class="jtip">Esodo</a>
        </dt>
        <dt>
            <a id="Pentateuco" name="Levitico" href="l?l=3" rel="l2?l=3" class="jtip">Levitico</a>
        </dt>
        <dt>
            <a id="Pentateuco" name="Numeri" href="l?l=4" rel="l2?l=4" class="jtip">Numeri</a>
        </dt>
        <dt>
            <a id="Pentateuco" name="Deuteronomio" href="l?l=5" rel="l2?l=5" class="jtip">Deuteronomio</a>
        </dt>
    </dl>
</li>
<li id="Storici">
    Storici 
    <dl>
        <dt>
            <a id="Storici" name="Giosuè" href="l?l=6" rel="l2?l=6" class="jtip">Giosuè</a>
        </dt>
        <dt>
            <a id="Storici" name="Giudici" href="l?l=7" rel="l2?l=7" class="jtip">Giudici</a>
        </dt>
        <dt>
            <a id="Storici" name="Rut" href="l?l=8" rel="l2?l=8" class="jtip">Rut</a>
        </dt>
        <dt>
            <a id="Storici" name="1 Samuele" href="l?l=9" rel="l2?l=9" class="jtip">1 Samuele</a>
        </dt>
        <dt>
            <a id="Storici" name="2 Samuele" href="l?l=10" rel="l2?l=10" class="jtip">2 Samuele</a>
        </dt>
        <dt>
            <a id="Storici" name="1 Re" href="l?l=11" rel="l2?l=11" class="jtip">1 Re</a>
        </dt>
        <dt>
            <a id="Storici" name="2 Re" href="l?l=12" rel="l2?l=12" class="jtip">2 Re</a>
        </dt>
        <dt>
            <a id="Storici" name="1 Cronache" href="l?l=13" rel="l2?l=13" class="jtip">1 Cronache</a>
        </dt>
        <dt>
            <a id="Storici" name="2 Cronache" href="l?l=14" rel="l2?l=14" class="jtip">2 Cronache</a>
        </dt>
        <dt>
            <a id="Storici" name="Esdra" href="l?l=15" rel="l2?l=15" class="jtip">Esdra</a>
        </dt>
        <dt>
            <a id="Storici" name="Neemia" href="l?l=16" rel="l2?l=16" class="jtip">Neemia</a>
        </dt>
        <dt>
            <a id="Storici" name="Ester" href="l?l=17" rel="l2?l=17" class="jtip">Ester</a>
        </dt>
        <dt>
            <a id="Storici" name="Giobbe" href="l?l=18" rel="l2?l=18" class="jtip">Giobbe</a>
        </dt>
    </dl>
</li>
<li id="Poetici">
    Poetici 
    <dl>
        <dt>
            <a id="Poetici" name="Salmi" href="l?l=19" rel="l2?l=19" class="jtip">Salmi</a>
        </dt>
        <dt>
            <a id="Poetici" name="Proverbi" href="l?l=20" rel="l2?l=20" class="jtip">Proverbi</a>
        </dt>
        <dt>
            <a id="Poetici" name="Ecclesiaste" href="l?l=21" rel="l2?l=21" class="jtip">Ecclesiaste</a>
        </dt>
        <dt>
            <a id="Poetici" name="Il Cantico dei Cantici" href="l?l=22" rel="l2?l=22" class="jtip">Il Cantico dei Cantici</a>
        </dt>
    </dl>
</li>
<li id="Profetici">
    Profetici 
    <dl>
        <dt>
            <a id="Profetici" name="Isaia" href="l?l=23" rel="l2?l=23" class="jtip">Isaia</a>
        </dt>
        <dt>
            <a id="Profetici" name="Geremia" href="l?l=24" rel="l2?l=24" class="jtip">Geremia</a>
        </dt>
        <dt>
            <a id="Profetici" name="Lamentazioni" href="l?l=25" rel="l2?l=25" class="jtip">Lamentazioni</a>
        </dt>
        <dt>
            <a id="Profetici" name="Ezechiele" href="l?l=26" rel="l2?l=26" class="jtip">Ezechiele</a>
        </dt>
        <dt>
            <a id="Profetici" name="Daniele" href="l?l=27" rel="l2?l=27" class="jtip">Daniele</a>
        </dt>
        <dt>
            <a id="Profetici" name="Osea" href="l?l=28" rel="l2?l=28" class="jtip">Osea</a>
        </dt>
        <dt>
            <a id="Profetici" name="Gioele" href="l?l=29" rel="l2?l=29" class="jtip">Gioele</a>
        </dt>
        <dt>
            <a id="Profetici" name="Amos" href="l?l=30" rel="l2?l=30" class="jtip">Amos</a>
        </dt>
        <dt>
            <a id="Profetici" name="Abdia" href="l?l=31" rel="l2?l=31" class="jtip">Abdia</a>
        </dt>
        <dt>
            <a id="Profetici" name="Giona" href="l?l=32" rel="l2?l=32" class="jtip">Giona</a>
        </dt>
        <dt>
            <a id="Profetici" name="Michea" href="l?l=33" rel="l2?l=33" class="jtip">Michea</a>
        </dt>
        <dt>
            <a id="Profetici" name="Naum" href="l?l=34" rel="l2?l=34" class="jtip">Naum</a>
        </dt>
        <dt>
            <a id="Profetici" name="Abacuc" href="l?l=35" rel="l2?l=35" class="jtip">Abacuc</a>
        </dt>
        <dt>
            <a id="Profetici" name="Sofonia" href="l?l=36" rel="l2?l=36" class="jtip">Sofonia</a>
        </dt>
        <dt>
            <a id="Profetici" name="Aggeo" href="l?l=37" rel="l2?l=37" class="jtip">Aggeo</a>
        </dt>
        <dt>
            <a id="Profetici" name="Zaccaria" href="l?l=38" rel="l2?l=38" class="jtip">Zaccaria</a>
        </dt>
        <dt>
            <a id="Profetici" name="Malachia" href="l?l=39" rel="l2?l=39" class="jtip">Malachia</a>
        </dt>
    </dl>
</li>
<li id="Vangeli">
    Vangeli 
    <dl>
        <dt>
            <a id="Vangeli" name="Matteo" href="l?l=40" rel="l2?l=40" class="jtip">Matteo</a>
        </dt>
        <dt>
            <a id="Vangeli" name="Marco" href="l?l=41" rel="l2?l=41" class="jtip">Marco</a>
        </dt>
        <dt>
            <a id="Vangeli" name="Luca" href="l?l=42" rel="l2?l=42" class="jtip">Luca</a>
        </dt>
        <dt>
            <a id="Vangeli" name="Giovanni" href="l?l=43" rel="l2?l=43" class="jtip">Giovanni</a>
        </dt>
        <dt>
            <a id="Vangeli" name="Atti" href="l?l=44" rel="l2?l=44" class="jtip">Atti</a>
        </dt>
    </dl>
</li>
<li id="Lettere">
    Lettere 
    <dl>
        <dt>
            <a id="Lettere" name="Romani" href="l?l=45" rel="l2?l=45" class="jtip">Romani</a>
        </dt>
        <dt>
            <a id="Lettere" name="1 Corinti" href="l?l=46" rel="l2?l=46" class="jtip">1 Corinti</a>
        </dt>
        <dt>
            <a id="Lettere" name="2 Corinti" href="l?l=47" rel="l2?l=47" class="jtip">2 Corinti</a>
        </dt>
        <dt>
            <a id="Lettere" name="Galati" href="l?l=48" rel="l2?l=48" class="jtip">Galati</a>
        </dt>
        <dt>
            <a id="Lettere" name="Efesini" href="l?l=49" rel="l2?l=49" class="jtip">Efesini</a>
        </dt>
        <dt>
            <a id="Lettere" name="Filippesi" href="l?l=50" rel="l2?l=50" class="jtip">Filippesi</a>
        </dt>
        <dt>
            <a id="Lettere" name="Colossesi" href="l?l=51" rel="l2?l=51" class="jtip">Colossesi</a>
        </dt>
        <dt>
            <a id="Lettere" name="1 Tessalonicesi" href="l?l=52" rel="l2?l=52" class="jtip">1 Tessalonicesi</a>
        </dt>
        <dt>
            <a id="Lettere" name="2 Tessalonicesi" href="l?l=53" rel="l2?l=53" class="jtip">2 Tessalonicesi</a>
        </dt>
        <dt>
            <a id="Lettere" name="1 Timoteo" href="l?l=54" rel="l2?l=54" class="jtip">1 Timoteo</a>
        </dt>
        <dt>
            <a id="Lettere" name="2 Timoteo" href="l?l=55" rel="l2?l=55" class="jtip">2 Timoteo</a>
        </dt>
        <dt>
            <a id="Lettere" name="Tito" href="l?l=56" rel="l2?l=56" class="jtip">Tito</a>
        </dt>
        <dt>
            <a id="Lettere" name="Filemone" href="l?l=57" rel="l2?l=57" class="jtip">Filemone</a>
        </dt>
        <dt>
            <a id="Lettere" name="Ebrei" href="l?l=58" rel="l2?l=58" class="jtip">Ebrei</a>
        </dt>
        <dt>
            <a id="Lettere" name="Giacomo" href="l?l=59" rel="l2?l=59" class="jtip">Giacomo</a>
        </dt>
        <dt>
            <a id="Lettere" name="1 Pietro" href="l?l=60" rel="l2?l=60" class="jtip">1 Pietro</a>
        </dt>
        <dt>
            <a id="Lettere" name="2 Pietro" href="l?l=61" rel="l2?l=61" class="jtip">2 Pietro</a>
        </dt>
        <dt>
            <a id="Lettere" name="1 Giovanni" href="l?l=62" rel="l2?l=62" class="jtip">1 Giovanni</a>
        </dt>
        <dt>
            <a id="Lettere" name="2 Giovanni" href="l?l=63" rel="l2?l=63" class="jtip">2 Giovanni</a>
        </dt>
        <dt>
            <a id="Lettere" name="3 Giovanni" href="l?l=64" rel="l2?l=64" class="jtip">3 Giovanni</a>
        </dt>
        <dt>
            <a id="Lettere" name="Giuda" href="l?l=65" rel="l2?l=65" class="jtip">Giuda</a>
        </dt>
        <dt>
            <a id="Lettere" name="Rivelazione" href="l?l=66" rel="l2?l=66" class="jtip">Rivelazione</a>
        </dt>
    </dl>
</li>
                                
                                
                                </ul>
                            </div>
                            </ul>
                    </li>
                    <li>
                        <a>Concordanze</a>
                        <ul class="subnav" style="width:220px;">
                            <li>
                                <a href="p">Alfabetica</a>
                            </li>
                           <!-- <li>
                                <a href="f">Frequenza</a>
                            </li>
                            <li>
                                <a href="l">Lunghezza</a>
                            </li>
                            <li>
                                <a href="r">Rovesciate&nbsp;(lettera&nbsp;finale)</a> -->
                            </li>
                            <li>
                                <a href="c">Ricerca libera</a>
                            </li>
                            <li>
                                <a href="s">Stastiche</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Annotazioni</a>
                    </li>
                    <li>
                        <a href="#">Discorsi</a>
                    </li>
                    <li>
                        <a href="#">Visite (sperimentale)</a>
                    </li>
                    <li>
                        <a href="Opzioni">Opzioni</a>
                        <ul class="subnav" style="width:220px;">
                            <li>
                                <a href="#">CSS</a>
                            </li>
                            <li>
                                <a href="#">Lingua</a>
                                <!--
                                http://www.dynamicdrive.com/style/csslibrary/item/jquery_multi_level_css_menu_horizontal_blue/
                                -->
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="Tools">Tools</a>
               			<ul class="subnav" style="width:220px;">
                            <li>
                                <a href="flush.php">Flush della cache</a>
                            </li>
                            <li>
                                <a href="lang.php">Lingua</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div id="corpo">
EOD;

	echo $html;
}
//Variabili varie}

function top3()
{
	GLOBAL $NomeP,$società,$PTitle,$SITE_PATH;
	$ref=$_SERVER['HTTP_REFERER'];
	$ind=$SITE_PATH."index.php";
	$html=<<<EOD
<head>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//IT" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it" dir="ltr">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="generator" content="新世紀エヴァンゲリオン" />
	
	<title>$PTitle</title>
	
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/prove.js"></script>
        
    <link rel="stylesheet" href="./css/1.css" type="text/css" />
    <link rel="stylesheet" href="./css/2.css" type="text/css" />
	</head>
EOD;
	echo $html;
}

/**
 * Il Footer delle pagine ...
 */
function foot($extra="") {
	Global $NOW1,$host;

	if (isset ($_SERVER['HTTP_REFERER'] ))
	{
		$prima=$_SERVER['HTTP_REFERER'];
		setcookie("PagePrima",$prima,0,"/");
	}

	//Timing!
	$NOW2=microtime(true)-$NOW1;
	echo "</div> <div align=\"center\" id=\"footer\"> <hr width=\"66%\" size=1 color=\"silver\">";
	printf(" Served with proud by %s in %1.5f secs. $extra</div>", $host, $NOW2);
	echo "</body>";
	ob_end_flush();
} ?>
