app.config(['$routeProvider', '$locationProvider', function AppConfig($routeProvider, $locationProvider) {
  //$locationProvider.html5Mode({ enabled: true, requireBase: false});
  $locationProvider.hashPrefix('!');
  $routeProvider
    .when('/list', {
        templateUrl: '//' + appConf.domain + '?mod=gd.list',
        controller: 'GdListCtrl'
    })
    .when('/add', {
        templateUrl: '//' + appConf.domain + '?mod=gd.add',
        controller: 'GdAddCtrl'
    })
    .when('/edit/:id', {
        templateUrl: '//' + appConf.domain + '?mod=gd.edit',
        controller: 'GdEditCtrl'
    })
    . otherwise({
        redirectTo: '/list'
      });;
}]);