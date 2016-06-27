app.controller('PlanpdEditCtrl', function($scope, $http, $location, $modal, noty, $PlanpdService, $SponsorService) {
  
  $scope.pd = {};
  
  $scope.$on('planpd::edit', function(e, data) {
     $scope.pd = data.pd;
     $scope.mscope = data;
     $scope.amount_money_text = DocTienBangChu($scope.pd.amount * 10000);
  });
  
  $scope.noty = noty;
  
  $scope.processing = false;
  
  $scope.amount_money_text = '';
  
  $scope.disabled = function() {
    if (!$scope.pd.amount || $scope.processing) {
      return true;
    }
    
    return $scope.pd.amount.length > 0 ? false : true;
    
  };
  
  $scope.submit = function() {
    
    $scope.processing = true;
    
    $PlanpdService.auto_create_pd($scope.pd).then(function(response) {
      $scope.processing = false;
      
      if ($scope.message_type == 1) { 
        $scope.message_type = response.data.type;
        $scope.message = response.data.message;
      }
      else {
        $scope.pd.status = 1;
        $scope.mscope.cancel();
        $scope.noty.add({type:'info', title:'Thông báo', body: 'Xác nhận thành công!'});
      }
    });
  };
  
  $scope.convert_money = function () {
    $scope.amount_money_text = DocTienBangChu($scope.pd.amount * 10000);
  };
});

app.controller('PlanpdListCtrl', function($scope, $http, $timeout, $location, $modal, noty, $PlanpdService, $PlanpdListService, $SponsorService, ngTableParams) {
  var data = $PlanpdListService.data;
  $scope.noty = noty;
  
  $scope.loading = false;
  
  $scope.tableParams = new ngTableParams(
    {
      page: 1,            // show first page
      count: 25,           // count per page
      sorting: {sponsor:'asc'}
    },
    {
      total: 0, // length of data
      getData: function($defer, params) {
        $scope.loading = true;
        $PlanpdListService.getData($defer, params, $scope.filter).then(function(response) {
          $scope.loading = false;
          
          var data = response.data;
          params.total(data.total);
          $defer.resolve(data.planpds);
        });
      }
  });
  
  var filterTextTimeout;
  
  $scope.$watch("filter.$", function (val) {
    if (filterTextTimeout) $timeout.cancel(filterTextTimeout);
    
    filterTextTimeout = $timeout(function() {
       if ($scope.filter && $scope.filter.$ != '') {
         $scope.tableParams.$params.page = 1;
         $scope.tableParams.reload();
       }
    }, 250);
  });
  
  $scope.view_all = function (pd) {
    if ($scope.filter) $scope.filter.$ = '';
    $scope.tableParams.reload();
  };
  
  $scope.view_sponsor = function (pd) {
    var options = {
      'init': function(mscope) {
        $SponsorService.view(pd.sponsor).then(function(response) {
          
          var data = response.data;
          if (data.type == 1) {
            mscope.message = data.message;
            mscope.message_type = 1;
            return false;
          }
          
          mscope.sponsor = data.data;
          
          mscope.toggle_password = function() {
            if ($('#show_password').is(":checked")) {
              $('#password').attr('type', 'text');
            } else {
              $('#password').attr('type', 'password');
            }
         };
         
         mscope.toggle_security = function() {
            if ($('#show_security').is(":checked")) {
              $('#security').attr('type', 'text');
            } else {
              $('#security').attr('type', 'password');
            }
          };
        });
      }
    };
    
    $SponsorService.show_view_only(options);
  };
  
  $scope.confirm = function (pd) {
    var options = {
      'init': function(mscope) {
        mscope.pd = pd;
        mscope.pd.amount = '660';
        
        mscope.$broadcast('planpd::edit', mscope);
      }
    };
    
    $PlanpdService.show_confirm_modal(options).then(function() {
      
    });
  };
});

