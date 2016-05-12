app.config(['$routeProvider', '$locationProvider', function AppConfig($routeProvider, $locationProvider) {
   $locationProvider.hashPrefix('!');
   $routeProvider
        .when('/profit', {
            templateUrl: '//' + appConf.domain + '?mod=report.profit',
            controller: 'ReportProfitCtrl'
        })
        .when('/bankaccount', {
            templateUrl: '//' + appConf.domain + '?mod=report.bankaccount',
            controller: 'ReportBankaccountListCtrl'
        });
}]);