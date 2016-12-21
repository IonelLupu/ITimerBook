app.controller('CompetitionController', function($scope, $stateParams, Server) {

    $scope.competition = {
        starts_at :"19.12.16",
        ends_at :"25.12.16",
        points : "200",
        prize : {
            title : "Carte 1",
            author: "Ionel Florescu",
        },
        book_to_read:"Maytreyi",
        author_to_read:"Mircea Eliade"

    }
});
