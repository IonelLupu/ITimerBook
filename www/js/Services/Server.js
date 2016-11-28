app.service('Server', function($http) {

    var serverURL = "http://localhost:8000/api/";

    this.post = function (route,data) {
        return $http.post(serverURL+route,data)
    }

    this.get = function (route) {
        return $http.get(serverURL+route)
    }


});