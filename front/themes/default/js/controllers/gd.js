app.controller('GdListCtrl', function($scope, $http, $location, $modal, noty, $GdService) {
  
  $scope.noty = noty;
  
  $scope.gds = {};
  
  $scope.loading = false;
  
  $scope.init = function () {
    $scope.loading = true;
    
    $GdService.get_list().then(function(response) {
      $scope.loading = false;
      if (response.data.type == 1) {
        $scope.message_type = 1;
        $scope.message = response.data.message;
        return;
      }
      
      $scope.gds = response.data.gds;
      
    });
  };
  
  $scope.delete = function(gd) {
     if (!confirm_del()) {
       return false;
     }
     
    $scope.processing = true;
    
    $GdService.delete(gd).then(function(response) {
      $scope.processing = false;
      $scope.noty.add({type:'info', title:'Thông báo', body:response.data.message});
      $scope.init();
    });
    
  };
});

app.controller('GdAddCtrl', function($scope, $http, $location, $modal, $GdService, $SponsorService, $SettingService, $BankService, noty) {
  $scope.processing = false;
  $scope.noty = noty;
  
  $scope.gd = {};
  $scope.sponsor_check = {};
  
  var d = new Date();
  
  $scope.gd.issued_at = d.toLocaleDateString("VN-vi") + ' ' + d.getHours() + ':'+ d.getMinutes() + ':' + d.getSeconds();
  
  $scope.optionStatus= [
    {'id': 1, 'name': 'Pending'},
    {'id': 2, 'name': 'Approved'},
    {'id': 3, 'name': 'Done'}
  ];
  
  $scope.init = function () {
    var default_sponsor = '';
     
     $SponsorService.get_sponsor_owner().then(function(resp) {
        default_sponsor = resp.data.sponsor_owner;
        
        $SponsorService.get_list().then(function(response) {
          $scope.sponsors = response.data.sponsors;
          
          for (var i=0; i < $scope.sponsors.length; i++) {
            if ($scope.sponsors[i].username == default_sponsor) {
              $scope.gd.sponsor = $scope.sponsors[i];
            }
          }
        });
     }); 
    
    $SettingService.view().then(function(response) {
      $scope.gd.num_hours_gd_approve = response.data.num_hours_gd_approve;
    });
    
    $scope.gd.status = {'id': 1, 'name': 'Pending'};
    
    $scope.get_bank_list();
  };
  
  $scope.disabled = function() {
    if (!$scope.gd.code || !$scope.gd.sponsor || !$scope.gd.amount ||
       !$scope.gd.wallet || !$scope.gd.issued_at || !$scope.gd.num_hours_gd_approve ||
       !$scope.gd.status || $scope.processing) {
      return true;
    }
    
    return $scope.gd.code.length > 0 && $scope.gd.sponsor.username && $scope.gd.sponsor.username.length > 0 && 
    $scope.gd.amount.length > 0 && $scope.gd.wallet.length > 0 && $scope.gd.issued_at.length > 0 && 
    $scope.gd.num_hours_gd_approve.length > 0 ? false : true;
    
  };
  $scope.get_bank_list = function() {
    $BankService.get_list().then(function(response){
      $scope.banks = response.data.banks;
    });
  };
  
  $scope.show_bank_add = function() {
    var options = {
      'init': function(mscope) {
        mscope.bank = {};
      },
      'disabled': function(mscope) {
        var bank = mscope.bank;
        if (!bank || !bank.name || !bank.branch_name || !bank.account_hold_name || 
        !bank.account_number || !bank.linked_mobile_number || mscope.processing) {
          return true;
        }
        
        return mscope.bank.name.length > 0 && mscope.bank.branch_name.length > 0 
          && mscope.bank.account_hold_name.length > 0 && mscope.bank.account_number.length > 0 && mscope.bank.linked_mobile_number.length > 0 ? false : true;
      },
      'ok': function (mscope) {
        $BankService.add(mscope.bank).then(function(response) {
          var data = response.data;
          if (data && data.type == 1) {
            mscope.message = data.message;
          }
          else {
            mscope.close();
            $scope.get_bank_list();
          }
        });
      },
    };
    
    $BankService.show_add_modal(options);
  };
 
  $scope.submit = function() {
    
    $scope.processing = true;
    
    $GdService.add($scope.gd).then(function(response) {
      $scope.message_type = response.data.type;
      $scope.message = response.data.message;
      $scope.processing = false;
    });
  };
 
});

