<?php 
ini_set('memory_limit', '-1');
error_reporting(E_ALL); ini_set('display_errors', '1');
$Nn="NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN\n";

for($i=2;$i<=21;$i++)
{
if(file_exists("chromosomes/ch-".$i))
{
//$handle=fopen("chromosomes/ch-".$i,"w");
$initial=file_get_contents("chromosomes/ch-".$i);
$final=str_replace($Nn,"",$initial);
$final=str_replace("N","",$final);
file_put_contents("chromosomes/ch-".$i,$final);
}
}

/*$buffer = fgets($handle, 4096); // Read a line.
$buffer = preg_replace('/\s+/',' ',$buffer);
list($a,$b)=explode(" ",$buffer);//Separate string by Spaces
*/


?>
