/**
 * Local storage actions and stuff
 * ===============================
 * First check if local storage is available
 */
if(typeof(Storage)!=="undefined"){
    //Show storage settings
    $("#app_state").show();

    //Check if we have app state enabled.
    if(localStorage.getItem('allow_storage')==="1"){
        /** When window has completed loading */
        $(window).load(function(){
            if(localStorage.getItem('app_url')){
                window.location = localStorage.getItem('app_url');
            }
            /** Update the MP3 status */
            while(rplayer.audio === undefined){};
            if(localStorage.getItem('rplayer_src')!==''){
                //The player has a song queued/playing. Update rplayer
                rplayer.volume(Number(localStorage.getItem('rplayer_vol')) * 100);
                rplayer.repeat(localStorage.getItem('rplayer_repeat'));
                if(localStorage.getItem('rplayer_state')=="false"){
                    //The player was playing. So start the play.
                    rplayer.playSong(localStorage.getItem('rplayer_src'),localStorage.getItem('song_name'),parseInt(localStorage.getItem('rplayer_played')));
                }
            }

        });

        save_state();

    } else {
        //Local Storage is not requested. But we save the last state anyway.
        save_state();
    }

} else {
    //Local storage is not available
}


//Function that saves the state of the application
function save_state(){
    /** When window has been closed */
    window.onbeforeunload = function(e){
        //Grab in the current application URL
        localStorage.setItem('app_url',window.location);
        //Grab the current rplayer settings
        localStorage.setItem('rplayer_src',rplayer.audio.src);
        localStorage.setItem('rplayer_vol',rplayer.volume());
        localStorage.setItem('rplayer_played',rplayer.played());
        localStorage.setItem('rplayer_state',rplayer.audio.paused);
        localStorage.setItem('rplayer_repeat',rplayer.audio.loop);
        var song_name = $("#"+rplayer.config.song_title_div).html();
        localStorage.setItem('song_name',song_name);
    }
}