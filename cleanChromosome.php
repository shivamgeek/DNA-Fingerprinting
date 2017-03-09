<?php 
ini_set('memory_limit', '-1');
error_reporting(E_ALL); ini_set('display_errors', '1');

function cleanDNA(){
	$chPath='chromosomes/';
	$opPath='operations/';
	$Nn="NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN\n";

	for($i=2;$i<=21;$i++)
	{
	if(file_exists($chPath/."ch-".$i))
	{
	$initial=file_get_contents($chPath/."ch-".$i);
	$final=str_replace($Nn,"",$initial);
	$final=str_replace("N","",$final);
	file_put_contents($chPath/."ch-".$i,$final);
	}
	}
}

cleanDNA();
?>
