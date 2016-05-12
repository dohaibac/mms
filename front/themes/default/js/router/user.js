app.config(['$routeProvider', '$locationProvider', function AppConfig($routeProvider, $locationProvider) {
   $locationProvider.hashPrefix('!');
   $routeProvider
        .when('/info', {
            templateUrl: '//' + appConf.domain + '?mod=user.profile',
            controller: 'ProfileCtrl',
            title: 'Thong tin khach hang'
        })
        .when('/change-password', {
            templateUrl: '//' + appConf.domain + '?mod=user.changepassword',
            controller: 'ProfileCtrl',
            title: 'Thong tin khach hang'
        })
        .otherwise({
          redirectTo: '/info'
       });
}]);