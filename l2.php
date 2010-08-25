<?php  
//Crea per l'ajax dei capitoli per i libri
$l=$_GET['l'];

$libric[1]=50;
$libric[2]=40;
$libric[3]=27;
$libric[4]=36;
$libric[5]=34;
$libric[6]=24;
$libric[7]=21;
$libric[8]=4;
$libric[9]=31;
$libric[10]=24;
$libric[11]=22;
$libric[12]=25;
$libric[13]=29;
$libric[14]=36;
$libric[15]=10;
$libric[16]=13;
$libric[17]=10;
$libric[18]=42;
$libric[19]=150;
$libric[20]=31;
$libric[21]=12;
$libric[22]=8;
$libric[23]=66;
$libric[24]=52;
$libric[25]=5;
$libric[26]=48;
$libric[27]=12;
$libric[28]=14;
$libric[29]=3;
$libric[30]=9;
$libric[31]=1;
$libric[32]=4;
$libric[33]=7;
$libric[34]=3;
$libric[35]=3;
$libric[36]=3;
$libric[37]=2;
$libric[38]=14;
$libric[39]=4;
$libric[40]=28;
$libric[41]=16;
$libric[42]=24;
$libric[43]=21;
$libric[44]=28;
$libric[45]=16;
$libric[46]=16;
$libric[47]=13;
$libric[48]=6;
$libric[49]=6;
$libric[50]=4;
$libric[51]=4;
$libric[52]=5;
$libric[53]=3;
$libric[54]=6;
$libric[55]=4;
$libric[56]=3;
$libric[57]=1;
$libric[58]=13;
$libric[59]=5;
$libric[60]=5;
$libric[61]=3;
$libric[62]=5;
$libric[63]=1;
$libric[64]=1;
$libric[65]=1;
$libric[66]=22;

http://roy.selfip.org/l?l=61&c=2&v=13
$var="";
for ($i=1; $i<$libric[$l]+1;$i++)
{
	$t=$i%10;
	if ($t==0)
	{
$tm=<<<EOD
	<a	href="l.php?l=$l&c=$i"
	class="jtip"
>$i</a><br>
EOD;
	}
	else
	{

	$tm=<<<EOD
	<a	href="l.php?l=$l&c=$i"
	class="jtip"
>$i</a>
EOD;
	}
	$var.=" $tm ";
}
echo $var;
?>
