app.controller('CompetitionPresentationController', function($scope, $stateParams, Server) {

    $scope.competition = {
        starts_at :"19.12.2016",
        ends_at :"25.12.2016",
        points : "300",
        prize : {
            title : "De la idee la bani",
            author: "Napoleon Hill",
        },
        book:"Maytreyi",
        author:"Mircea Eliade"

    }
});
