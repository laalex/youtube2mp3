<!DOCTYPE html>
<html>
<head>
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript">
        function loadApi() {
          gapi.client.setApiKey('AIzaSyAMiWBJxrHAv4hWpWBTihOCH9meUOZdofA');
          gapi.client.load('youtube', 'v3', youtubeLoaded());
        }

        function youtubeLoaded(){
            window.setTimeout(function(){
                var request = gapi.client.youtube.search.list({
                    q: "salam",
                    part: 'snippet'
                  });

                  request.execute(function(response) {
                    console.log(response);
                  });
            },2000);

        }

    </script>


</head>
<body>

</body>
</html>