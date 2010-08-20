<?php 

require("util/top_foot_inc.php");
require("includes/caching.php");
top();
connetti();
// require ( "funzioni.php" );
//require ("util/sphinxapi.php");


$cache=new cache();
dumpa($cache,1);
$cache->flush();
for ($i=0; $i<1000; $i++)
{
	
	$text="ciaociao2"; 
$cache->update($i,$i);
}


for ($i=0; $i<1000; $i++)
{
$da=$cache->select($i);
}

echo $da;  



foot();

?>