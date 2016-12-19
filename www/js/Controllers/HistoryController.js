app.controller('HistoryController', function($scope, $state, $stateParams, toastr, Server) {
    Server.get("history").success(function(resp){
        $scope.books = resp;
    })

    $scope.books = [

        {
            id:"1",
            title : "Ana are mere",
            author: "Gigi",
            points: 200,
            ends_at:"15.12.2016"
        },

        {
            id:"2",
            title : "Lupu lpacalit de vulpe",
            author: "Digi",
            points: 400,
            ends_at:"12.12.2016"
        },

        {
            id:"3",
            title : "Lili si papucii",
            author: "Vigi",
            points: 50,
           ends_at:"18.12.2016"
        },
    ]
});