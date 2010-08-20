<?php
die('non si lanciano gli script a mozzo');

define('ABSPATH', dirname(__FILE__).'/');

include_once (ABSPATH."//util/elenco_lib.php");
include_once (ABSPATH."/util/top_foot_inc.php");
top();


$lingua="Español";
$lang="s";
$a="fix1";
$dimex=count($libr["$lingua"]);
//echo $dimex;
mkdir("libri/$lang/edit");
dumpa ($libr[$lingua],1);


for ($jj=1; $jj<67; $jj++)
//for ($jj=0; $jj<2; $jj++)
{
	$gen="";
	$gen2="";
	$error=false;
	$counter=0;
	//$libro_n="Псалмы";
	$libro_n=$libr[$lingua][$jj];
	$libro="libri/$lang/".$libr[$lingua][$jj];
	$pak=file_get_contents("$libro");
	if ($pak==FALSE)
	{
		echo "Errorissimo al libro $libro -> n° $jj <br>\n ";
	}
	//dumpa($pak,1);
	while ($error==false)
	{
		$counter++;
		//echo $counter;
		$hay="<capitolo_".$counter.">";
		$hay2="</capitolo_".$counter.">";
		//echo "Proper $lang; libro: $libro_n: cap $counter <br>";
		$pos=strpos($pak,$hay);
		$pos2=strpos($pak,$hay2,$pos)+strlen($hay2);
		$delta=$pos2-$pos;

		//dumpa ("<br><br> Cerco $hay -> Pos: $pos - $pos2 = $delta <br>",1);

		$capitolo=$cap[$counter]['Testo']=substr($pak,$pos,$delta);
		//echo $capitolo;
		$hay="<p class=\"title\">$libro_n ".$counter;
		$hay2="</form>";
//echo "HAY = $hay</br>";
		$pos=strpos($capitolo,$hay);
//echo " POS =$pos";
		if ($pos==false)
		{
			break;
		}

		$pos2=strpos($capitolo,$hay2,$pos)+strlen($hay2);
		$delta=$pos2-$pos;
		//echo "<br><br> Cerco $hay -> Pos: $pos - $pos2 = $delta <br>";

		$gen.="\n".substr($capitolo,$pos,$delta);
		//dumpa ($gen);

	}
	$gen=html_entity_decode($gen,ENT_QUOTES,"UTF-8");
	$gen=str_ireplace("<p class=\"title\">","<p class=\"title\">@@lib",$gen);
	$gen=str_ireplace("<p>","@@@@",$gen);
	$gen=str_ireplace("<p class=\"l\">","@@@@",$gen);
	$gen=str_ireplace("class=\"z\">","class=\"z\"><div>@@citz</div>",$gen);
	$gen=str_ireplace("class=\"p\">","class=\"p\"><div>@@citp</div>",$gen);
	$gen=str_ireplace("<span class=\"smallcaps\">","",$gen);
	$gen=str_ireplace("</span>","",$gen);
	$gen=str_ireplace("<i>","",$gen);
	$gen=str_ireplace("</i>","",$gen);
	
	
	 
	$preg="|(<[^>]+>)([^<>]*)|";
	//$preg="|<[^>]+>(.*)</[^>]+>|U";
	$fetchati=megafetcher($gen,$preg,PREG_PATTERN_ORDER);
	//dumpa($fetchati[2],1);
	
	foreach ($fetchati[2] as $row)
	{
		if ($row!="\n")
		{
			//$r=trim($row);
			
			$gen2.=trim($row);
		}
			
	}
	
	$gen=preg_replace("([0-9]+)\n","\n</br>\\0 ",$gen2);
	$gen=str_ireplace("@@lib","\n@@lib",$gen);
	$gen=str_ireplace("@@lib\n</br>","@@lib",$gen);
	$gen=str_ireplace("@@citz","\n@@citz",$gen);
	$gen=str_ireplace("@@citp","\n@@citp",$gen);
	$gen=str_ireplace("  "," ",$gen);
	$gen=preg_replace("(@@@@)","\n<p></p>\n",$gen);
	$gen=preg_replace("(\n\n)","\n",$gen);
	//$gen=preg_replace("(\n\n)","\n",$gen);
	
	//dumpa ($gen2);
	
	
	$edit="libri/$lang/edit/".$libr[$lingua][$jj].$a;
	$pak=file_put_contents($edit,$gen);
}




foot();