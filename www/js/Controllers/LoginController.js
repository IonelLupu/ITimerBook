
app.controller('LoginController', function($scope,$state, $stateParams,Server) {
	
	$scope.automaticLogin = true;
	
	$scope.loginUser = function (data) {
		
		Server.post('auth',data).success(function (resp) {
			Server.setLoginToken(resp.token);
			Server.setUser(resp.user);
			$state.go("app.home");
		})
		
	};
	
	// check to see if there is a token saved on the client
	Server.get('user').success(function (user) {
		Server.setUser(user);
		$state.go('app.home');
	}).error(function(resp){
		$scope.automaticLogin = false;
	})
});
