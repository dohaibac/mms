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
        .when('/pd/approved', {
            templateUrl: '//' + appConf.domain + '?mod=dashboard.pd_approved',
            controller: 'PdexApprovedListCtrl'
        })
        .when('/planget', {
            templateUrl: '//' + appConf.domain + '?mod=dashboard.planget',
            controller: 'PlanGetListCtrl'
        })
        .when('/get', {
            templateUrl: '//' + appConf.domain + '?mod=dashboard.get',
            controller: 'GdexGetListCtrl'
        })
        .when('/gd', {
            templateUrl: '//' + appConf.domain + '?mod=dashboard.gd',
            controller: 'GdexGdListCtrl'
        })
        .when('/approve', {
            templateUrl: '//' + appConf.domain + '?mod=dashboard.approve',
            controller: 'GdexApproveListCtrl'
        })
        . otherwise({
          redirectTo: '/planpd'
        });;;
}]);