/**
 * MP3 Player plugin based on jQuery
 * ---------------------------------
 * written by Alexandru Lamba
 * ---------------------------------
 * Used to handle and interact with an <audio> object from the DOM
 * and perform different actions on it
 */
window.rplayer = {};
/**
 * [config - Object tht holds the entire configs. Should be inited within the init function]
 * @type {Object}
 */
window.rplayer.config = {
    cursor_holder:null,
    cursor_div:null,
    counter_div:null,
    duration_div:null,
    play_button_div:null,
    song_title_div:null,
    volume_cursor_div:null,
    volume_selected_div:null,
    keyboard_shortcuts:true
};

/**
 * Init the rplayer object with the id of the <audio> element
 */
rplayer.init = function(cursor_holder,counter_div,duration_div,play_button_div,song_title_div,volume_selected_div){
    //Init rplayer config
    rplayer.config.cursor_holder=cursor_holder;
    rplayer.config.duration_div=duration_div;
    rplayer.config.counter_div=counter_div;
    rplayer.config.play_button_div=play_button_div;
    rplayer.config.song_title_div=song_title_div;
    rplayer.config.volume_selected_div=volume_selected_div;
    /** Create unique hash - used as ID for the mp3 player */
    rplayer.id = new Date().getTime()+'_rplayer';
    var audio_element = document.createElement("audio");
    audio_element.setAttribute('id',rplayer.id);
    audio_element.setAttribute('style','display:none');
    rplayer.audio = audio_element;
    //Init volume control
    rplayer.volume();
    //Init playlist
    rplayer.playlist = [];
    rplayer.playlist_pos = 0;
    rplayer.playlist_repeat = 0;
    //Init the sliders and the required listeners for them
    $("#"+rplayer.config.cursor_holder).slider({"min":0,"max":100,"step":0.5,
        slide:function(e,u){
            var v = $(this).slider("value");
            rplayer.seekto(v);
        }
    });
    $("#"+rplayer.config.volume_selected_div).slider({"min":0,"max":1,"step":0.01,
        slide:function(e,u){
            var v = $(this).slider("value");
            rplayer.volume(v);
        }
    });
    /**
     * Event Listeners
     */
    rplayer.audio.addEventListener('pause',function(event){
        pauseEventHandler(event);
    });
    return rplayer.audio;
}

/**
 * Load a song into the audio player
 */
rplayer.load = function(song_url){
    if(rplayer.audio === undefined){
        alert('Audio player was not initalised or no audio element found.');
    } else {
        rplayer.audio.setAttribute('src',song_url);
        rplayer.audio.load();
        /** Create method to see if we can play the song */
        return true;
    }
}

/**
 * Mute audio -> Set volume to 0
 */
rplayer.mute = function(){
    if(rplayer.audio !== undefined){
        $("#"+rplayer.config.volume_selected_div).slider({"value":0});
        rplayer.volume(0);
    }
}

/**
 * Set volume to max
 */
rplayer.maxvol = function(){
    if(rplayer.audio !== undefined){
        $("#"+rplayer.config.volume_selected_div).slider({"value":1});
        rplayer.volume(1);
    }
}

/**
 * [setVolume] - Set the volume for the mp3 player
 * @param {[float]} val [range between 0 and 100]
 */
rplayer.volume = function(val){
    if(rplayer.audio !== undefined){
        if(val !== undefined){
            //Set the volume cursor
            $("#"+rplayer.config.volume_selected_div).slider({"value":val});
            rplayer.audio.volume = val;
        } else {
            var val = rplayer.audio.volume;
            $("#"+rplayer.config.volume_selected_div).slider({"value":val});
            return val;
        }
    }
    return false;
}

/**
 * [play] - Play MP3
 * @return {[void]} [Call the play action for the mp3 player]
 */
rplayer.play = function(){
    if(rplayer.audio !== undefined){
        return rplayer.audio.play();
    }
    return false;
}

/**
 * [pause] - Call the pause action for the mp3 player
 * @return {[void]} [Pause the play]
 */
rplayer.pause = function(){
    if(rplayer.audio !== undefined){
        return rplayer.audio.pause();
    }
    return false;
}

/**
 * [duration] - Returns the length of the current loaded song into seconds
 * @return {[float]} [length of song in seconds]
 */
