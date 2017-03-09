<?php
error_reporting(E_ALL); ini_set('display_errors', '1');
include 'path.php';


function updateOperations($initialOff,$finalOff,$str,$ch)
{
$chPath='chromosomes/';
$opPath='operations/';

$append=$initialOff.' '.$finalOff.' '.$str.' '.$ch.' '."\n";
file_put_contents($opPath.'OPERATIONS.txt',$append,FILE_APPEND);
}



function createOperation()
{
$chPath='chromosomes/';
$opPath='operations/';
$chunkSize=5000;
$initialOff=1;
$oper=fopen($opPath.'OPERATIONS.txt',"w");
fwrite($oper,'');
fclose($oper);
$oper=fopen($opPath.'TEMPOPR.txt',"w");
fwrite($oper,'');
fclose($oper);

for($i=2;$i<=21;$i++)
{
if(file_exists("chromosomes/loci-".$i))
{
$handle=fopen("chromosomes/loci-".$i,"r");
$str=fgets($handle,5);
fclose($handle);

while($initialOff<filesize($chPath.'ch-'.$i))
{

//$finalOff=breakSequence($initialOff,$chunkSize,$str);
$finalOff=$initialOff+$chunkSize;
updateOperations($initialOff,$finalOff,$str,$i);
$initialOff=$finalOff+1;
}
$initialOff=1;
}
}

}





createOperation();
echo 'done creating operations file';



















?>