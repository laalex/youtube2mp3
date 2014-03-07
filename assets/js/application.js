/*
* Application JavaScript
*/
$(window).ready(function(){

	/* Playlist Manager */

	//Create new playlist - Show playlist form
	$(document).on('click',"#add-new-playlist",function(evt){
		$("#add-new-playlist-form").fadeIn("fast");
		return false;
	});
	//Create new playlist - Submit form
	$(document).on('submit',"#new-playlist-form",function(evt){
		var name = $(this).find('input[name="name"]').val();
		if(name!==''){
			//Playlist name is not empty -> Process playlist addition
			$("#add-playlist-watchdog").html("<span><img src='"+assets_img+"smallpr.GIF'> &nbsp; Loading...</span>");
			//Send ajax request
			$.ajax({
				url:baseurl+'ajax/playlists',
				type:'POST',
				data:{action:'add_playlist',playlist_name:name},
				success:function(data){
					data = $.parseJSON(data);
					if(data.response=='success'){
						$("#add-playlist-watchdog").html("<span class='glyphicon glyphicon-ok'></span>&nbsp;Your playlist has been created!").fadeIn();
					}else{
						$("#add-playlist-watchdog").html("<span class='glyphicon glyphicon-remove'></span>&nbsp;"+data.details).fadeIn();
					}
				},
				error:function(data){
					$("#add-playlist-watchdog").html("There was an error. Please try again.").fadeIn();
					console.log(data);
				}
			});
		}else{
			//Playlist name is empty. Show error
			$("#add-playlist-watchdog").html('Playlist name cannot be empty').fadeIn();
		}
		return false;
	});


	/* Downloader */
	$(document).on('submit',"#video-convert-form",function(){
		var url = $("#video-url-input").val();
		if(url !== ''){
			//Show Loading state
			$("#video-url-button").attr('value','Loading...');
			//Display the video and progressbar
			start_song_download(url,"#video-download-response");
		} else {
			//Display error message
			$("#video-url-input").val('Please enter a valid youtube URL');
		}
		return false;
	});


	/* Playlist updater */
	$(document).on('click','.set-song-playlist',function(){
		var parent = $(this).parent().parent(); //Get the UL element
		var song_id = parent.attr('data-songid');
		var playlist = $(this).data('id');
		$.ajax({
			url:'http://stardust.alexandrulamba.com/youtube2mp3/ajax/playlists',
			type:'POST',
			data:{action:'put_song_in_playlist',song_id:song_id,playlist:playlist},
			success:function(data){
				data = $.parseJSON(data);
				$("#watchdog").html(data.details);
				$("#watchdog").fadeIn().delay(3000).fadeOut();
			}
		});
		return false;
	});

	/* Create playlist download */
	$(document).on('click','#create-pack-download',function(){
		var pid = $(this).data('playlist');
		$("#watchdog").fadeIn();
		$.ajax({
			url:'http://stardust.alexandrulamba.com/youtube2mp3/ajax/pack_download',
			type:'POST',
			data:{playlist:pid},
			success:function(data){
				data = $.parseJSON(data);
				$("#watchdog").html('Your archive has been created and download should start!');
				window.location = data.zip;
			}
		});
	});


	/* Confirm modal */
	$(document).on('click','.confirm',function(){
		$(".modal").modal();
		$("#confirm_url").attr('href',$(this).attr('href'));
		return false;
	});

});


/* 
* Application functions
*/

function ydlsetdownload(data,videourl,container){
	//Set the information to the users screen
	var clone = $(container).clone();
	//generate random ID
	var timestamp = (new Date).getTime();
	var rand_no = Math.floor( Math.random()*99999 );
	var uniqueid = 'id-'+rand_no+timestamp;
	clone.removeAttr('id').attr('id',uniqueid);
	$("#main_dashboard").append(clone);
	container = '#'+uniqueid;
	$(container).fadeIn();
	$("#video-url-button").attr('value','Download video');
	$(container).find('.video-title').html('<h4>'+data.title+'</h4>');
	$(container).find('.video-thumbnail').find('img').attr('src',data.thumbnail);
	var progressbar = $(container).find('.video-progressbar');
	var downloadbutton = $(container).find('.download-action');
	var actiontag = $(container).find('.download-tag');
	var file = data.title;
	var playlistupdater = $(container).find('.playlist-updater');
	var playlistselector = $(container).find('.playlist-selector');
	ydlprogress(videourl,progressbar,downloadbutton,actiontag,file,playlistupdater,playlistselector);
}

function start_song_download(videourl,container,progressbar){
	var url = 'http://stardust.alexandrulamba.com/youtube2mp3/ajax/downloader';
	var result;
	$.ajax({
		url:url,
		type:'POST',
		data:{url:videourl,action:'video_information'},
		success:function(data){
			ydlsetdownload($.parseJSON(data),videourl,container,progressbar);
		},
		error:function(data){
			//Error happened
			alert('error');
		}
	});
}
/* Print in the download progress into the div */
function ydlprogress(videourl,progressbar,downloadbutton,actiontag,file,plupdater,playlistselector){
	var progress_int = 0;
	var url = 'http://stardust.alexandrulamba.com/youtube2mp3/ajax/downloader';
	params = 'action=download_video&url='+videourl;
	var xmlhttp=new XMLHttpRequest();
	xmlhttp.open('POST',url,true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-length", params.length);
	xmlhttp.setRequestHeader("Connection", "close");
	xmlhttp.send(params);
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
	    	//console.log(last[0]);
	    	if(last[0] == '[download]'){
	    		//console.log(last[1]);
	    		var progress_int = parseInt(last[1]);
	    		$(progressbar).attr('style','width:'+progress_int+'%');
	    	}
		}
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			//Download finished 100%
			$(actiontag).html('Converting your video to MP3').addClass('label-success').removeClass('label-info');
			//Trigger ajax request to transform MP4 to MP3
			$.ajax({
				url:'http://stardust.alexandrulamba.com/youtube2mp3/ajax/downloader',
				type:'POST',
				data:{action:'convert_video',video_name:file},
				success:function(data){
					data = $.parseJSON(data);
					//Register this information into the database for the current user and display the download button
					//Do an ajax request and add the song into the users database
					$.ajax({
						url:'http://stardust.alexandrulamba.com/youtube2mp3/ajax/songs',
						type:'POST',
						data:{action:'register_song',song_title:data.file_name},
						success:function(data){
							data = $.parseJSON(data);
							if(data.response=='success'){
								//Display the download button
								$(downloadbutton).attr('href',data.download);
								$(downloadbutton).fadeIn();
								$(plupdater).attr('data-songid',data.song_id);
								$(playlistselector).fadeIn();
								//Change tag notification
								$(actiontag).html('File converted.').addClass('label-default').removeClass('label-success');
							}
						}
					});
				},
				error:function(){
					alert('Error occured while converting your song. Please try again!');
				}
			});
		}
	}
}