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

self.addEventListener('message',function(e){
self.postMessage(computeSTR(e.data));


},false);

/*self.onmessage=function(event){
console.log('called');
}*/











