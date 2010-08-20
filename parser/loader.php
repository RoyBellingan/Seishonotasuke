<?php
die ('non si lanciano gli script a mozzo...');

define('ABSPATH', dirname(__FILE__).'/');

include_once(ABSPATH."util/top_foot_inc.php");
include_once (ABSPATH."/util/top_foot_inc.php");
include_once (ABSPATH."/util/elenco_lib.php");
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
echo "si";

//mysql_query("TRUNCATE TABLE `versetti`;",$db);
//mysql_query("TRUNCATE TABLE `spacer`;",$db);

$error=false;


$dimex=count($libr)+1;

//$lingua="Español";
$lingua="English";
$testo_db=$lingua."_text";
$testo_mark_db=$lingua."_mark";
//$lang="s";
$lang="e";

$a="fix1";

$tabella="versetti";


dumpa ($libr["$lingua"],1);

//die();

//dumpa($pak,1);
//mysql_query("TRUNCATE TABLE $tabella;",$db);

for ($jj=1; $jj<67; $jj++)
//for ($jj=2; $jj<3; $jj++)
{

	$refer=$jj;
	$libro=$libr[$lingua][$jj];
	$lib5=substr($libro,0,5);
	$libro_f="libri/$lang/edit/".$libro."fix1";
	echo $libro_f;
	$pak=file_get_contents("$libro_f");
	//

	$arr=explode("\n",$pak);
//dumpa($arr,1);
	$gen=preg_replace("  "," ",$arr);

	//dumpa($arr,1);
	$counter=1;
	$le=sizeof($arr);
	//echo "<br>$le";
	$cap=1;
	for ($i=0;$i<$le;$i++)
	//for ($i=22;$i<25;$i++)
	{
	//	echo "<br>$i -> $arr[$i]\n";
	//	dumpa($arr[$i],1);
		$val=trim($arr[$i]);

		$val2=substr($val,0,5);
	//	echo "-$val-\n";
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

					//					$sql="Insert into spacer (libro,capitolo,versetto,span,end) Value ('$refer','$cap','$div_start','$div_delta',$div_end);";
					//					mysql_query($sql,$db);
					//					$err=mysql_error($db);
					//					if ($err)
					//					{
					//						echo "<br>$sql <br> $err<hr>";
					//					}



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
				//$sql="Insert INTO $tabella SET $testo_db =  '$text'";

				$sqlb="Select id_versetti FROM versetti WHERE libro = $refer AND capitolo = $cap AND versetto = $versetto";
				$frok=mysql_query($sqlb,$db);
				$err=mysql_error($db);
				if ($err)
				{
					echo "<br>$sqlb <br> $err<hr>";
				}
				$id=mysql_fetch_array($frok,0);
				$id=$id[0];


				//$sql="Insert Into $tabella (id_versetti,text) Value ($id,'$text') ;";
				$sql="UPDATE $tabella SET $testo_db =  '$text' WHERE id_versetti = $id";
				//echo "<hr>$sql";
				mysql_query($sql,$db);
				$err=mysql_error($db);
				if ($err)
				{
					echo "<br>$sqlb <br> $sql <br> $err<hr> ";
				}
				$id=mysql_insert_id($db);
				break;

			case "@@cit":

				$sqlb="Select id_versetti FROM versetti WHERE libro = $refer AND capitolo = $cap AND versetto = $versetto";
				$frok=mysql_query($sqlb,$db);
				$err=mysql_error($db);
				if ($err)
				{
					echo "<br>$sqlb <br> $err<hr>";
				}
				$id=mysql_fetch_array($frok,0);
				$id=$id[0];



				//echo "citazione -> $val";
				$val2=substr($val,0,6);
				if ($val2=="@@citp")
				{

					$val=str_ireplace("@@citp","",$val);

					$text=$text."\n".$val;
						
					$sql="Update $tabella SET $testo_db = '$text' WHERE id_versetti = $id";
					//echo "<hr>$sql";
					mysql_query($sql,$db);
					$err=mysql_error($db);
					if ($err)
					{
						echo "<br>$sql <br> $err<hr>";
					}

					$text2=$text2."\n<div class=\"p\">".$val."</div>";

					$sql="Update $tabella SET $testo_mark_db = '$text2' WHERE id_versetti = $id";
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
					$sql="Update $tabella SET $testo_db = '$text' WHERE id_versetti = $id";
					//echo "1 ->$sql<br>";
					//echo "<hr>$sql";
					mysql_query($sql,$db);
					$err=mysql_error($db);
					if ($err)
					{
						echo "<br>$sql <br> $err<hr>";
					}

					$text2=$text2."\n<div class=\"z\">".$val."</div>";

					$sql="Update $tabella SET $testo_mark_db = '$text2' WHERE id_versetti = $id";
					//echo "2 -> $sql<br>";
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
				$sql="Update $tabella SET $testo_db = '$text' WHERE id_versetti = $id";
				//echo "<hr>$sql";
				mysql_query($sql,$db);
				$err=mysql_error($db);
				if ($err)
				{
					echo "<br>$sql <br> $err<hr>";
				}

				$text2=$text2."\n<div class=\"s\">".$val."</div>";

				$sql="Update $tabella SET $testo_mark_db = '$text2' WHERE id_versetti = $id";
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