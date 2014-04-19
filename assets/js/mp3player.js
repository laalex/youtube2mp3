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
    volume_selected_div:null
};

/**
 * Init the rplayer object with the id of the <audio> element
 */
rplayer.init = function(cursor_holder,cursor_div,counter_div,duration_div,play_button_div,song_title_div,volume_selected_div,volume_cursor_div){
    //Init rplayer config
    rplayer.config.cursor_holder=cursor_holder;
    rplayer.config.cursor_div=cursor_div;
    rplayer.config.duration_div=duration_div;
    rplayer.config.counter_div=counter_div;
    rplayer.config.play_button_div=play_button_div;
    rplayer.config.song_title_div=song_title_div;
    rplayer.config.volume_selected_div=volume_selected_div;
    rplayer.config.volume_cursor_div=volume_cursor_div;
    /** Create unique hash - used as ID for the mp3 player */
    rplayer.id = new Date().getTime()+'_rplayer';
    var audio_element = document.createElement("audio");
    audio_element.setAttribute('id',rplayer.id);
    audio_element.setAttribute('style','display:none');
    rplayer.audio = audio_element;
    //Init volume control
    rplayer.volume();
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
 * [setVolume] - Set the volume for the mp3 player
 * @param {[float]} val [range between 0 and 100]
 */
rplayer.volume = function(val){
    if(rplayer.audio !== undefined){
        var el = document.getElementById(rplayer.config.volume_selected_div);
        if(val !== undefined){
            //Set the volume cursor
            el.setAttribute('style','width:'+val+'%');
            //Set the volume
            val = val/100;
            rplayer.audio.volume = val;
        } else {
            var val = rplayer.audio.volume;
            el.setAttribute('style','width:'+(val*100)+'%');
            return val;
        }
        return true;
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


/** To do */
rplayer.seek_fwd = function(){

}

rplayer.seek_bwd = function(){

}

rplayer.set_playlist = function(){

}

rplayer.get_playlist = function(){

}


rplayer.seekto = function(percent){
    if(rplayer.audio !== undefined){
        var max = rplayer.duration();
        var ct = (percent/100)*max;
        console.log(ct);
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
        rplayer.audio.loop = bool;
    }
    return false;
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
 * [cursor] Set the track elapsed cursor at it's position and the hh:mm:ss elapsed time
 * @param  {[string]} cursor_div  [div of the cursor to update width in percent from 0 to 100%]
 * @param  {[string]} counter_div [div of the time counter to update elapsed mins/seconds]
 */
rplayer.cursor = function(cursor_div,counter_div,duration_div){
    if(rplayer.audio !== undefined){
        rplayer.audio.addEventListener('timeupdate',function(evt){
            /** When timeupdate is triggered, update the two divs */
            var cd = document.getElementById(cursor_div);
            var ct = document.getElementById(counter_div);
            //Make updates calculations and transform seconds into hh:mm:ss
            ct.innerHTML = rplayer.formatElapsedTime(rplayer.played());
            cd.setAttribute("style","width:"+rplayer.formatElapsedPercent(rplayer.played(),rplayer.duration())+"%");
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

/** Different click events used by the player */
$(window).load(function(){
    /** Update volume by clicking on the cursor */
    $(document).on('click','#'+rplayer.config.volume_selected_div+",#"+rplayer.config.volume_cursor_div,function(e){
        var x = e.pageX - this.offsetLeft;
        var percent = Math.ceil((x/150)*100);
        rplayer.volume(percent);
    });
    /** Update track play position by clicking on the cursor */
    $(document).on('click','#'+rplayer.config.cursor_holder+",#"+rplayer.config.cursor_div,function(e){
        var x = e.pageX - this.offsetLeft;
        var percent = Math.ceil((x/300)*100);
        rplayer.seekto(percent);
    });
});