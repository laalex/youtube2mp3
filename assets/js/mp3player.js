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
 * Init the rplayer object with the id of the <audio> element
 */
rplayer.init = function(player_id){
    rplayer.audio = document.getElementById(player_id);
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
        rplayer.audio.play();
        /** Create method to see if we can play the song */
        return true;
    }
}

/**
 * [setVolume] - Set the volume for the mp3 player
 * @param {[float]} val [range between 0.0 and 1]
 */
rplayer.volume = function(val){
    if(rplayer.audio !== undefined){
        rplayer.audio.volume = val;
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
rplayer.duration = function(){
    if(rplayer.audio !== undefined){
        return rplayer.audio.duration;
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

/**
 * [cursor] Set the track elapsed cursor at it's position
 * @param  {[string]} cursor_div  [div of the cursor to update width in percent from 0 to 100%]
 * @param  {[string]} counter_div [div of the time counter to update elapsed mins/seconds]
 */
rplayer.cursor = function(cursor_div,counter_div){
    if(rplayer.audio !== undefined){
        rplayer.audio.addEventListener('timeupdate',function(evt){
            /** When timeupdate is triggered, update the two divs */
            var cd = document.getElementById(cursor_div);
            var ct = document.getElementById(counter_div);
            //Make updates calculations
            ct.innerHTML = rplayer.played();
        });
    }
}