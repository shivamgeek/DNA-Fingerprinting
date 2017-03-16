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
	return "Done!!!";

}


self.addEventListener('message',function(e){
self.postMessage(sendData(e.data));
},false);

