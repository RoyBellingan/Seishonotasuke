<?php

die ('non si lanciano gli script a mozzo...');

$libr[]="Genesi";
$libr[]="Esodo";
$libr[]="Levitico";
$libr[]="Numeri";
$libr[]="Deuteronomio";
$libr[]="Giosuè";
$libr[]="Giudici";
$libr[]="Rut";
$libr[]="1 Samuele";
$libr[]="2 Samuele";
$libr[]="1 Re";
$libr[]="2 Re";
$libr[]="1 Cronache";
$libr[]="2 Cronache";
$libr[]="Esdra";
$libr[]="Neemia";
$libr[]="Ester";
$libr[]="Giobbe";
$libr[]="Salmi";
$libr[]="Proverbi";
$libr[]="Ecclesiaste";
$libr[]="Il Cantico dei Cantici";
$libr[]="Isaia";
$libr[]="Geremia";
$libr[]="Lamentazioni";
$libr[]="Ezechiele";
$libr[]="Daniele";
$libr[]="Osea";
$libr[]="Gioele";
$libr[]="Amos";
$libr[]="Abdia";
$libr[]="Giona";
$libr[]="Michea";
$libr[]="Naum";
$libr[]="Abacuc";
$libr[]="Sofonia";
$libr[]="Aggeo";
$libr[]="Zaccaria";
$libr[]="Malachia";

//Scritture Greche Cristiane";

$libr[]="Matteo";
$libr[]="Marco";
$libr[]="Luca";
$libr[]="Giovanni";
$libr[]="Atti";
$libr[]="Romani";
$libr[]="1 Corinti";
$libr[]="2 Corinti";
$libr[]="Galati";
$libr[]="Efesini";
$libr[]="Filippesi";
$libr[]="Colossesi";
$libr[]="1 Tessalonicesi";
$libr[]="2 Tessalonicesi";
$libr[]="1 Timoteo";
$libr[]="2 Timoteo";
$libr[]="Tito";
$libr[]="Filemone";
$libr[]="Ebrei";
$libr[]="Giacomo";
$libr[]="1 Pietro";
$libr[]="2 Pietro";
$libr[]="1 Giovanni";
$libr[]="2 Giovanni";
$libr[]="3 Giovanni";
$libr[]="Giuda";
$libr[]="Rivelazione";

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


mysql_query("TRUNCATE TABLE `versetti`;",$db);
mysql_query("TRUNCATE TABLE `spacer`;",$db);

$error=false;


$dimex=count($libr);
$lingua="italiano";
$lang="i";
$a="fix1";



//dumpa($pak,1);






