app.controller('HomeController', function ($scope, $stateParams, $ionicPopup, Server, toastr) {
	
	Server.updateUser();
	
	$scope.contentLoaded = false;
	
	$scope.books = [];
	$scope.$on('$ionicView.enter', function () {
		Server.updateUser();
		Server.get('books').success(function (books) {
			$scope.books         = books;
			$scope.contentLoaded = true;
		});
	});
	
	$scope.update = function () {
		$scope.$broadcast('$ionicView.enter');
	};
	
	
	// Triggered on a button click, or some other target
	$scope.showPopup = function (id) {
		$scope.data = {};
		
		// An elaborate, custom popup
		var myPopup = $ionicPopup.show({
			template: '<input type="number" ng-model="data.bookmark">',
			title   : 'Introduceti pagina actuala',
			scope   : $scope,
			buttons : [
				{text: 'Renunta'},
				{
					text : '<b>Salveaza</b>',
					type : 'button-positive',
					onTap: function (e) {
						var data = {
							bookmark: $scope.data.bookmark,
							id      : id
						}
						Server.post("updatePages", data).success(function (bookmark) {
							
							toastr.success("Numarul de pagini a fost actualizat cu success!")
							var book   = $scope.books.find(function (book) {
								return book.id == id
							});
							book.bookmark = bookmark;
						});
						
						//console.log($scope.data.pages)
					}
				}
			]
		});
	};
	
	$scope.finish = function (bookId) {
		
		var data = {
			id: bookId
		};
		Server.post("finish", data).success(function (points) {
			toastr.success("Felicitari! Ai castigat " + points + " puncte!")
			$scope.update()
		});
	};
	
	$scope.deleteBook = function (bookId) {
		Server.post('deleteBook', {id: bookId}).success(function () {
			toastr.success("Cartea a fost stearsa cu succes!")
			$scope.update()
		})
	};
	
	$scope.getProgressColor = function (progress) {
		
		var maxProgress = 120;
		
		var currentProgress = progress * maxProgress;
		
		return "hsla(" + currentProgress + ",100%,50%,1)";
	};
	
	$scope.getProgressWidth = function (currentPage, pages) {
		var value = (currentPage / pages) * 100;
		
		if (value == undefined)
			value = 0;
		return value + '%';
	}
    $scope.competition = {
        starts_at :"19.12.16",
        ends_at :"25.12.16",
        points : "300",
        prize : {
            title : "De la idee la bani",
            author: "Napoleon Hill",
        },
        book:"Maytreyi",
        author:"Mircea Eliade"

    }
});
