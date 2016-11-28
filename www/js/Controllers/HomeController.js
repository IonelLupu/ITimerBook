app.controller('HomeController', function($scope, $stateParams, $ionicPopup , Server) {
  
	$scope.books = [];
	
	Server.get('books').then(function(resp){
		$scope.books = resp.data;
	})

	// Triggered on a button click, or some other target
	$scope.showPopup = function() {
		$scope.data = {};

		// An elaborate, custom popup
		var myPopup = $ionicPopup.show({
			template: '<input type="number" ng-model="data.wifi">',
			title: 'Introduceti numar pagini',
			scope: $scope,
			buttons: [
				{text: 'Renunta'},
				{
					text: '<b>Salveaza</b>',
					type: 'button-positive',
					onTap: function (e) {
						if (!$scope.data.wifi) {
							//don't allow the user to close unless he enters wifi password
							e.preventDefault();
						} else {
							return $scope.data.wifi;
						}
					}
				}
			]
		});
	}
});
