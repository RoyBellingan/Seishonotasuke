<?php
//die("non si lanciano a mozzo le cose...");

ini_set("display_errors", "1");
ERROR_REPORTING(E_ALL);

define('ABSPATH', dirname(__FILE__) . '/');

include_once ("../../util/funkz.php");
include_once ("../../util/elenco_lib.php");
include_once ("../../includes/snoopy.php");

$snoopy = new Snoopy;
$snoopy -> accept = "application/json, text/javascript, */*; q=0.01";

//$snoopy->rawheaders["X-Requested-With"] = "XMLHttpRequest";
//$snoopy->rawheaders["Accept-Language"] = "en-us,en;q=0.5";
//$snoopy->rawheaders["Accept-Encoding"] = "gzip, deflate";
//$snoopy->_httpversion="HTTP/1.1";
$snoopy -> agent = "Mozilla/5.0 (X11; Linux x86_64; rv:14.0) Gecko/20100101 Firefox/14.0.1";
//$snoopy->fetchtext("http://wol.jw.org/it/wol/h/r6/lp-i");

//$snoopy->fetchtext("http://wol.jw.org/wol/bc/r6/lp-i/1001060004/5");
//$snoopy->fetchtext("http://localhost");
//printa ($snoopy);
//die();
$pack = file_get_contents("libri/it/Genesi");
//echo $pack;
$le = strlen($pack);

//print_r($le);
//exn();

$pos1 = strpos($pack, "id=\"content\"");
//echo $pos1;
//exn();
$i = 0;

//$fp = fopen("spam_link1", 'w');
//$fpj = fopen("spam_json1", 'w');
$jjj = 0;
mb_internal_encoding("UTF-8");
while ($jjj < 50) {
	$jjj++;
	$pos2 = mb_strpos($pack, "</span>", $pos1) + 7;
	//echo $pos2;
	//exn();

	$pos3 = mb_strpos($pack, "<span", $pos2 + 1);
	//echo $pos3;
	//exn();

	$pos4 = mb_strpos($pack, "</p>", $pos2 + 1);
	
	$pos5 = mb_strpos($pack, "</div>", $pos2 + 1);
	//echo $pos4;
	//exn();

	if ($pos3 < $pos4) {
		$end = $pos3;
	} else {
		$end = $pos4;
	}
	
	if ($pos5 < $end){
		
		echo "<hr>versetto finito gg";
		break;
	}

	$off = $end - $pos2;
	$str = mb_substr($pack, $pos2, $off);

	//Rewrittiamo i link per farli fungere plz
	http:
	//wol.jw.org/wol/bc/r6/lp-i/
	$str = str_replace("href='/it", "href='http://wol.jw.org", $str);
	//Don't ask
	preg_match_all("/(https?|ftp|telnet):\/\/((?:[a-z0-9@:.-]|%[0-9A-F]{2}){3,})(?::(\d+))?((?:\/(?:[a-z0-9-._~!$&()*+,;=:@]|%[0-9A-F]{2})*)*)(?:\?((?:[a-z0-9-._~!$&'()*+,;=:\/?@]|%[0-9A-F]{2})*))?(?:#((?:[a-z0-9-._~!$&'()*+,;=:\/?@]|%[0-9A-F]{2})*))?/i", $str, $match, PREG_SET_ORDER);
	//printa($match);
	/*
	 foreach ($match as $key => $value) {
	 $j++;
	 $link=$value[0];
	 $snoopy->fetchtext($link);
	 $len = fwrite($fp,"@link $j". $snoopy->results . "\n\n\n\n");

	 $json=print_r(json_decode($snoopy->results),TRUE);
	 fwrite($fpj,"@link $j". $json . "\n\n\n\n");
	 }
	 */
	$str_nnns=$str = trim($snoopy -> _striptext($str));

	//echo "Posizioni dei link:";


	$flag=true;
	$i=0;
	unset($pos);
	$pos[0]=0;
	//$pos[1]=0;
	while($flag==true){
				
		@$pos[$i]=mb_strpos($str,"+",$pos[abs($i-1)]+1);
		
		if ($pos[$i]==false){
			$flag=false;
			unset ($pos[$i]);
			break;
		}
	//	printa($pos);
		if ($i>50){
			break;	
		}
		$i++;
		
		
	}




	$strz = str_replace("+", " ", $str);
	$strz = str_replace("  ", " ", $strz);
	
	$flag=true;
	$i=0;
	unset($pos_1);
	$pos_1[0]=0;
	//$pos[1]=0;
	while($flag==true){
				
		@$pos_1[$i]=mb_strpos($strz,"*",$pos_1[abs($i-1)]+1);
		
		if ($pos_1[$i]==false){
			$flag=false;
			unset ($pos_1[$i]);
			break;
		}
	//	printa($pos_1);
		if ($i>50){
			break;	
		}
		$i++;
		
		
	}
	//printa($pos_1);

	echo "Versetto $jjj : \n<br>" . $str_nnns . "\n\n\n\n\n";
	//exb();
	$str = str_replace("*", " ", $str);
	$str = str_replace("+", " ", $str);
	$str = trim(str_replace("  ", " ", $str));
	$str = trim(str_replace("  ", " ", $str));
	$str = trim(str_replace("  ", " ", $str));
	//exb();
	//echo "Il Versetto $jjj : \n" . $str . "\n\n\n\n\n";

	//exb();
	//echo "Repositioning...";

	$i=0;


/*
$pos_1[$i++]=1;
$pos_1[$i++]=10;
$pos_1[$i++]=11;
$pos_1[$i++]=12;
$pos_1[$i++]=13;
$pos_1[$i++]=14;
$pos_1[$i++]=15;
$pos_1[$i++]=16;
$pos_1[$i++]=17;
$pos_1[$i++]=18;
$pos_1[$i++]=19;
*/

	foreach ($pos_1 as $key => $value) {
		//exb();
		//echo "trim a $value";
		$stra = mb_substr($str, 0, $value);
		$strb = mb_substr($str, $value);

		
		$str = $stra . "*" . $strb;
		//exb();
		//exn();		
		//echo "La prima parte è lunga ".mb_strlen($stra)." ed è ->$stra<-";
	}

	//exb();
	//echo "$str";
	
	foreach ($pos as $key => $value) {
		$stra = mb_substr($str, 0, $value);
		//exb();
		//echo "trim a $value";
		//exb();
		//echo "$stra" . "-";

		$strb = mb_substr($str, $value);

		$str = $stra . "+" . $strb;

	}

	exb();
	echo "$str";

if ($str_nnns!=$str){
	die("differenza nelle stringhe a $jjj");
}
	exn();
	exh();

	$pos1 = $end;

	
}
//