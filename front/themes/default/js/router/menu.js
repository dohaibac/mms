app.config(['$routeProvider', '$locationProvider', function AppConfig($routeProvider, $locationProvider) {
   $locationProvider.hashPrefix('!');
   $routeProvider
        .when('/add', {
            templateUrl: '//' + appConf.domain + '?mod=menu.add',
            controller: 'MenuAddCtrl'
        })
        .when('/list', {
            templateUrl: '//' + appConf.domain + '?mod=menu.list',
            controller: 'MenuListCtrl'
        });
}]);