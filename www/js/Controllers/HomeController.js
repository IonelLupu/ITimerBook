app.controller('HomeController', function ($scope, $stateParams, $ionicPopup, Server, toastr) {
	
	Server.updateUser();
	
	$scope.books = [];
	$scope.$on('$ionicView.enter', function (e) {
		Server.updateUser();
		Server.get('books').then(function (resp) {
			$scope.books = resp.data;
		});
	});
	
	
	// Triggered on a button click, or some other target
	$scope.showPopup = function (id) {
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
						var data = {
							pages: $scope.data.pages,
							id:id
						}
						Server.post("updatePages",data).success(function(){

							toastr.success("Felicitari! Numarul de pagini a fost actualizat cu success!")
							$scope.$broadcast("$ionicView.enter")
						})

						//console.log($scope.data.pages)
					}
				}
			]
		});
	}

    $scope.finish = function(bookId){

		var data = {
			id : bookId
		};
        Server.post("finish",data).success(function(){
            toastr.success("Felicitari! Ai castigat x puncte!")
            $scope.$broadcast("$ionicView.enter")
        });
	}
});
