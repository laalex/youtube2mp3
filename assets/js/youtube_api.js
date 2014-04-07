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
        var data = {};
        data.iterator = [];
        $.each(response.result.items,function(){
            var entry = {};
            entry.thumb = this.snippet.thumbnails.default.url;
            entry.name = this.snippet.title;
            entry.view = this.id.videoId;
            entry.convert = "<span class='glyphicon glyphicon-download'></span>";
            data.iterator.push(entry);
        });
        jsnippets.load("youtube_results");
        jsnippets.dataload(data);
        jsnippets.replace("#video_search");
    });
}