app.controller('HistoryController', function($scope, $state, $stateParams, toastr, Server) {
    Server.get("history").success(function(resp){
        $scope.books = resp;
    })

    $scope.books = [

        {
            title : "Ana are mere",
            author: "Gigi",
            points: 200,
            pages: 200
        },

        {
            title : "Lupu lpacalit de vulpe",
            author: "Digi",
            points: 400,
            pages: 400
        },

        {
            title : "Lili si papucii",
            author: "Vigi",
            points: 50,
            pages: 50
        },
    ]
});