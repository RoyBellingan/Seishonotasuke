<?php
die();
include_once ("util/top_foot_inc.php");
top2();

/*
 * Fatto il parser, ora abbina ai vari
 *
 * <span id=\"vs".$vers."\">";
 * il relativo testo, e controlla se in mezzo ci sta u class p o simile e abbinalo a bo, e inventa un modo per gestire la cosa
 * una sorta di raw text e un marked text... anche se credo sia sbagliatissima come cosa... credo sia da usare una specie di sotto versetto a questo punto
 * per mantenere anche in caso di edit la cosa consistente ed evitare doppioni di testi sparsi ecc ecc
 *
 * http://susi/%E8%81%96%E6%9B%B8/loader.php
 *
 * ----------
 *Controlla se prima del
 *<a name="bk4" class="vsAnchor">4
 ci stà un <p> che quindi delinea un sottogruppo di versetti...
 *
 */

connetti();

$error=false;

$counter=1;
$libro="Genesi";
$libro_a="ex";


$fp = fopen("$libro", 'r');
//echo $fp;
$pak=file_get_contents("$libro");
//dumpa($pak,1);

while ($error==false) //Loop che fa la scansione dei capitoli
{
	//Splitto inizio e fine del capitolo
	$counter++;
	$hay="<capitolo_".$counter.">";
	$hay2="</capitolo_".$counter.">";


	$pos=strpos($pak,$hay);
	$pos2=strpos($pak,$hay2,$pos);
	$delta=$pos2-$pos;


	//echo "<br><br> Cerco $hay -> Pos: $pos - $pos2 = $delta ";

	$capitolo=$cap[$counter]['Testo']=substr($pak,$pos,$delta);
	//
	//
	//E spezzetto nei vari <tag>
	$preg="|(<[^>]+>)([^<>]*)|";
	//$preg="|<[^>]+>(.*)</[^>]+>|U";
	$fetchati=megafetcher($capitolo,$preg,PREG_PATTERN_ORDER);
	dumpa($fetchati[2],1);


	//	$res=array_risearch($fetchati[1],"</p>",0,0,0);
	//
	//
	//	dumpa($res,1);


	$capier=false;

	while ($capier==false) //Loop che fa il fetch dei versetti
	{

		$vers++;
		$vers2=$vers+1;
		$span="<span id=\"vs".$vers."\">";
		$spanS=strlen($span);
		$spanend="</span>";
		$spanendS=strlen($spanend);
		$anchor="<a name=\"bk".$vers."\" class=\"vsAnchor\">";
		$anchor2="<a name=\"bk".$vers2."\" class=\"vsAnchor\">";
		$p="<p>";
		$pp="</p>";


		/*
		 [182] => <p>
		 [183] => <a name="bk23" class="vsAnchor">23
		 [184] => </a>
		 [185] => <span id="vs23">Allora l’uomo disse:
		 [186] => <br>
		 [187] => <span class="p">“Questa è finalmente osso delle mie ossa
		 [188] => </span>
		 [189] => <br>
		 [190] => <span class="z">E carne della mia carne.
		 [191] => </span>
		 [192] => <br>
		 [193] => <span class="p">Questa sarà chiamata Donna,
		 [194] => </span>
		 [195] => <br>
		 [196] => <span class="z">Perché dall’uomo questa è stata tratta”.
		 [197] => </span>
		 [198] => </span>
		 [199] => </p>
		 [200] => <p>
		 [201] => <a name="bk24" class="vsAnchor">24
		 [202] => </a>
		 [203] => <span id="vs24">Perciò l’uomo lascerà suo padre e sua madre e si dovrà tenere stretto a sua moglie e dovranno divenire una sola carne.
		 [204] => </span>
		 [205] => <a name="bk25" class="vsAnchor">25
		 [206] => </a>
		 [207] => <span id="vs25">Ed entrambi continuarono a essere nudi, l’uomo e sua moglie, eppure non si vergognavano.
		 [208] => </span>
		 [209] => </p>

		 */
		$pos=array_search($anchor,$fetchati[1]);
			
		if ($fetchati[1][$pos-1]=="<p>")
		{
			$divisorep=true;


		}
		else
		{
			$divisorep=false;
		}
			
			
			
			
		$pos2=array_search($anchor2,$fetchati[1]);
		if ($fetchati[1][$pos2-2]=="</p>")
		{
			$divisore_endp=true;
			$kiz=$fetchati[1][$pos2];
			preg_match('|[0-9]+|',$kiz,$lol);
			dumpa ($lol,1);
			echo "<hr>\nLol is $lol[0] - $kiz\n<br>";
			
			$span=$lol[0]-$vers;
						$sql="Insert into spacer (libro,capitolo,versetto,span) Value ('$libro','$counter','$vers','$span');";
						mysql_query($sql,$db);
						if ($err)
						{
							echo "$err<hr>";
						}

		}
		else
		{
			$divisore_endp=false;
		}
			
		$is=array_risearch($fetchati[1],"<span class=\"p\">",$pos,$pos2,0);
			
		echo "$pos e $pos2";
		dumpa($is,1);


		$is=array_risearch($fetchati[1],"<span class=\"z\">",$pos,$pos2,0);
			
		//si phpmyecho "$pos e $pos2";
		dumpa($is,1);
			
			
		if ($pos2==False)
		{
			$capier=true;
		}




	}


	//
	// 		$testo=$fetchati[2][$pos];
	//
	// 		echo "Al $pos ci stà <br>$testo<br>";
	//
	//
	// 		if ($pos==false)
	// 		{
	// 			$capier = true;
	// 		}
	//
	// 		$pos2=0;
	// 		$pos2=array_search($hay3,$fetchati[1]);
	//
	// 		if ($pos2>1)
	// 		{
	//
	// 			echo "\n<br>Divisore al $pos2";
	//
	// 			$sql="Insert into spacer (libro,capitolo,versetto,span) Value ('$libro','$counter','$vers','1');";
	// 			mysql_query($sql,$db);
	// 			if ($err)
	// 			{
	// 				echo "$err<hr>";
	// 			}
	// 		}
	//
	//
	//
	// 		/*
	// 		 Cerca $hay, quando lo trova cerca se poco prima (46 caratteri circa, facciamo 50 trova per caso hay3, se lo trova
	// 		 flagga che c'è un divisorio, senno amen, trimma il versetto e gg
	// 		 */
	//
	//
	//
	//
	//
	//
	//
	//
	//
	// 		$pos2=strpos($capitolo,$hay2,$pos);
	// 		$delta=$pos2-$pos;
	// 		//echo "<br>Pos: $pos - $pos2 = $delta ";
	// 		//dumpa($capitolo,1);
	// 		//exh();
	//
	//
	// 		//<br><span class="p"> **** </span>
	//
	//
	// 		//<br><span class="z"> **** </span
	//
	//
	//
	// 		$cap[$counter][$vers]=$versetto=substr($capitolo,$pos+$hayl,$delta-$hayl);
	//
	// 		$hk="<br><span class=\"p\">";
	// 		$hk2="<br><span class=\"z\">";
	//
	//
	// 		/*
	// 		 * Controlla e bo...
	// 		 */
	//
	//
	//
	//
	//
	//
	//
	// 		$capitolo=substr($capitolo,$pos2);
	// 		$sql="Insert Into versetti (libro,capitolo,versetto,testo_ita) Value ('$libro','$counter','$vers','$versetto');";
	// 		//echo "<hr>$sql";
	// 		mysql_query($sql,$db);
	// 		$err=mysql_error($db);
	// 		if ($err)
	// 		{
	// 			echo "$err<hr>";
	// 		}
	//
	//
	//
	//
	//
	//
	//
	// 	}

	if ($counter>=1)
	{
		break;
	}


	//<capitolo_$counter>

	/*********************/

	//</capitolo_$counter>

	/*if
	 * <libro_end>
	 * then error e amen...
	 */
}
$pak="";
//dumpa($GLOBALS,1);
foot();

?>