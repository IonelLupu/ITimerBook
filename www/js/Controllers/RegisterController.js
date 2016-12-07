app.controller('RegisterController', function ($scope, $state, $stateParams, toastr, Server) {
	
	$scope.categories   = [];
	
	Server.get('categories').success(function (categories) {
		$scope.categories   = categories;
	});
	
	$scope.data = {
		categories : {}
	};
	
	$scope.registerUser = function (data) {
		//return console.log("data ->",data);
		Server.post('register', data).then(function () {
			toastr.success('Ai fost inregistrat cu success');
			$state.go('login');
		})
	};
	
	if (Server.getUser())
		$state.go('app.home');
});
