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

postMessage(getData());