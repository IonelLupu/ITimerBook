app.controller('ProfileController', function ($scope, $stateParams, $ionicPopup, Server, toastr) {
	
	$scope.user = Server.getUser();
	
	var minutesForReading = $scope.user.minutesForReading;
	$scope.user.hours     = parseInt(minutesForReading / 60);
	$scope.user.minutes   = minutesForReading % 60;
	
	$scope.updateUser = function (data) {
		console.log("data ->",data);
	};

    $scope.updateProfile = function(user){

        var data = {
            firstName: user.firstName,
            lastName: user.lastName,
            email: user.email,
            address: user.address,
            hours: user.hours,
            minutes: user.minutes
           }

    	Server.post("updateProfile", data).success(function () {

            toastr.success("Datele de profil au fost actualizate cu succes !")

            });

	}
	// Server.updateUser();
});