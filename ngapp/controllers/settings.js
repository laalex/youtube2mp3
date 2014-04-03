//Controller
zonglistControllers.controller("settingsController",['$scope', '$http','$routeParams',
	function ($scope, $http,$routeParams) {

    if(typeof(Storage)!=="undefined"){
        //Show storage settings
        $("#app_state").show();
        //Check current application storage state
        if(localStorage.getItem('allow_storage')===null){
            //First time getting on the settings page. Add the local storage var
            //and set allow_storage to false
            localStorage.setItem('allow_storage',"0");
        }else{
            //We have enabled local storage. Check the value and mark the box
            if(localStorage.getItem('allow_storage')==="0"){
                $("#allow_storage_checkbox").prop('checked',false);
            } else {
                $("#allow_storage_checkbox").prop('checked',true);
            }
        }
    }
}]);