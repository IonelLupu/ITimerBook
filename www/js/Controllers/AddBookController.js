app.controller('AddBookController', function($scope, $state, $stateParams, toastr, Server) {
	$scope.addBook=function(book){
		
		Server.post("addBook",book).success(function(){
		toastr.success("Cartea a fost adaugata cu succes!")
			$state.go("app.home");
		})
	}
});
