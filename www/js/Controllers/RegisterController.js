
app.controller('RegisterController', function($scope, $state, $stateParams, toastr, Server) {

    $scope.categories =
        {
            name:"Fantastic"
        },
        {
            name:"Mister"
        },
        {
            name:"Fictiune"
        },
        {
            name:"Realism"
        },
        {
            name:"Comedie"
        },
        {
            name:"Horor"
        },
        {
            name:"Romanta"
        },
        {
            name:"Satir"
        },
        {
            name:"Tragedie"
        },
        {
            name:"Folclor"
        },
    $scope.registerUser = function(data){

        Server.post('register',data).then(function(){
	        toastr.success('Ai fost inregistrat cu success');
            $state.go('login');
        })

    };

    if(Server.getUser())
        $state.go('app.home');
});
