function getIter(){
	return location.search.substring(6);
}



//######################################################################################

function changeName(change){
document.getElementById('change').innerHTML=change;
}

function showImage(pic){
	document.getElementById('loading').innerHTML='<img height='+60+'% width ='+60+'% src="graphics/'+pic+'"></img>';
}

function completed(){
	document.getElementById('start').style.visibility="hidden";
	document.getElementById('home').style.visibility="visible";
}


//#############################################################################



function run(){
	var iter=getIter();
	begin(iter);
}

function verify() {
	//completed();
	var verifying = new Worker("verifyOp.js");
	verifying.onmessage=function(event) {
		var data=event.data;
		document.getElementById('change').innerHTML=data;
	}
}

function begin(iter){
	if(iter>0){
	completed();
		document.getElementById('iterations').innerHTML="Iteration Left: "+iter;
		var data;
	
		var downloading = new Worker("getData.js");
		changeName("DOWNLOADING DATA");
		showImage("downloading2.gif");

		downloading.onmessage=function(event){
			var downloadedData=event.data;
			if(downloadedData!="end"){
				
			
			
			changeName("PROCESSING DATA");
			showImage("processing1.gif");
			var processing=new Worker("computeSTR.js");
			processing.postMessage(downloadedData);

			processing.onmessage=function(event){
				var processedData=event.data;
				//console.log("data processed :"+processedData);
				var sending=new Worker("sendData.js");
				showImage("uploading1.gif");
				sending.postMessage(processedData);

				sending.onmessage=function(event){
					changeName("COMPLETED");
					showImage("done1.gif");
					begin(--iter);
				}
			}
			}
		else{
				iter=0;
				document.getElementById('iterations').innerHTML="";
				showImage("done1.gif");
				changeName("The DNA Fingerprinting procedure has already been completed!");
			}

	}


		}	 else{
			document.getElementById('iterations').innerHTML="No more Iterations";
			document.getElementById('thanks').innerHTML="Thank you for donating CPU Cycles!";
		}

	
	}