for ($jj=0; $jj<66; $jj++)
{

	$refer=$jj+1;
	$libro=$libr[$jj];
	$lib5=substr($libro,0,5);
	$libro_f="libri/$lang/edit/".$libro."fix1";
	echo $libro_f;
	$pak=file_get_contents("$libro_f");

	$arr=explode("\n",$pak);

	$gen=preg_replace("  "," ",$arr);

	//dumpa($arr,1);
	$counter=1;
	$le=sizeof($arr)+1;
	//echo "<br>$le";
	$cap=1;
	for ($i=0;$i<$le;$i++)
	{
		//echo "<br>$i\n";
		$val=trim($arr[$i]);

		$val2=substr($val,0,5);
		//echo "-$val-\n";
		switch ($val2){

			case "@@lib":
				$versetto=0;
				$div_start=1;
				//echo "\n<br>libro ->";
				$c=$arr[$i+1];
				preg_match("|[0-9]+|",$arr[$i+1],$f);
				//dumpa ($f);
				$cap=$f[0];
				//echo "il cap è $cap";
				$i+=3;
				break;
			case "<p></":
				if ($versetto==0)
				{//non far nulla
					//echo "<br>nuovo spacer";
				}
				else
				{
					$div_end=$versetto;
					$div_delta=$div_end-$div_start+1;

					//echo "<br>\n New Spacer From $div_start to $div_end: lasting $div_delta";
					//Query

					$sql="Insert into spacer (libro,capitolo,versetto,span,end) Value ('$refer','$cap','$div_start','$div_delta',$div_end);";
					mysql_query($sql,$db);
					$err=mysql_error($db);
					if ($err)
					{
						echo "<br>$sql <br> $err<hr>";
					}

					$div_start=$div_end+1;
				}
				break;
			case "</br>":
				preg_match("|[0-9]+|",$val,$f,PREG_OFFSET_CAPTURE);
				$versetto=$f[0][0];
				$dime_vers=strlen($versetto);
				//dumpa ($f,1);
				$text2=$text=trim(substr($val,$f[0][1]+$dime_vers));
				//echo "il versetto è $versetto e il testo è $text";

				$sql="Insert Into versetti (libro,capitolo,versetto,testo_ita) Value ('$refer','$cap','$versetto','$text');";
				//echo "<hr>$sql";
				mysql_query($sql,$db);
				$err=mysql_error($db);
				if ($err)
				{
					echo "<br>$sql <br> $err<hr>";
				}
				$id=mysql_insert_id($db);
				break;

			case "@@cit":
				//echo "citazione -> $val";
				$val2=substr($val,0,6);
				if ($val2=="@@citp")
				{
						
					$val=str_ireplace("@@citp","",$val);
						
					$text=$text."\n".$val;
					$sql="Update versetti SET testo_ita = '$text' WHERE id_versetti=$id";
					//echo "<hr>$sql";
					mysql_query($sql,$db);
					$err=mysql_error($db);
					if ($err)
					{
						echo "<br>$sql <br> $err<hr>";
					}

					$text2=$text2."\n<div class=\"p\">".$val."</div>";

					$sql="Update versetti SET testo_ita_mark = '$text2' WHERE id_versetti=$id";
					//echo "<hr>$sql";
					mysql_query($sql,$db);
					$err=mysql_error($db);
					if ($err)
					{
						echo "<br>$sql <br> $err<hr>";
					}

				}
				if ($val2=="@@citz")
				{
					$val=str_ireplace("@@citz","",$val);
					$text=$text."\n".$val;
					$sql="Update versetti SET testo_ita = '$text' WHERE id_versetti=$id";
					//echo "<hr>$sql";
					mysql_query($sql,$db);
					$err=mysql_error($db);
					if ($err)
					{
						echo "<br>$sql <br> $err<hr>";
					}

					$text2=$text2."\n<div class=\"z\">".$val."</div>";

					$sql="Update versetti SET testo_ita_mark = '$text2' WHERE id_versetti=$id";
					//echo "<hr>$sql";
					mysql_query($sql,$db);
					$err=mysql_error($db);
					if ($err)
					{
						echo "<br>$sql <br> $err<hr>";
					}

				}
				break;

			default:
				$val=str_ireplace("@@citz","",$val);
				$text=$text."\n".$val;
				$sql="Update versetti SET testo_ita = '$text' WHERE id_versetti=$id";
				//echo "<hr>$sql";
				mysql_query($sql,$db);
				$err=mysql_error($db);
				if ($err)
				{
					echo "<br>$sql <br> $err<hr>";
				}

				$text2=$text2."\n<div class=\"s\">".$val."</div>";

				$sql="Update versetti SET testo_ita_mark = '$text2' WHERE id_versetti=$id";
				//echo "<hr>$sql";
				mysql_query($sql,$db);
				$err=mysql_error($db);
				if ($err)
				{
					echo "<br>$sql <br> $err<hr>";
				}
		}



	}
}

//dumpa($fetchati[1],1);


//for ($j=0;$j<2;$j++)
//{
//	$val=$fetchati[1][$j];
////	echo $val;
//	$vals.=$val;
//}

//
//		}
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


	$pak="";
	//dumpa($GLOBALS,1);
	foot();

	?>