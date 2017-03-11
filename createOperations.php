<?php
error_reporting(E_ALL); ini_set('display_errors', '1');

############################################################################


function createTextFiles(){
	$chPath='chromosomes/';
	$opPath='operations/';
	$oper=fopen($opPath.'OPERATIONS.txt',"w");fwrite($oper,'');fclose($oper);
	$oper=fopen($opPath.'TEMPOPR.txt',"w");fwrite($oper,'');fclose($oper);
	$han=fopen($opPath."RESULT.txt","w");fwrite($han,'');fclose($han);
}

############################################################################

function addOperations($initialOff,$finalOff,$str,$ch)
{
	$chPath='chromosomes/';
	$opPath='operations/';
	$append=$initialOff.' '.$finalOff.' '.$str.' '.$ch.' '."\n";
	file_put_contents($opPath.'OPERATIONS.txt',$append,FILE_APPEND);
}

############################################################################
function createResultFile(){
	$opPath='operations/';
	$han=fopen($opPath."RESULT.txt","a");
	for($i=1;$i<=21;$i++){
	$val="#".$i." "."0 "."\n";
	fwrite($han,$val);
	}
	fclose($han);
}



###################################################################################
function createOperation()
{
	$chPath='chromosomes/';
	$opPath='operations/';
	$chunkSize=20000000;
	$initialOff=1;
	
	
	for($i=2;$i<=21;$i++)
	{
	if(file_exists($chPath."loci-".$i))
	{
	$handle=fopen($chPath."loci-".$i,"r");
	$str=fgets($handle,5);
	fclose($handle);

	while($initialOff<filesize($chPath.'ch-'.$i))
	{

	//$finalOff=breakSequence($initialOff,$chunkSize,$str);
	$finalOff=$initialOff+$chunkSize;
	addOperations($initialOff,$finalOff,$str,$i);
	$initialOff=$finalOff+1;
		}
		$initialOff=1;
	}
	}

}

############################################################################


createTextFiles();
createOperation();
createResultFile();
echo 'done creating operations file';




?>