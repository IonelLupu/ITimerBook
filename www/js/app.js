// Ionic Starter App

// angular.module is a global place for creating, registering and retrieving Angular modules
// 'starter' is the name of this angular module example (also set in a <body> attribute in index.html)
// the 2nd parameter is an array of 'requires'
// 'starter.controllers' is found in controllers.js
var app = angular.module('starter', ['ionic', 'starter.controllers', 'toastr'])
	
	.run(function ($ionicPlatform) {
		$ionicPlatform.ready(function () {
			// Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
			// for form inputs)
			if (window.cordova && window.cordova.plugins.Keyboard) {
				cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
				cordova.plugins.Keyboard.disableScroll(true);
				
			}
			if (window.StatusBar) {
				// org.apache.cordova.statusbar required
				StatusBar.styleDefault();
			}
		});
	})
	
	
	// .state('app.single', {
	//   url: '/playlists/:playlistId',
	//   views: {
	//     'menuContent': {
	//       templateUrl: 'templates/playlist.html',
	//       controller: 'PlaylistCtrl'
	//     }
	//   }
	
	.config(function ($stateProvider, $urlRouterProvider) {
		$stateProvider
			
			.state('app', {
				url        : '/app',
				abstract   : true,
				templateUrl: 'templates/menu.html',
				controller : 'AppCtrl'
			})
			.state('app.home', {
				url  : '/',
				views: {
					'menuContent': {
						templateUrl: 'templates/home.html',
						controller : 'HomeController'
					}
				},
				//reload: true,
				//cache: false,
			})
			
			.state('login', {
				url        : '/login',
				templateUrl: 'templates/login.html',
				controller : 'LoginController'
			})
			
			.state('register', {
				url        : '/register',
				templateUrl: 'templates/register.html',
				controller : 'RegisterController'
			})
			
			.state('app.addBook', {
				url  : '/addBook',
				views: {
					'menuContent': {
						templateUrl: 'templates/addBook.html',
						controller : 'AddBookController'
					}
				}
				
			})
			.state('app.competitionPresentation', {
				url  : '/competitionPresentation',
				views: {
					'menuContent': {
						templateUrl: 'templates/competitionPresentation.html',
						controller : 'CompetitionPresentationController'
					}
				}
				
			})
			.state('app.competition', {
				url  : '/competition',
				views: {
					'menuContent': {
						templateUrl: 'templates/competition.html',
						controller : 'CompetitionController'
					}
				}
				
			})

			.state('app.history', {
				url  : '/history',
				views: {
					'menuContent': {
						templateUrl: 'templates/history.html',
						controller : 'HistoryController'
					}
				}

			})

            .state('app.profile', {
                url  : '/profile',
                views: {
                    'menuContent': {
                        templateUrl: 'templates/profile.html',
                        controller : 'ProfileController'
                    }
                }

            });
		
		// if none of the above states are matched, use this as the fallback
		$urlRouterProvider.otherwise('/login');
	});
app.config(['$httpProvider', function ($httpProvider) {
	//Reset headers to avoid OPTIONS request (aka preflight)
	$httpProvider.defaults.headers.common = {};
	$httpProvider.defaults.headers.post   = {};
	$httpProvider.defaults.headers.put    = {};
	$httpProvider.defaults.headers.patch  = {};
	$httpProvider.defaults.useXDomain     = true;
	delete $httpProvider.defaults.headers.common['X-Requested-With'];
}]);

app.config(function (toastrConfig) {
	angular.extend(toastrConfig, {
		allowHtml  : true,
		progressBar: true,
		timeOut    : 10000,
	});
});