rplayer.duration = function(duration_div){
    if(rplayer.audio !== undefined){
        var duration = rplayer.audio.duration;
        if(duration_div !== undefined){
            var d = document.getElementById(duration_div);
            d.innerHTML = "/ " + rplayer.formatElapsedTime(duration);
        }
        return duration;
    }
    return false;
}

/**
 * [played] - return the played seconds from the mp3 song
 * @return {[float or bool]} [return false if something is not good. Return float if everything is ok]
 */
rplayer.played = function(){
    if(rplayer.audio !== undefined){
        return rplayer.audio.currentTime;
    }
    return false;
}


rplayer.seekto = function(percent){
    if(rplayer.audio !== undefined){
        var max = rplayer.duration();
        var ct = (percent/100)*max;
        rplayer.audio.currentTime = ct;
        return true
    }else {
        return false;
    }
}

rplayer.jumpTo = function(secs){
    if(rplayer.audio !== undefined){
        rplayer.audio.currentTime = secs;
        return true
    }else {
        return false;
    }
}

rplayer.repeat = function(bool){
    if(rplayer.audio !== undefined){
        if(bool !==undefined)
            rplayer.audio.loop = bool;
    }
    return rplayer.audio.loop;
}

/**
 * Play an entire playlist
 */
rplayer.play_playlist = function(pos,queue){
    if(pos !== undefined){
        rplayer.playlist_pos = pos;
    } else {rplayer.playlist_pos = 0;}
    //Check if playlist is already playing
    if(rplayer.audio.paused == true || queue === undefined)
        rplayer.playSong(rplayer.playlist[rplayer.playlist_pos].direct_url,rplayer.playlist[rplayer.playlist_pos].nice_name);
}

//Play song function
rplayer.playSong = function(song_url,song_name,seconds){
    //Load the song
    rplayer.load(song_url);
    //Toggle song play
    rplayer.togglePlayPause();
    rplayer.cursor(rplayer.config.cursor_div,rplayer.config.counter_div,rplayer.config.duration_div);
    var song_title = document.getElementById(rplayer.config.song_title_div);
    song_title.innerHTML = song_name;
    //Start at a given time.
    if(seconds!==undefined){
        setTimeout(function(){
            rplayer.jumpTo(seconds);
        },500);
    }
}

/**
 * Event listeners
 */

function pauseEventHandler(evt){
    /** Check playlist length */
    if(rplayer.playlist.length > 0){
        //Check if player state is at the end
        if(rplayer.audio.currentTime === rplayer.audio.duration){
            //Update rplayer.playlist_pos
            $('.playlist-song').removeClass('playlist-active');
            var cactive = $('[data-playlist-pos="'+rplayer.playlist_pos+'"]').children().removeClass('glyphicon-pause').addClass('glyphicon-play');
            if(rplayer.playlist_pos+1 < rplayer.playlist.length){
                rplayer.playlist_pos++;
                rplayer.play_playlist(rplayer.playlist_pos);
                $("#watchdog").html("<b>Now playing: </b>"+rplayer.playlist[rplayer.playlist_pos].nice_name);
                $("#watchdog").fadeIn().delay(3000).fadeOut();
                /** Update playlist */
                $('[data-playlist-pos="'+rplayer.playlist_pos+'"]').addClass('playlist-active').children().removeClass('glyphicon-play').addClass('glyphicon-pause');
                //Remove glyphicon-play and glyphicon-pause from "remvoe song"
                $('.remove-song').removeClass("glyphicon-pause").removeClass("glyphicon-play");
                return;
            }
            if(rplayer.playlist_pos+1 >= rplayer.playlist.length){
                //Check if playlist repeat is set
                if(rplayer.playlist_repeat == 1){
                    rplayer.playlist_pos = 0;
                    rplayer.play_playlist(rplayer.playlist_pos);
                    $("#watchdog").html("<b>Now playing: </b>"+rplayer.playlist[rplayer.playlist_pos].nice_name);
                    $("#watchdog").fadeIn().delay(3000).fadeOut();
                    /** Update playlist */
                    $('[data-playlist-pos="'+rplayer.playlist_pos+'"]').addClass('playlist-active').children().removeClass('glyphicon-play').addClass('glyphicon-pause');
                    //Remove glyphicon-play and glyphicon-pause from "remvoe song"
                    $('.remove-song').removeClass("glyphicon-pause").removeClass("glyphicon-play");
                } else {
                    $("#watchdog").html("<b>Playlist finished playing.</b> Select a song to play or queue a playlist.").fadeIn().delay(3000).fadeOut();
                    rplayer.pause();
                }
                return;
            }
        }
    }
    var el = document.getElementById(rplayer.config.play_button_div);
    if(rplayer.audio.paused){
        el.setAttribute('class','glyphicon glyphicon-play');
    }
}

