function getData(){
    console.log("1. Verifying data from network");
    var data='';
    var xtp=new XMLHttpRequest();
    xtp.onreadystatechange=function(){
        if(xtp.readyState==4 && xtp.status==200){
            data=xtp.responseText;
            //doneLoading();

            }
            
    };

    xtp.open("POST",'identify.php',false);
    xtp.send();
    console.log("2. Verification done from network");
    return data;
}

postMessage(getData());