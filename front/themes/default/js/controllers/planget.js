app.controller('PlanGetListCtrl', function($scope, $http, $location, $modal, noty, $PlanGetService, $SponsorService) {
  
  $scope.noty = noty;
  
  $scope.plangets = [];
  
  $scope.loading = false;
  
  $scope.init = function () {
    $scope.loading = true;
    $PlanGetService.get_all().then(function(response) {
      $scope.loading = false;
      if (response.data.type == 1) {
        $scope.message_type = 1;
        $scope.message = response.data.message;
        return;
      }
      
      $scope.from_date = response.data.from_date;
      $scope.plangets = response.data.plangets;
    });
  };
  
  $scope.view_sponsor = function (get) {
    var options = {
      'init': function(mscope) {
        $SponsorService.view(get.sponsor).then(function(response) {
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
  
  $scope.confirm = function (get) {
    var options = {
      'init': function(mscope) {
        mscope.get = get;
        
        mscope.$broadcast('planget::edit', mscope);
      }
    };
    
    $PlanGetService.show_confirm_modal(options).then(function() {
      
    });
  };
  
});

app.controller('PlanGetEditCtrl', function($scope, $http, $location, $modal, noty, $PlanGetService, $SponsorService) {
  
  $scope.noty = noty;
  
  $scope.processing = false;
  
  $scope.amount_money_text = '';
  
  $scope.get = {};
  
  $scope.$on('planget::edit', function(e, data) {
    $scope.get = data.get;
    $scope.mscope = data;
    $scope.amount_money_text = DocTienBangChu($scope.get.amount * 10000);
  });
  
  $scope.disabled = function() {
    if (!$scope.get.amount || $scope.processing) {
      return true;
    }
    
    return $scope.get.amount.length > 0 ? false : true;
    
  };
  
  $scope.submit = function() {
    
    $scope.processing = true;
    
    $PlanGetService.auto_create_get($scope.get).then(function(response) {
      $scope.processing = false;
      
      if ($scope.message_type == 1) { 
        $scope.message_type = response.data.type;
        $scope.message = response.data.message;
      }
      else {
        $scope.get.status = 1;
        $scope.mscope.cancel();
        $scope.noty.add({type:'info', title:'Thông báo', body: 'Xác nhận thành công!'});
      }
    });
  };
  
  $scope.convert_money = function () {
    $scope.amount_money_text = DocTienBangChu($scope.get.amount * 10000);
  };
});