/**
 * [cursor] Set the track elapsed cursor at it's position and the hh:mm:ss elapsed time
 * @param  {[string]} cursor_div  [div of the cursor to update width in percent from 0 to 100%]
 * @param  {[string]} counter_div [div of the time counter to update elapsed mins/seconds]
 */
rplayer.cursor = function(cursor_div,counter_div,duration_div){
    if(rplayer.audio !== undefined){
        rplayer.audio.addEventListener('timeupdate',function(evt){
            /** When timeupdate is triggered, update the time counter and the slider */
            var ct = document.getElementById(counter_div);
            //Make updates calculations and transform seconds into hh:mm:ss
            ct.innerHTML = rplayer.formatElapsedTime(rplayer.played());
            $("#song_time").slider("option","value",rplayer.formatElapsedPercent(rplayer.played(),rplayer.duration()));
            rplayer.duration(duration_div);
        });
    }
}

/**
 * [formatElapsedTime - Return hh:mm:ss elapsed time of the song.]
 * @param  {[float]} totalSeconds [elapsed time in seconds]
 * @return {[string]}              [hh:mm:ss string formatted]
 */
rplayer.formatElapsedTime = function(totalSeconds){
    totalSeconds = Math.ceil(totalSeconds);
    //Create hours,minutes,seconds
    hours = Math.floor(totalSeconds / 3600);
    totalSeconds %= 3600;
    minutes = Math.floor(totalSeconds / 60);
    seconds = totalSeconds % 60;
    var elapsed = "";
    //Add hours
    if(hours != 0){
        if(hours < 10){
            elapsed += "0"+hours+":";
        } else {
            elapsed += hours+":";
        }
    }
    //Add minutes
    if(minutes < 10){
        elapsed += "0"+minutes+":";
    } else {
        elapsed += minutes+":";
    }
    //Add seconds
    if(seconds < 10){
        elapsed += "0"+seconds;
    } else {
        elapsed += seconds;
    }
    return elapsed;
}

/**
 * [formatElapsedPercent return percent of elapsed time]
 * @param  {[float]} elapsed [elapsed time in seconds]
 * @param  {[float]} total   [total time in seconds]
 * @return {[float]}         [percent from 0 - 100%]
 */
rplayer.formatElapsedPercent = function(elapsed,total){
    //Ceil the values
    elapsed = Math.ceil(elapsed);
    total = Math.ceil(total);
    //Calculate the percent and return it as a float value
    return (elapsed/total)*100;
}

rplayer.togglePlayPause = function(){
    if(rplayer.audio !== undefined){
        var el = document.getElementById(rplayer.config.play_button_div);
        if(rplayer.audio.paused){
            el.setAttribute('class','glyphicon glyphicon-pause');
            rplayer.play();
        } else {
            el.setAttribute('class','glyphicon glyphicon-play');
            rplayer.pause();
        }
    } else {
        return false;
    }
}

/**
 * Populate the playlis into a div
 */
rplayer.populatePlaylist = function(array){
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
 * Keyboard shortcuts
 */
if(rplayer.config.keyboard_shortcuts){
    /**
     * Key event listeners
     */
    $(document).on('keypress',function(key){
        var key_code = key.keyCode;
        var shift = key.shiftKey;
        console.log(key_code);
        switch(key_code){
            //shift + p - Play/Pause
            case 80:
                rplayer.togglePlayPause();
                return false;
            break;
            //Shift - (Volume down)
            case 95:
                var vol = rplayer.volume();
                if(vol - 0.1 >= 0) rplayer.volume(vol-0.1);
                return false;
            break;
            //Shift + (Volume up)
            case 43:
                var vol = rplayer.volume();
                if(vol + 0.1 <= 1) rplayer.volume(vol+0.1);
                return false;
            break;
            //Shift + r (toggle repeat)
            case 82:
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
                return false;
            break;
            //Shift + L (Load playlist)
            case 76:
                if(window.location.hash.search("view") !== -1){
                    //Load the current playlist in view
                    $("#queue_playlist").trigger('click');
                }
            break;
        }
    });
}