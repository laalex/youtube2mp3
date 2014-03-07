<!DOCTYPE html>
<html>
<head>
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript">
		$(window).load(function(){

			ydlprogress('POST','http://stardust.alexandrulamba.com/youtube2mp3/test',true,$("#result"));
			

		});

		//Function
		function ydlprogress(type,url,async,progressbar){
			var xmlhttp=new XMLHttpRequest();
			xmlhttp.open(type,url,async);
			xmlhttp.send();
			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==3 && xmlhttp.status==200){
					//Get the last response text
			    	var response = xmlhttp.responseText;
			    	response = response.split("\n");
			    	//Get the last response
			    	var pos = response.length; pos -=2;
			    	var last = response[pos];
			    	//Remove extra spaces
			    	last = last.replace(/ +/g, ' ');
			    	//Split it and get the percentage
			    	last = last.split(' ');
			    	console.log(last[0]);
			    	if(last[0] == '[download]'){
			    		console.log(last[1]);
			    		$(progressbar).html(parseInt(last[1]));
			    	}
				}
				if (xmlhttp.readyState==4 && xmlhttp.status==200){
					return true;
				}
			}
		}
	</script>
</head>
<body>

<div id="result"></div>
</body>
</html>