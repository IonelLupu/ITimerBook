
app.controller('RegisterController', function($scope, $stateParams, Server) {


    $scope.registerUser = function(data){

        Server.post('register',data).then(function(resp){
            console.log(resp);
        })

    }

});
