/*
* Application JavaScript
*/

/**
 * Objects init
 */
//Init jSnippets
jsnippets.init('/assets/snippets.html');

function dispatchFeedback(){
	$('.feedback-btn').trigger('click');
}

/**
 * Click events and AJAX calls
 */
$(window).ready(function(){
	//Init the MP3 player
	rplayer.init("song_time","mp_elapsed","mp_total","play_button","mp3_songname","volume_cursor");
	/**
	 * Feedbakc plugin
	 */
	$.feedback({
	     ajaxURL: baseurl+'ajax/submit_feedback',
	     html2canvasURL: '/assets/js/html2canvas.min.js',
	     initButtonText:'Send feedback or report bug',
	     onClose: function(){
	     	$('.feedback-btn').hide();
	     }
	});

	/* Playlist Manager */

	//Create new playlist - Show playlist form
	$(document).on('click',"#add-new-playlist",function(evt){
		$("#add-new-playlist-form").fadeIn("fast");
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
			url:baseurl+'ajax/playlists',
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
		$("#watchdog").fadeIn().html("Please wait while your download is generated. Note that it might take some time..");
		$.ajax({
			url:baseurl+'ajax/pack_download',
			type:'POST',
			data:{playlist:pid},
			success:function(data){
				data = $.parseJSON(data);
				$("#watchdog").html('Your archive has been created and download should start!').fadeIn().delay(5000).fadeOut();
				$("#download_frame").attr('src',data.zip);
				return false;
			}
		});
	});

	$(document).on('click',"#toggle-downloads",function(){
		var vis = $(this).data('visible');
		if(vis=='ok'){
			$(this).addClass('highlighted').html('<span class="glyphicon glyphicon-resize-full"></span>&nbsp;Show downloads');
			$("#current-vd-downloads-holder").hide();
			$(this).data('visible','false');
		} else {
			$(this).removeClass('highlighted').html('<span class="glyphicon glyphicon-resize-small"></span>&nbsp;Hide downloads');
			$("#current-vd-downloads-holder").show();
			$(this).data('visible','ok');
		}
	});


	/* Confirm modal */
	$(document).on('click','.confirm',function(){
		$(".modal").modal();
		$("#confirm_url").attr('value',$(this).attr('data-pid'));
		return false;
	});

	/** RPlayer MP3 lib. */
	$(document).on('click','.listen-song-action',function(){
		var song_url = $(this).data('url');
		var song_name = $(this).data('song-name');
		//Check song status
		var status = $(this).data('song-status');
		var sid = $(this).data('song-id');
		var vid = $(this).data('video-id');
		if(status==0){
			//The song is not downloaded. Cast download
			$("#watchdog").html('The song is downloading and will be played when completed.').fadeIn().delay(5000).fadeOut();
			$.ajax({
				url:baseurl+'download/reload_song',
				type:'POST',
				data:{song_id:sid,video_id:vid},
				success:function(data){
					data = $.parseJSON(data);
					if(data=='ok'){
						$("#watchdog").html('Your song has been downloaded! Enjoy listening').fadeIn().delay(3000).fadeOut();
						$(".expired-"+sid).html('<span class="glyphicon glyphicon-ok-sign"></span>');
						rplayer.playSong(song_url,song_name);
					}
				}
			});
		} else {
			rplayer.playSong(song_url,song_name);
		}

	});

	$(document).on('click','#play_button',function(){rplayer.togglePlayPause()});

	$(document).on('click',"#toggle_mp3",function(){$("#mp3player").slideToggle('slow');});

	/** Video close */
	$(document).on('click','.video-close',function(){
		$(this).parent().hide();
	});

	/** Send friend invitation */
	$(document).on('submit','#user-invite-form',function(){
		var email = $("#invite-email").val();
		$("#watchdog").html("Please wait while sending your invite..").fadeIn();
		$.ajax({
			type:'POST',
			url:baseurl+'settings/put_invite',
			data:{email:email},
			success:function(data){
				data = $.parseJSON(data);
				$("#watchdog").html(data).fadeIn().delay(5000).fadeOut();
			}
		});
	});

	/**Password change action - Settings */
	$(document).on('click','#password-change-action',function(){
		var p = $('#password-change').val();
		var o = $("#password-change-old").val();
		if(p=='' || o == ''){alert('Please complete both password fields');} else {
			//Change password
			$.ajax({
				type:'POST',
				url:baseurl+'settings/change_password',
				data:{password:p,old_password:o},
				success:function(data){
					data = $.parseJSON(data);
					$("#watchdog").html(data).fadeIn().delay(5000).fadeOut();
				}
			});
		}
	});

	/** Download song action */
	$(document).on('click','.song-download-action',function(){
		var url = $(this).data('url');
		$("#download_frame").attr('src',baseurl+url);
		return false;
	});

	/** Enable / disable app state*/
	$(document).on('change',"#allow_storage_checkbox",function(){
		if($(this).is(':checked')===true){
			localStorage.setItem('allow_storage',"1");
		} else {
			localStorage.setItem('allow_storage',"0");
		}
	});

	/**
	 * Youtube search
	 * ---------------------------------------------
	 * Perform the search while typing in keywords on the download video input
	 */
	$(document).on('keyup','#video-url-input',function(){
		if($(this).val() !== '' && YT_LOADED_SUCCESSFULLY){
			youtube_search($(this).val(),"#video_search");
		} else {
			$("#video_search").html("");
		}
	});
	/**
	 * Download song from youtube search
	 */
	$(document).on('click','.result_convert',function(){
		var id = $(this).parent().find("[data-view]").html();
		//Show Loading state
		$("#video-url-button").attr('value','Loading...');
		//Display the video and progressbar
		start_song_download("https://www.youtube.com/watch?v="+id,"#video-download-response");
	});

	/**
	 * Queue an entire playlist
	 */
	$(document).on('click',"#queue_playlist",function(){
		var playlist_id = $(this).data('list-id');
		//Queue the list into the player
		$.ajax({
			url:baseurl+'application/playlist_songs/'+playlist_id,
			type:'POST',
			success:function(data){
				data = $.parseJSON(data);
				//Add each object to the rplayer.playlist;
				populatePlaylist(data);
				//Start playlist play
				rplayer.play_playlist();
			}
		});
	});
	/**
	 * Remove playlist song
	 */
	$(document).on('click','.remove-song',function(){
		var pos = $(this).data('playlist-pos');
		rplayer.playlist.splice(pos,1);
		populatePlaylist(rplayer.playlist);
		$('.tipsy').hide();
		return false;
	});
	/**
	 * Queue a new song
	 */
	$(document).on('click','.song-queue-action',function(){
		var song_id = $(this).data('song-id');
		$.ajax({
			url:baseurl+'application/get_song/'+song_id,
			type:'POST',
			success:function(data){
				data = $.parseJSON(data);
				rplayer.playlist.push(data);
				populatePlaylist(rplayer.playlist);
				rplayer.play_playlist(rplayer.playlist_pos,true);
			}
		})
	});
	/**
	 * On song click. From playlist. Play the song and update everything
	 */
	$(document).on('click','.playlist-song',function(){
		//Get the current active song
		var cactive = $('.playlist-active').children().removeClass('glyphicon-pause').addClass('glyphicon-play');
		//Remove the active
		$('.playlist-song').removeClass('playlist-active');
		$(this).addClass('playlist-active').children().removeClass('glyphicon-play').addClass('glyphicon-pause');
		//Get the current playlist entry id
		var pos = $(this).data('playlist-pos');
		rplayer.play_playlist(pos);
		//Remove glyphicon-play and glyphicon-pause from "remvoe song"
		$('.remove-song').removeClass("glyphicon-pause").removeClass("glyphicon-play");
	});
	/**
	 * Show MP3 player playlist
	 */
	$(document).on('click',"#show_playlist",function(){
		$("#rplayer_playlist").slideToggle();
	});

	/**
	 * Toggle player repeat
	 */
	$(document).on('click',"#repeat_button",function(){
		var repeat = rplayer.repeat();
		var repeat_playlist = rplayer.playlist_repeat;
		if(repeat_playlist == 0 && repeat == false){
			//Toggle playlist repeat
			rplayer.repeat(false);
			rplayer.playlist_repeat = 1;
			$("#repeat_button").attr('style','color:#09f').attr('title',"Toggle one repeat");
			$('.ttp').tipsy({live: true,gravity:'s'});
		} else if(repeat_playlist  == 1 && repeat == false){
			//Toggle one repeat
			rplayer.playlist_repeat = 0;
			rplayer.repeat(true);
			$("#repeat_button").attr('style','color:#900').attr('title',"Repeat OFF");
			$('.ttp').tipsy({live: true,gravity:'s'});
		} else {
			//Toggle repeat off
			rplayer.playlist_repeat = 0;
			rplayer.repeat(false);
			$("#repeat_button").attr('style','color:#fff').attr('title',"Repeat playlist");
			$('.ttp').tipsy({live: true,gravity:'s'});
		}

	});

	/**
	 * Share playlist with other users
	 */
	$(document).on('click',"#share_playlist",function(){
		var id = $("#share-link-content").data('list-id');
		$("#share-link-content").html('<input type="text" value="'+window.location.origin+'/dashboard/#/share/'+id+'" class="form-control"/>');
		$('.modal').modal();
	});

	/** Function that populates the playlist */
	function populatePlaylist(array){
		rplayer.playlist = [];//Reset the playlist
		var playlist_data = "";
		var i = 0;
		$.each(array,function(){
			rplayer.playlist.push(this);
			//Update the playlist
			if(i==rplayer.playlist_pos){var cls = "playlist-song playlist-active ttp"; var span="pause"; } else {var cls="ttp playlist-song"; var span="play";}
			playlist_data += '<div data-song-url="'+this.direct_url+'" data-playlist-pos="'+i+'" title="'+this.full_name+'" class="'+cls+'"><span class="glyphicon glyphicon-'+span+'"></span>&nbsp;'+this.nice_name+'<div data-playlist-pos="'+i+'" class="pull-right remove-song">X</div></div>';
			i++;
		});
		//Append the playlist data t the playlist container
		$("#rplayer_playlist").html(playlist_data);
		$("#rplayer_playlist").mCustomScrollbar();
	}

	/**
	 * Mute audio
	 */
	$(document).on('click',"#rplayer-mute",function(){
		rplayer.mute();
	});

	/**
	 * Max audio
	 */
	$(document).on('click',"#rplayer-fullsound",function(){
		rplayer.maxvol();
	});

	/**
	 * Pause the song when watching on youtube
	 */
	$(document).on('click',".yt-watch-action",function(){
		rplayer.pause();
	});

	/**
	 * Move song to another playlist
	 */
	$(document).on('click','.move-to-playlist',function(){
		var id = $(this).data('new-list-id');
		var sid = $(this).data('song-id');
		$.ajax({
			url:baseurl+'application/change_song_playlist',
			type:'POST',
			data:{sid:sid,plid:id},
			success:function(data){
				if(data=="success"){
					$("#watchdog").html("Your song has been moved to the this playlist. Please wait for it to reload.").fadeIn().delay(3000).fadeOut();
					window.location = window.location.origin+'/dashboard/#/view/'+id;

				}

			}
		});
		return false;
	});

	/**
	 * Song remove action
	 */
	$(document).on('click','.song-remove-action',function(){
		var s_id = $(this).data('song-id');
		$("#watchdog").html("Your song is being removed...").fadeIn();
		$.ajax({
			url:baseurl+'application/remove_song/'+s_id,
			type:'POST',
			success:function(data){
				$("#watchdog").html("Song has been removed!").delay(3000).fadeOut();
			}
		})
	});

	/**
	 * Show the keyboard shorcuts to the user
	 */
	$(document).on('click',"#kbd-shortcuts",function(){
		$("#kbd-modal").modal();
	});

});

	/* ANGULAR JS APPLICATION */
	zonglist = angular.module('zonglist',["ngRoute","zonglistControllers"]);
	zonglistControllers = angular.module('zonglistControllers',[]);
	//ZongList configuration
	zonglist.config(["$routeProvider",function($routeProvider){
		$routeProvider.
		when('/',{
			templateUrl:'/ngapp/partials/dashboard.html',
			controller:'dashboardController'
		}).
		when('/playlists',{
			templateUrl:'/ngapp/partials/playlists.html',
			controller:'playlistsController'
		}).
		when('/view/:playlistID',{
			templateUrl:'/ngapp/partials/view_playlist.html',
			controller:'viewplaylistController'
		}).
		when('/share/:playlistID',{
			templateUrl:'/ngapp/partials/view_playlist.html',
			controller:'viewplaylistController'
		}).
		when('/invite',{
			templateUrl:'/ngapp/partials/invite.html',
			controller:'inviteController'
		}).
		when('/settings',{
			templateUrl:'/ngapp/partials/settings.html',
			controller:'settingsController'
		}).
		when('/android',{
			templateUrl:'/ngapp/partials/android.html',
			controller:'dashboardController'
		}).
		otherwise({
			redirectTo:'/'
		});
	}]);


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
	$("#current-vd-downloads-holder").append(clone);
	container = '#'+uniqueid;
	$(container).fadeIn();
	$("#video-url-button").attr('value','Download video');
	$(container).find('.video-title').html('<h4>'+data.title+'</h4>');
	$(container).find('.video-thumbnail').find('img').attr('src',data.thumbnail);
	var progressbar = $(container).find('.video-progressbar');
	var downloadbutton = $(container).find('.download-action');
	var actiontag = $(container).find('.download-tag');
	var file = data._filename;
	var playlistupdater = $(container).find('.playlist-updater');
	var playlistselector = $(container).find('.playlist-selector');
	ydlprogress(videourl,progressbar,downloadbutton,actiontag,file,playlistupdater,playlistselector);
}

function start_song_download(videourl,container,progressbar){
	var url = baseurl+'ajax/downloader';
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
			alert('Cannot download this file. Please try again!');
		}
	});
}
/* Print in the download progress into the div */
function ydlprogress(videourl,progressbar,downloadbutton,actiontag,file,plupdater,playlistselector){
	var progress_int = 0;
	var url = baseurl+'ajax/downloader';
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
				url:baseurl+'ajax/downloader',
				type:'POST',
				data:{action:'convert_video',video_name:file},
				success:function(data){
					data = $.parseJSON(data);
					//Register this information into the database for the current user and display the download button
					//Do an ajax request and add the song into the users database
					$.ajax({
						url:baseurl+'ajax/songs',
						type:'POST',
						data:{action:'register_song',song_title:data.file_name,videourl:videourl},
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


/**
 * Window load functions
 */

$(window).load(function(){
	if(first_visit=='true'){
		/**
		 * Tutorial
		 */
		$("#tutorial_id").joyride({
			autoStart : true
		});
	}
	/**
	 * Other scripts
	 */
	/** Tipsy */
	$('.ttp').tipsy({live: true,gravity:'s'});

	//Finished loading
	$("#app_loading").fadeOut();
});