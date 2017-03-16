function getIter(){
	return location.search.substring(6);
}



//######################################################################################

function changeName(change){
document.getElementById('change').innerHTML=change;
}

function showImage(pic){
	document.getElementById('loading').innerHTML='<img src="graphics/'+pic+'"></img>';
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

function begin(iter){
	if(iter>0){
	completed();
	
	var data;
	
		var downloading = new Worker("getData.js");
		changeName("DOWNLOADING DATA");
		showImage("downloading2.gif");

		downloading.onmessage=function(event){
			var downloadedData=event.data;
			changeName("PROCESSING DATA");
			showImage("processing1.gif");
			var processing=new Worker("computeSTR.js");
			processing.postMessage(downloadedData);

			processing.onmessage=function(event){
				var processedData=event.data;
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


		}	 

	
	}