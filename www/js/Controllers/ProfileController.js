app.controller('ProfileController', function ($scope, $stateParams, $ionicPopup, Server, toastr){


    Server.updateUser();

    $scope.user = Server.getUser();





    // Server.updateUser();

})