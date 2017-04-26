<?php
error_reporting(E_ALL); ini_set('display_errors', '1');
ini_set('memory_limit', '-1');

$chPath='chromosomes/';
$opPath='operations/';
$dbPath='database/';

if(filesize($opPath."OPERATIONS.txt")!=0 || filesize($opPath."TEMPOPR.txt")!=0 ){  
        echo "Some opeations for DNA profiling are remaining.";
}else {
    $profile=array();
    $lowprob=array();
    $highprob=array();

    $lines = file($opPath.'RESULT.txt', FILE_IGNORE_NEW_LINES);
    for($i=0;$i<sizeof($lines);$i=$i+1) {
        $line=explode(' ',$lines[$i]);
        $num=substr($line[0],1);
        if(file_exists($chPath."loci-".$num)) {
            $profile[]=$line[1];
            //echo $line[1]."<br>";
        }
    }

    //profile got build
    // for($i=0;$i<sizeof($profile);$i++) {
    //     echo "<script>console.log( 'Debug profile: " . $profile[$i] . "' );</script>";
    // }
    
    //Read the person profiles and look for a match
    for($j=1;$j<=5;$j++) {
        $tmp=array();
        if(file_exists($dbPath."person".$j.".txt")) {
            $lines = file($dbPath."person".$j.".txt", FILE_IGNORE_NEW_LINES);
            for($i=0;$i<sizeof($lines);$i++) {
            $line=explode(' ',$lines[$i]);
            $num=substr($line[0],1);
            if(file_exists($chPath."loci-".$num)) {
                $tmp[]=$line[1];
            }

            }

        }

        //profile got build
        // for($i=0;$i<sizeof($tmp);$i++) {
        //     echo "<script>console.log( 'Debug tmp: " . $tmp[$i] . "' );</script>";
        // }    ``````````
        
        //comparison between profile and tmp
        $moder=0;
        $high=0;
        $sz=sizeof($profile);
        //echo "Profile-<br>";
        //var_dump($profile);
        //echo "Temp-<br>";
        //var_dump($tmp);
        for($i=0;$i<$sz;$i++) {
            if($profile[$i]==$tmp[$i]) {
                
                $high++;
            }else if( abs($profile[$i]-$tmp[$i]) <=2 ) {
                $moder++;
            }
        }

        //echo " 'Debug tmp: " .$j." ". $moder ." ".$high. "' );</script>";   

        if($high>=$sz/2) {
            $highprob[]=$j;

        }else if($moder>=$sz/2) {
            $lowprob[]=$j;  
        }
    
 }

 //echo "Debug tmp: " .$lowprob[0]." ".$highprob[0];
 //var_dump($highprob);
 //echo $lowprob[0]." ".$highprob[0];
 $flag=False;
 if(sizeof($highprob)!=0) {
    echo "The profile has high probability match with ";
    for($iz=0;$iz<sizeof($highprob)-1;$iz++){
        echo "person".$highprob[$iz].",";

    }
    echo "person".$highprob[sizeof($highprob)-1].'.';
    $flag=True;
 }
 if(sizeof($lowprob)!=0) {
    echo "<br> The profile has low probability match with ";
    for($iz=0;$iz<sizeof($lowprob)-1;$iz++){
        echo "person".$lowprob[$iz].",";
    }
    echo "person".$lowprob[sizeof($lowprob)-1].'.';
    $flag=True;
 }
 if(!$flag) {
     echo "The profile has no match in the database.";
 }
 
 // if(sizeof($highprob)>0) {
 //    $text="The profile has high probability match with ";
 //    for($i=0;$i<sizeof($highprob)-1;$i++) {
 //        $text+=($highprob[i]+',');
 //    }
 //    $text+=($highprob[sizeof($highprob)-1]+'.');
 //    echo $text;
 //    echo "<br>"
 // }
 // if(sizeof($lowprob)>0) {
 //    $text="The profile has low probability match with ";
 //    for($i=0;$i<sizeof($lowprob)-1;$i++) {
 //        $text+=($lowprob[i]+',');
 //    }
 //    $text+=($lowprob[sizeof($lowprob)-1]+'.');
 //    echo $text;
 // }

}




?>