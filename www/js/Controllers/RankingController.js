app.controller('RankingController', function($scope, $state, $stateParams, toastr, Server) {
    Server.get("rankings").success(function(resp){
        $scope.users = resp;
    })


    /*$scope.users = [

        {
           firstName:"Gigi",
           lastName:"Duta",
            points:1200
        },

        {
            firstName:"Lili",
            lastName:"Puta",
            points:1900
        },

        {
            firstName:"Piki",
            lastName:"Muta",
            points:100
        },
    ]*/
});