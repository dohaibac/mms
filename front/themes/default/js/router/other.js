app.config(['$routeProvider', '$locationProvider', function AppConfig($routeProvider, $locationProvider) {
   $locationProvider.hashPrefix('!');
   $routeProvider
        .when('/candidate/add', {
            templateUrl: '//' + appConf.domain + '?mod=candidate.add',
            controller: 'CandidateAddCtrl'
        })
        .when('/candidate/list', {
            templateUrl: '//' + appConf.domain + '?mod=candidate.list',
            controller: 'CandidateListCtrl'
        })
        .when('/candidate/list/:province_id', {
            templateUrl: '//' + appConf.domain + '?mod=candidate.list',
            controller: 'CandidateListCtrl'
        })
        .when('/candidate/edit/:id', {
            templateUrl: '//' + appConf.domain + '?mod=candidate.edit',
            controller: 'CandidateEditCtrl'
        })
         .when('/candidate/edit/:id/delete', {
            controller: 'CandidateDeleteCtrl'
        })
        .when('/plan/add', {
            templateUrl: '//' + appConf.domain + '?mod=plan.add',
            controller: 'PlanAddCtrl'
        })
        .when('/plan/list', {
            templateUrl: '//' + appConf.domain + '?mod=plan.list',
            controller: 'PlanListCtrl'
        })
        .when('/plan/edit/:id', {
            templateUrl: '//' + appConf.domain + '?mod=plan.edit',
            controller: 'PlanEditCtrl'
        })
         .when('/plan/edit/:id/delete', {
            controller: 'PlanDeleteCtrl'
        });
}]);
