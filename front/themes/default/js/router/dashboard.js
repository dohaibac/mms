app.config(['$routeProvider', '$locationProvider', function AppConfig($routeProvider, $locationProvider) {
   $locationProvider.hashPrefix('!');
   $routeProvider
        .when('/planpd', {
            templateUrl: '//' + appConf.domain + '?mod=dashboard.planpd',
            controller: 'PlanpdListCtrl'
        })
        .when('/pd', {
            templateUrl: '//' + appConf.domain + '?mod=dashboard.pd',
            controller: 'PdexListCtrl'
        })
        .when('/get', {
            templateUrl: '//' + appConf.domain + '?mod=dashboard.get',
            controller: 'DashboardGetCtrl'
        })
        .when('/gd', {
            templateUrl: '//' + appConf.domain + '?mod=dashboard.gd',
            controller: 'GdListCtrl'
        })
        .when('/approve', {
            templateUrl: '//' + appConf.domain + '?mod=dashboard.approve',
            controller: 'DashboardApproveCtrl'
        })
        . otherwise({
          redirectTo: '/planpd'
        });;;
}]);