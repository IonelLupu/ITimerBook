app.controller('HomeController', function ($scope, $stateParams, $ionicPopup, Server, toastr) {
	
	Server.updateUser();
	
	$scope.contentLoaded = false;
	
	$scope.books = [];
	$scope.$on('$ionicView.enter', function (e) {
		Server.updateUser();
		Server.get('books').then(function (resp) {
			$scope.books = resp.data;
			$scope.contentLoaded = true;
		});
	});
	
	$scope.update = function(){
		$scope.$broadcast('$ionicView.enter');
	}
	
	
	// Triggered on a button click, or some other target
	$scope.showPopup = function (id) {
		$scope.data = {};

		// An elaborate, custom popup
		var myPopup = $ionicPopup.show({
			template: '<input type="number" ng-model="data.bookmark">',
			title   : 'Introduceti pagina actuala',
			scope   : $scope,
			buttons : [
				{text: 'Renunta'},
				{
					text : '<b>Salveaza</b>',
					type : 'button-positive',
					onTap: function (e) {
						var data = {
							bookmark: $scope.data.bookmark,
							id:id
						}
						Server.post("updatePages",data).success(function(){

							toastr.success("Felicitari! Numarul de pagini a fost actualizat cu success!")
							$scope.update()
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
            $scope.update()
        });
	}
	
	$scope.deleteBook = function(bookId){
		Server.post('deleteBook',{id:bookId}).success(function(){
            toastr.success("Cartea a fost stearsa cu succes!")
			$scope.update()
		})
	}
});
