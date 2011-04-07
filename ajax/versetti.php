<?php 

$cities = array(
	array('nome'=>'New York', cognome=>'NY', id_persona=>'10001'),
	array('nome'=>'Los Angeles', cognome=>'CA', id_persona=>'90001'),
	array('nome'=>'Chicago', cognome=>'IL', id_persona=>'60601'),
	array('nome'=>'Houston', cognome=>'TX', id_persona=>'77001'),
	array('nome'=>'Phoenix', cognome=>'AZ', id_persona=>'85001'),
	array('nome'=>'Philadelphia', cognome=>'PA', id_persona=>'19019'),
	array('nome'=>'San Antonio', cognome=>'TX', id_persona=>'78201'),
	array('nome'=>'Dallas', cognome=>'TX', id_persona=>'75201'),
	array('nome'=>'San Diego', cognome=>'CA', id_persona=>'92101'),
	array('nome'=>'San Jose', cognome=>'CA', id_persona=>'95101'),
	array('nome'=>'Detroit', cognome=>'MI', id_persona=>'48201'),
	array('nome'=>'San Francisco', cognome=>'CA', id_persona=>'94101'),
	array('nome'=>'Jacksonville', cognome=>'FL', id_persona=>'32099'),
	array('nome'=>'Indianapolis', cognome=>'IN', id_persona=>'46201'),
	array('nome'=>'Austin', cognome=>'TX', id_persona=>'73301'),
	array('nome'=>'Columbus', cognome=>'OH', id_persona=>'43085'),
	array('nome'=>'Fort Worth', cognome=>'TX', id_persona=>'76101'),
	array('nome'=>'Charlotte', cognome=>'NC', id_persona=>'28201'),
	array('nome'=>'Memphis', cognome=>'TN', id_persona=>'37501'),
	array('nome'=>'Baltimore', cognome=>'MD', id_persona=>'21201'),
);	
 
// Cleaning up the term
$term = trim(strip_tags($_GET['term']));

$par= trim(strip_tags($_GET['c']));


// Rudimentary search


if ($par=="c")
{
$matches = array();
foreach($cities as $nome){
	if(stripos($nome['cognome'], $term) !== false){
		// Add the necessary "value" and "label" fields and append to result set
		$nome['value'] = $nome['nome'];
		$nome['label'] = "{$nome['cognome']}, {$nome['nome']}, {$nome['id_persona']}";
		$matches[] = $nome;
	}
}
 
// Truncate, encode and return the results
$matches = array_slice($matches, 0, 5);
print json_encode($matches);
}

if ($par=="n")
{$matches = array();
foreach($cities as $nome){
	if(stripos($nome['nome'], $term) !== false){
		// Add the necessary "value" and "label" fields and append to result set
		$nome['value'] = $nome['nome'];
		$nome['label'] = "{$nome['nome']}, {$nome['cognome']} {$nome['id_persona']}";
		$matches[] = $nome;
	}
}
 
// Truncate, encode and return the results
$matches = array_slice($matches, 0, 5);
print json_encode($matches);
}

if ($par=="i")
{$matches = array();
foreach($cities as $nome){
	if(stripos($nome['id_persona'], $term) !== false){
		// Add the necessary "value" and "label" fields and append to result set
		$nome['value'] = $nome['nome'];
		$nome['label'] = "{$nome['id_persona']}  {$nome['nome']}, {$nome['cognome']} ";
		$matches[] = $nome;
	}
}
 
// Truncate, encode and return the results
$matches = array_slice($matches, 0, 5);
print json_encode($matches);
}
?>