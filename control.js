function getIter(){
	return location.search.substring(6);
}

//######################################################################################

function getData(){
	console.log("1. Fetching data from network");
	var data='';
	var xtp=new XMLHttpRequest();
	xtp.onreadystatechange=function(){
		if(xtp.readyState==4 && xtp.status==200){
			data=xtp.responseText;
			//doneLoading();
			}
			
	};

	xtp.open("POST",'distributeOperations.php',false);
	xtp.send();
	console.log("2. Data received from network");
	return data;
}

//######################################################################################


function computeSTR(data){
	console.log("3. Beginning processing on data");
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
	console.log("4. Processing done. DATA is - "+computed);
	return computed;

}



function computeSTR1(data){
	console.log("3. Beginning processing on data");
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
	console.log("4. Processing done. DATA is - "+computed);
	return computed;

}


//######################################################################################

function sendData(computed){
	console.log("5. Sending data to server");
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
	console.log("6. Data sent to server");

}




//######################################################################################

function showLoading(){
document.getElementById('loading').innerHTML='<img src="graphics/gears.svg"></img>';
}

function doneLoading(){
document.getElementById('loading').innerHTML='Done loading';
}

function showImage(pic){
	document.getElementById('loading').innerHTML='<img src="graphics/'+pic+'"></img>';
}

//#############################################################################

function begin(){
	
	setTimeout(begin1,200);
}


function begin1(){
	var iter=getIter();
	var data;
	for(var i=1;i<=iter;i++){

		showImage("downloading.gif");
		data=getData();
		showImage("processing.gif");
		data=computeSTR(data);
		showImage("uploading.gif");
		sendData(data);


		/*setTimeout(function(){data=getData();});

		setTimeout(function(){ data=computeSTR(data); });
		showImage("processing.gif");
		
		setTimeout(function(){ showImage("uploading.gif"); sendData(data); });


setTimeout(function(){ showImage("downloading.gif"); },15100*i);
		setTimeout(function(){data=getData();},16000*i);

		setTimeout(function(){ showImage("processing.gif"); },20000*i);
		setTimeout(function(){ data=computeSTR(data); },23000*i);
		
		setTimeout(function(){ showImage("uploading.gif"); },27000*i);
		setTimeout(function(){  sendData(data); },30000*i);*/
		
	
	}
	showImage("done.png");
}