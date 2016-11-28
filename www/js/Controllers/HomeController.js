app.controller('HomeController', function($scope, $stateParams, Server) {
  
	$scope.books = [];
	
	Server.get('books').then(function(resp){
		$scope.books = resp.data;
	})
	
});
