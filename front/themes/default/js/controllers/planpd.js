app.controller('PlanpdListCtrl', function($scope, $http, $location, $modal, noty, $PlanpdService, $SponsorService) {
  
  $scope.noty = noty;
  
  $scope.planpds = [];
  
  $scope.loading = false;
  
  $scope.init = function () {
    $scope.loading = true;
    $PlanpdService.get_all().then(function(response) {
      $scope.loading = false;
      if (response.data.type == 1) {
        $scope.message_type = 1;
        $scope.message = response.data.message;
        return;
      }
      
      $scope.from_date = response.data.from_date;
      $scope.planpds = response.data.planpds;
    });
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

