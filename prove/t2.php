<?php 
//$array = array(0 => 'blue', 1 => 'red', 2 => 'green', 3 => 'red');

echo "<pre>";
var_dump  ($array);

$array[]="blue";
$array[]="arancio";
$array[]="verde";
$array[]="rosso";
$array[]="nero";
var_dump  ($array);
echo "</pre>";
echo array_search('verde', $array)."<br>"; // $key = 2;
echo array_search('nero', $array);   // $key = 1;
echo "<hr>";
$libr["italiano"][1]="Genesi";
$libr["italiano"][]="Esodo";
$libr["italiano"][]="Levitico";
$libr["italiano"][]="Numeri";
echo "<pre>";
var_dump  ($libr["italiano"]);
echo "</pre>";

echo array_search('Levitico', $libr["italiano"])."<br>"; // $key = 2;

?>