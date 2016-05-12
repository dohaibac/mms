app.config(['$routeProvider', '$locationProvider', function AppConfig($routeProvider, $locationProvider) {
   //$locationProvider.html5Mode({ enabled: true, requireBase: false});
   $locationProvider.hashPrefix('!');
   $routeProvider
        .when('/setting', {
            templateUrl: '//' + appConf.domain + '?mod=system.setting',
            controller: 'SettingCtrl'
        })
        .when('/group/add', {
            templateUrl: '//' + appConf.domain + '?mod=group.add',
            controller: 'GroupAddCtrl'
        })
        .when('/group/list', {
            templateUrl: '//' + appConf.domain + '?mod=group.list',
            controller: 'GroupListCtrl'
        })
        .when('/group/edit/:groupId', {
            templateUrl: '//' + appConf.domain + '?mod=group.edit',
            controller: 'GroupEditCtrl'
        })
         .when('/group/edit/:groupId/delete', {
            controller: 'GroupDeleteCtrl'
        })
        .when('/user/add', {
            templateUrl: '//' + appConf.domain + '?mod=user.add',
            controller: 'UserAddCtrl'
        })
        .when('/user/add_downline', {
            templateUrl: '//' + appConf.domain + '?mod=user.add_downline',
            controller: 'UserAddDownlineCtrl'
        })
        .when('/user/list', {
            templateUrl: '//' + appConf.domain + '?mod=user.list',
            controller: 'UserListCtrl'
        })
        .when('/user/list_downline', {
            templateUrl: '//' + appConf.domain + '?mod=user.list_downline',
            controller: 'UserListDownlineCtrl'
        })
        .when('/user/edit_downline/:id/:sc', {
            templateUrl: '//' + appConf.domain + '?mod=user.edit_downline',
            controller: 'UserEditDownlineCtrl'
        })
        .when('/user/edit/:id', {
            templateUrl: '//' + appConf.domain + '?mod=user.edit',
            controller: 'UserEditCtrl'
        });
}]);