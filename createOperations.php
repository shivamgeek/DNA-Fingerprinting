<?php
//error_reporting(E_ALL); ini_set('display_errors', '1');
ini_set('memory_limit', '-1');

############################################################################
function debug($f) {
	echo "<script>console.log( 'f: " .$f. "' );</script>";
}

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

##################################################################################
function breakSequence($initialOff,$chunkSize,$str,$i) {
	$chPath='chromosomes/';
	$han1=fopen($chPath.'ch-'.$i,"r");
	#$han1=fopen($chPath."myfile.txt","r");

	$filesz=filesize($chPath.'ch-'.$i);
	#$filesz=filesize($chPath."myfile.txt");
	$finalOff=$initialOff+$chunkSize-1;
	$filesz--;
	if($finalOff >= $filesz) {
		return $filesz;
	}

	fseek($han1,$finalOff-3);//edge case

	#$sequence=fread($han1,$chunkSize+10000);
	#$sequence=fgetc($han1).getc($han1).getc($han1).getc($han1);
	$c=fgetc($han1);
	if($c!="\n") {
		$sequence=$c;
	}else {
		$sequence=fgetc($han1);
	}

	while(strlen($sequence)<4) {
		$c=fgetc($han1);
		if($c==false) {
			return $filesz;
		}
		if($c!="\n") {
			$sequence=$sequence.$c;
		}
	}
	#debug($sequence);
	#$sequence+=fgetc($han1);$sequence+=fgetc($han1);$sequence+=fgetc($han1);		
	#$filesz=filesize($chPath.'ch-'.$i);
	#fclose($han1);
	#$finalOff=min($finalOff, $filesz);
	$flag=false;
	$strlen=strlen($str);
	#$seqlen=$chunkSize+10000;
	if($sequence==$str) {
		$flag=true;
	}
	#$log=$sequence.substr($finalOff-$strlen, 2*$strlen);
	#echo "<script>console.log( 'Debug: " . $log .");</script>";
	$j=$strlen;
	
	$other="";
	$k=0;
	while($j>0 && $flag==false) {
		#debug(substr($sequence,$k,$j).$other);
		if(substr($sequence,$k,$j).$other==$str) {
			$finalOff=$finalOff+$k;
			$flag=true;
			break;
		}
		$j=$j-1;
		$k++;
		$char=fgetc($han1); //edge case

		if($char=="\n") {
		$other.=fgetc($han1);
		}else {
			$other.=$char;
		}
		if($char==false) {
			return $filesz;
		}
	}

	while($flag==true) {
			$flag=false;
			$c=fgetc($han1);
			$other;
			if($c!="\n") {
				$other=$c;
			}else {
				$other=fgetc($han1);
			}
			if($other==false) {
				return $filesz;
			}
			#debug($other);
			while(strlen($other)<4) {
				$c=fgetc($han1);
				if($c==false) {
					return $filesz;
				}
				if($c!="\n") {
				$other=$other.$c;
				}
			}
			#debug($other);
			if($other==$str) {
				$flag=true;
				$finalOff=$finalOff+4;
			}
	}
	fclose($han1);
	return $finalOff;

}


###################################################################################
function createOperation()
{
	$chPath='chromosomes/';
	$opPath='operations/';
	$chunkSize=10000000;
	$initialOff=0;
	$pass=$_GET['pass'];
	if($pass=="admin123"){
	
	//console.log("create operations");
	$han1=fopen($chPath.'ch-2',"r");
	#$han=fopen($chPath."myfile.txt","w");
	#fseek($han1,10226);
	#for($i=1;$i<=500;$i++) {
		
		// $ch=fgetc($han1).fgetc($han1).fgetc($han1).fgetc($han1);
		// $other="";
		// #$ch2=$other;
		// if($ch==$other) {
		// 	fputs($han,"true");
		// }
		// else {
		// 	fputs($han,"false");
		// }

		#$ch.=fgetc($han1);$ch+=fgetc($han1);$ch+=fgetc($han1);
		#if($ch!="\n")
		#fputs($han,$ch);
		#$seq2;
		#fputs($han,strlen($seq2));
		#echo "<script>console.log(" . $ch . ");</script>";
	#}
	#$final=breakSequence(24,8,"agat",0);
	#debug($final);
	for($i=2;$i<=21;$i++)
	{
	#$i=2;
	if(file_exists($chPath."loci-".$i))
	{
	$handle=fopen($chPath."loci-".$i,"r");
	#$log=file_get_contents($chPath."loci-".$i);
	#echo addcslashes($log, ' ');
	#echo "<script>console.log( 'File size: " . filesize($chPath.'loci-'.$i) . "' );</script>";
	$str=fgets($handle,5);
	//console.log(str);
	fclose($handle);
	
	#echo "<script>console.log( 'Offset: " .$final. "' );</script>";
	while($initialOff<filesize($chPath.'ch-'.$i))
	{
		#console.log(filesize($chPath.'ch-'.$i));
		$finalOff=$initialOff+$chunkSize;

		$finalOff=breakSequence($initialOff,$chunkSize,$str,$i);


		addOperations($initialOff,$finalOff,$str,$i);
		$initialOff=$finalOff+1;
	}
		$initialOff=0;
	}
	}//end of loop
echo '<body bgcolor="#99ccff"><h2>Done creating operations file</h2></body>';

}


else{
	echo '<body bgcolor="#99ccff"><h2>Authentication Failed</h2></body>';

}
}

############################################################################


createTextFiles();
createOperation();
createResultFile();



?>