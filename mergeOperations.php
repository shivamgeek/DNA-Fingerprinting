<?php
error_reporting(E_ALL); ini_set('display_errors', '1');

#####################################################################################

function merge(){
	$chPath='chromosomes/';
	$opPath='operations/';
	//$initialOff=$_POST['initialOff'];
	//$finalOff=$_POST['finalOff'];
	$ch=17;#$_POST['ch'];
	$freq=4;#$_POST['freq'];
	//$str=$_POST['str'];

	//$oper=$initialOff.' '.$finalOff.' '.$str.' '.$ch.' '."\n";
	//deleteOperation($oper);
	$line=0;
	$han=fopen($opPath."RESULT.txt","a+");
	for($i=1;$i<=$ch;$i++){
	$line=fgets($han);
	}
	fclose($han);
	$data=explode(" ",$line);
	$freqOld=trim($data[1]);

	if($freqOld<$freq){
		$res=file_get_contents($opPath."RESULT.txt");
		$newData=str_replace("#".$ch." ".$freqOld,"#".$ch." ".$freq." ",$res);
		file_put_contents($opPath.'RESULT.txt',$newData);
	}
}

#####################################################################################

function deleteOperation($oper){
	$opPath='operations/';
	$full=file_get_contents($opPath.'TEMPOPR.txt');
	$newData=str_replace($oper,'',$full);
	file_put_contents($opPath.'TEMPOPR.txt',$newData);
}

#####################################################################################

merge();




?>