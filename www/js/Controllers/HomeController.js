app.controller('HomeController', function ($scope, $stateParams, $ionicPopup, Server) {
	
	Server.updateUser();
	
	$scope.books = [];
	$scope.$on('$ionicView.enter', function (e) {
		Server.updateUser();
		Server.get('books').then(function (resp) {
			$scope.books = resp.data;
		});
	});
	
	
	// Triggered on a button click, or some other target
	$scope.showPopup = function () {
		$scope.data = {};
		
		// An elaborate, custom popup
		var myPopup = $ionicPopup.show({
			template: '<input type="number" ng-model="data.pages">',
			title   : 'Introduceti numar pagini',
			scope   : $scope,
			buttons : [
				{text: 'Renunta'},
				{
					text : '<b>Salveaza</b>',
					type : 'button-positive',
					onTap: function (e) {
						console.log($scope.data.pages)
					}
				}
			]
		});
	}

    $scope.finish=function(finish){

        Server.post("finish",finish).success(function(){
            toastr.success("Felicitari! Ai castigat x puncte!")
            $state.go("app.home");
        });
	}
});
