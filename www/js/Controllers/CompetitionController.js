app.controller('CompetitionController', function($scope, $stateParams, Server) {

    $scope.competition = {
        starts_at :"19.12.16",
        ends_at :"25.12.16",
        points : "24.5.16",
        prize : {
            title : "Carte 1",
            author: "Ionel Florescu",
        },

    }
});
