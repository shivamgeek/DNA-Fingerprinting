<?php
error_reporting(E_ALL); ini_set('display_errors', '1');
ini_set('memory_limit', '-1');

#################################################################################

function distribute(){
	$chPath='chromosomes/';
	$opPath='operations/';
	if(filesize($opPath."OPERATIONS.txt")!=0){
		recordAndSendTask();
	}
	else if(filesize($opPath."TEMPOPR.txt")!=0){
		rename($opPath."OPERATIONS.txt",$opPath."OPERATIONS1.txt");
		rename($opPath."TEMPOPR.txt",$opPath."OPERATIONS.txt");
		rename($opPath."OPERATIONS1.txt",$opPath."TEMPOPR.txt");
		recordAndSendTask();
	}
	else{
		echo "Successful";
	}
}

#################################################################################

function appendToTemp($append){
	$chPath='chromosomes/';
	$opPath='operations/';
	file_put_contents($opPath.'TEMPOPR.txt',$append,FILE_APPEND);
}

#################################################################################

function deleteOperation($oper){
	$opPath='operations/';
	$full=file_get_contents($opPath.'OPERATIONS.txt');
	$newData=str_replace($oper,'',$full);
	file_put_contents($opPath.'OPERATIONS.txt',$newData);
}

#################################################################################

function recordAndSendTask(){
	$chPath='chromosomes/';
	$opPath='operations/';
	$han=fopen($opPath.'OPERATIONS.txt',"r");
	$opr=fgets($han);
	appendToTemp($opr);
	deleteOperation($opr);
	$oprs=explode(" ",$opr);
	fclose($han);
	$initialOff=$oprs[0];
	$finalOff=$oprs[1];
	$str=$oprs[2];
	$ch=$oprs[3];
	$han1=fopen($chPath.'ch-'.$ch,"r");
	fseek($han1,$initialOff);
	$sequence=fread($han1,($finalOff-$initialOff+1));
	fclose($han1);
	$finalData=$initialOff."#".$finalOff."#".$str."#".$ch."#".$sequence;
	echo $finalData;
	

}

#####################################################################################

distribute();



?>