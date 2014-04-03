//Controller
zonglistControllers.controller("inviteController",['$scope', '$http',
    function ($scope, $http) {
        //Get the entire invitations
        $http.get(baseurl+'invitations/getInvitations').success(function(data){
            $scope.invites = data;
        });
}]);