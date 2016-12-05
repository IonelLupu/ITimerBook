angular.module('starter.controllers', [])
	
	.controller('AppCtrl', function ($rootScope,$scope, $ionicModal, $timeout, $state,toastr, Server) {
		
		// With the new view caching in Ionic, Controllers are only called
		// when they are recreated or on app start, instead of every page change.
		// To listen for when this page is active (for example, to refresh data),
		// listen for the $ionicView.enter event:
		//$scope.$on('$ionicView.enter', function(e) {
		//});
		
		// Form data for the login modal
		$scope.loginData = {};
		
		$scope.user = Server.getUser();
		if( !$scope.user )
			$state.go('login');
		
		$scope.$on('updateUser', function (event, user) {
			$scope.user = user;
		});
		
		$scope.logout = function(){
			Server.setUser(null);
			Server.setLoginToken(null);
			$state.go('login');
		};
		
		// check fi user is logged in
		Server.get('user').error(function(){
			toastr.error('Ai fost delogat de server. Logeaza-te din nou!');
			$scope.logout();
		})
	});