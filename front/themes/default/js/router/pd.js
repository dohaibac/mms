app.config(['$routeProvider', '$locationProvider', function AppConfig($routeProvider, $locationProvider) {
  $locationProvider.hashPrefix('!');
  $routeProvider
    .when('/list', {
        templateUrl: '//' + appConf.domain + '?mod=pd.list',
        controller: 'PdListCtrl'
    })
    .when('/add', {
        templateUrl: '//' + appConf.domain + '?mod=pd.add',
        controller: 'PdAddCtrl'
    })
    .when('/edit/:id', {
        templateUrl: '//' + appConf.domain + '?mod=pd.edit',
        controller: 'PdEditCtrl'
    })
    . otherwise({
        redirectTo: '/list'
      });;;
}]);