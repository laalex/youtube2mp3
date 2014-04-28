//Controller
zonglistControllers.controller("playlistsController",['$scope', '$http',
	function ($scope, $http) {
		//Get the entire playlists
		$http.get(baseurl+'playlists/getPlaylists').success(function(data){
			$scope.playlists = data;
		});


		//Get playlist counts
		$scope.playlistsCount = function(){
			var count=0;
			angular.forEach($scope.playlists, function(playlist) {
		      count++;
		    });
			return count;
		}

		//Add plylist to the app
		$scope.addPlaylist = function(){
			$http.post(baseurl+'ajax/playlists',{action:'add_playlist',playlist_name:$scope.name}).success(function(data){
				//Update whatchdog with the data
				$("#watchdog").html(data.message).fadeIn().delay(3000).fadeOut();
				$scope.playlists.push(data.playlist);
			});
		}

		$scope.makeDefault = function(){
			if(this.playlist.list_id){
				$http.get(baseurl+'playlists/set_default/'+this.playlist.list_id).success(function(){
					$("#whatchdog").html("You have changed your default list");
					//Rebuild playlists
					$http.get(baseurl+"playlists/getPlaylists").success(function(data){
						$scope.playlists = data;
					});
				});
			}

		}

		//Remove a playlist from the application
		$scope.confirmAction = function(){
			$scope.removeid = $("#confirm_url").val();
			$http.get(baseurl+'playlists/remove/'+$scope.removeid).success(function(){});
			//Rebuild playlists
			$http.get(baseurl+'playlists/getPlaylists').success(function(data){
				$scope.playlists = data;
				$(".modal").modal('toggle');
			});
		}
}]);