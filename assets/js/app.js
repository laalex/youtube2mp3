$(window).load(function(){
	$(document).on('submit',"#convert_video",function(){
		var timestamp = new Date().getTime();;
		var new_div = 'resultfor_'+timestamp;
		//add nice progress bar for all videos
		$("#playlist").append("<div id='"+new_div+"'></div>");
		var responsediv = $("#"+new_div);
		responsediv.append('<div class="progress"><div id="progress_'+timestamp+'" class="progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%"><span id="span_'+timestamp+'">Step</span></div></div>');
		var progressdiv = $("#progress_"+timestamp);
		var spandiv = $("#span_"+timestamp);
		var videourl = $("#videourl").val();
		$("#videourl").attr('disabled','disabled');
		filename = null;
		//Get the download URL
		$.ajax({
			url:'api.php',
			type:'POST',
			data:{url:videourl},
			success:function(data){
				filename = data;
				responsediv.prepend("Downloading: <b>"+filename+"</b><br />");
				//Initiate ajax to download the file
				$.ajax({
					url:'api.php',
					type:'POST',
					data:{download:videourl,name:filename},
					success:function(data){
						//File downloaded
						console.log(data);
					}
				});
				//Poll the log file to get the last line and get the progress percentage
				var filePollInterval = setInterval(CheckProgress,2000);
				progress = 0;
				function CheckProgress(){
					$.ajax({
						url:'api.php',
						type:'POST',
						data:{poll:'progress',name:filename},
						success:function(data){
							if(data!='false'){
								progress = data;
								spandiv.html(data+'%');
								progressdiv.attr('style','width:'+data+'%');
							}	
						}
					});
					if(progress == '100'){
						clearInterval(filePollInterval);
						//Start video conversion to MP3
						responsediv.append("<h5>Converting your file to MP3...</h5>");
						$.ajax({
							url:'api.php',
							type:'POST',
							data:{convert:filename},
							success:function(data){
								$("#videourl").val("");
								$("#videourl").prop('disabled',false);
								//File conversion ready
								responsediv.append("<a class='btn btn-warning' href='download.php?file="+data+"'>Download MP3</a>");
							}
						});
					}
				}
			}
		});
		//Return false -> Prevent default
		return false;
	});
});