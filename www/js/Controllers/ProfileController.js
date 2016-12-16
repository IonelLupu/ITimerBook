app.controller('ProfileController', function ($scope, $stateParams, $ionicPopup, Server, toastr) {
	
	$scope.user = Server.getUser();
	
	var minutesForReading = $scope.user.minutesForReading;
	$scope.user.hours     = parseInt(minutesForReading / 60);
	$scope.user.minutes   = minutesForReading % 60;
	
	$scope.updateUser = function (data) {
		console.log("data ->",data);
	};
	
	// Server.updateUser();
});