app.controller('GdEditCtrl', function($scope, $routeParams, $location, $modal, $GdService, $SponsorService, $SettingService, $BankService, noty) {
  $scope.processing = false;
  $scope.noty = noty;
  
  $scope.gd = {};
  
  $scope.optionStatus= [
    {'id': 1, 'name': 'Pending'},
    {'id': 2, 'name': 'Approved'},
    {'id': 3, 'name': 'Done'}
  ];
  $scope.gd.id = $routeParams.id;
  
  $scope.init = function() {
    $GdService.view($scope.gd.id).then(function(response) {
      $scope.gd = response.data;
      
      var status = $scope.gd.status;
      
      if (status == 1) {
        $scope.gd.status = {'id': 1, 'name': 'Pending'};
      }
      if (status == 2) {
        $scope.gd.status = {'id': 2, 'name': 'Approved'};
      }
      if (status == 3) {
        $scope.gd.status = {'id': 3, 'name': 'Done'};
      }
    });
    
    $scope.get_bank_list();
    
    $SponsorService.get_list().then(function(response) {
      $scope.sponsors = response.data.sponsors;
      
      for (var i=0; i < $scope.sponsors.length; i++) {
        if ($scope.sponsors[i].username == $scope.gd.sponsor) {
          $scope.gd.sponsor = $scope.sponsors[i];
        }
      }
    });
  };
   
   $scope.get_bank_list = function() {
    $BankService.get_list().then(function(response){
      $scope.banks = response.data.banks;
      
      for (var i=0; i < $scope.banks.length; i++) {
        if ($scope.banks[i].id == $scope.gd.bank_id) {
          $scope.gd.bank = $scope.banks[i];
        }
      } 
    });
  };
  
   $scope.disabled = function() {
    if (!$scope.gd.code || !$scope.gd.sponsor || !$scope.gd.amount ||
       !$scope.gd.wallet || !$scope.gd.issued_at || !$scope.gd.num_hours_gd_approve ||
       !$scope.gd.status || $scope.processing) {
      return true;
    }
    
    return $scope.gd.code.length > 0 && $scope.gd.sponsor.username && $scope.gd.sponsor.username.length > 0 && 
    $scope.gd.amount.length > 0 && $scope.gd.wallet.length > 0 && $scope.gd.issued_at.length > 0 && 
    $scope.gd.num_hours_gd_approve.length > 0 ? false : true;
    
  };
  
  $scope.show_bank_add = function() {
    var options = {
      'init': function(mscope) {
        mscope.bank = {};
      },
      'disabled': function(mscope) {
        var bank = mscope.bank;
        if (!bank || !bank.name || !bank.branch_name || !bank.account_hold_name || 
        !bank.account_number || !bank.linked_mobile_number || mscope.processing) {
          return true;
        }
        
        return mscope.bank.name.length > 0 && mscope.bank.branch_name.length > 0 
          && mscope.bank.account_hold_name.length > 0 && mscope.bank.account_number.length > 0 && mscope.bank.linked_mobile_number.length > 0 ? false : true;
      },
      'ok': function (mscope) {
        $BankService.add(mscope.bank).then(function(response) {
          var data = response.data;
          if (data && data.type == 1) {
            mscope.message = data.message;
          }
          else {
            mscope.close();
            $scope.get_bank_list();
          }
        });
      },
    };
    
    $BankService.show_add_modal(options);
  };
  
  $scope.submit = function() {
    
    $scope.processing = true;
    
    $GdService.edit($scope.gd).then(function(response) {
      $scope.message_type = response.data.type;
      $scope.message = response.data.message;
      $scope.processing = false;
    });
  };
 
});