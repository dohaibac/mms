app.config(['$routeProvider', '$locationProvider', function AppConfig($routeProvider, $locationProvider) {
  //$locationProvider.html5Mode({ enabled: true, requireBase: false});
  $locationProvider.hashPrefix('!');
  $routeProvider
    .when('/list', {
        templateUrl: '//' + appConf.domain + '?mod=sponsor.list',
        controller: 'SponsorListCtrl'
    })
    .when('/add', {
        templateUrl: '//' + appConf.domain + '?mod=sponsor.add',
        controller: 'SponsorAddCtrl'
    })
    .when('/edit/:id', {
        templateUrl: '//' + appConf.domain + '?mod=sponsor.edit',
        controller: 'SponsorEditCtrl'
    });
}]);