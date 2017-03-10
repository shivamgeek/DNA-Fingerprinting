function getIter(){
	return location.search.substring(6);
}

//######################################################################################

function getData(){
	
	var data='';
	var xtp=new XMLHttpRequest();
	xtp.onreadystatechange=function(){
		if(xtp.readyState==4 && xtp.status==200){
			data=xtp.responseText;
			//doneLoading();
			}
			else{
				showLoading();
			}
	};

	xtp.open("POST",'distributeOperations.php',false);
	xtp.send();
	return data;
}

//######################################################################################

function computeSTR(data){
	var arr=data.split("#");
	var str=arr[2],dna=arr[4];
	var max=0,count=0;
	for(var i=0;i<dna.length;i++){
		if(dna.substring(i,i+4).toUpperCase()==str.toUpperCase()){
			count++;
			if(max<count){ max=count;}
			i+=3;
			}else{
				count=0;
			}
	}
	var computed=arr[0]+"#"+arr[1]+"#"+arr[2]+"#"+arr[3]+"#"+max;
	return computed;

}


//######################################################################################

function sendData(computed){
var arr=computed.split("#");
	var initialOff=arr[0],finalOff=arr[1],str=arr[2],ch=arr[3],max=arr[4];
	var xtp=new XMLHttpRequest();
	xtp.onreadystatechange=function(){
		if(xtp.readyState==4 && xtp.status==200){
			//done
			
		}
		else{
			//show loading
		}

	};
	var params="initialOff="+initialOff+"&finalOff="+finalOff+"&str="+str+"&ch="+ch+"&max="+max;
	xtp.open("POST","mergeOperations.php",false);
	xtp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xtp.send(params);
	console.log("COMPUTED DATA IS - "+computed);

}




//######################################################################################

function showLoading(){
document.getElementById('loading').innerHTML='<img src="graphics/gears.svg"></img>';
}

function doneLoading(){
document.getElementById('loading').innerHTML='Done loading';
}

//#############################################################################


function begin(){

	showLoading();
	var iter=getIter();
	for(var i=0;i<iter;i++){
		var data=getData();
		data=computeSTR(data);
		sendData(data);
	
	}
}