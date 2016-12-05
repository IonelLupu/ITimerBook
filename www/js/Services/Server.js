app.service('Server', function ($http, toastr) {
	var Server = this;
	
	var serverURL = "http://localhost:8000/api/";
	
	function request(route, data, method) {
		var loginToken = Server.getLoginToken();
		return $http({
			method : method,
			url    : serverURL + route,
			headers: {
				'Content-Type' : 'application/json',
				'Accept'       : 'application/json',
				'Authorization': 'Bearer ' + loginToken
			},
			data   : data
		}).error(function (resp) {
			console.error("server error ->",resp);
			var firstError = resp[Object.keys(resp)[0]];
			if( firstError.constructor == Array ){
				toastr.error(firstError[0]);
			}
		});
	}
	
	this.post = function (route, data) {
		return request(route, data, "POST")
	};
	
	this.get = function (route) {
		return request(route, '', "GET")
	};
	
	this.setLoginToken = function (token) {
		localStorage.setItem('_token', token);
	};
	
	this.getLoginToken = function () {
		return localStorage.getItem('_token');
	};
	
	this.setUser = function (user) {
		localStorage.setItem('_user',JSON.stringify(user));
	};
	
	this.getUser = function () {
		var user = localStorage.getItem('_user')
		if( user != 'undefined' ){
			return JSON.parse(user);
		}
		return null;
	};
	
});