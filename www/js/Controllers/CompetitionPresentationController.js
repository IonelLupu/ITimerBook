app.controller('CompetitionPresentationController', function ($scope, toastr, Server,$state) {
	
	Server.get('competition').success(function(competition){
		
		$scope.competition = competition;
	});
	
	
	$scope.participate = function () {
		
		var user = Server.getUser();
		
		if(user.isParticipant){
			return $state.go("app.competition");
		}
		
		Server.post('participate').success(function (canParticipate) {
			if (canParticipate) {
				toastr.success("Ai fost inregistrat cu succes in concurs.");
				return $state.go("app.competition");
			}
			
			Server.updateUser();
		});
	}
});
