/**
 * YouTube API requests
 * and stuff
 */

/** Instantiate the youtube API */
function loadYTApi() {
  gapi.client.setApiKey('AIzaSyAMiWBJxrHAv4hWpWBTihOCH9meUOZdofA');
  gapi.client.load('youtube', 'v3', youtubeLoaded());
}

/** Youtube loaded callback */
function youtubeLoaded(){
    /** Set a flag that youtube is loaded */
    YT_LOADED_SUCCESSFULLY = true;
}


/**
 * Search videos by keywords
 */
function youtube_search(keywords,result_div){
    var request = gapi.client.youtube.search.list({
        q: keywords,
        part: 'snippet'
    });

    request.execute(function(response) {
        //var str = JSON.stringify(response.result);
        $(result_div).html("");
        $.each(response.result.items,function(){
            console.log(this.snippet);
            $(result_div).append(this.snippet.title + '<br />');
        });
    });
}