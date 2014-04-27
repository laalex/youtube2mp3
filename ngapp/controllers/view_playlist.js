//Controller
zonglistControllers.controller("viewplaylistController",['$scope', '$http','$routeParams',
	function ($scope, $http,$routeParams) {
		$scope.playlistID = $routeParams.playlistID;
		//Get current playlist details
		if(window.location.hash.search("share")!==-1){
			//Get the shared playlist
			$http.get(baseurl+'playlists/get_shared/'+$scope.playlistID).success(function(data){
				$scope.songs = data.playlist_songs;
				$scope.playlist = data.playlist_data;
			});
		} else {
			//Get the user playlist
			$http.get(baseurl+'playlists/get/'+$scope.playlistID).success(function(data){
				$scope.songs = data.playlist_songs;
				$scope.playlist = data.playlist_data;
			});
		}
		//Poll server for updates every 5 seconds
		window.setInterval(function(){
			if(window.location.hash.search("share")!==-1){
				//Get the shared playlist
				$http.get(baseurl+'playlists/get_shared/'+$scope.playlistID).success(function(data){
					$scope.songs = data.playlist_songs;
					$scope.playlist = data.playlist_data;
				});
			} else {
				//Get the user playlist
				$http.get(baseurl+'playlists/get/'+$scope.playlistID).success(function(data){
					$scope.songs = data.playlist_songs;
					$scope.playlist = data.playlist_data;
				});
			}
		},5000);


		/**
		 * Load playlists
		 */
		$http.get(baseurl+'playlists/getPlaylists').success(function(data){
			$scope.playlists = data;
		});

		//GetSongCount
		$scope.GetSongCount = function(){
			count = 0;
			angular.forEach($scope.songs, function(song) {
		      count++;
		    });
			return count;
		}
}]);