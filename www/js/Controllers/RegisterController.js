
app.controller('RegisterController', function($scope, $state, $stateParams, toastr, Server) {


    $scope.registerUser = function(data){

        Server.post('register',data).then(function(){
	        toastr.success('Ai fost inregistrat cu success');
            $state.go('login');
        })

    };

    if(Server.getUser())
        $state.go('app.home');
});
