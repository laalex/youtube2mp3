//Controller
zonglistControllers.controller("viewplaylistController",['$scope', '$http','$routeParams',
	function ($scope, $http,$routeParams) {
		$scope.playlistID = $routeParams.playlistID;
		//Get current playlist details
		$http.get(baseurl+'playlists/get/'+$scope.playlistID).success(function(data){
			$scope.songs = data.playlist_songs;
			$scope.playlist = data.playlist_data;
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