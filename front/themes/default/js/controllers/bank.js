app.controller('BankListCtrl', function($rootScope, $scope, $http, $location, $modal, $BankService) {
  
  $scope.selectedItems = [];
  
  $scope.init = function () {
    $BankService.get_list().then(function(response) {
      $scope.banks = response.data.banks;
      $scope.total = response.data.total;
    });
  };
  
  $scope.add = function () {
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
            $scope.refresh();
          }
        });
      },
    };
    $BankService.show_add_modal(options);
  };
  
  $scope.edit = function (bank) {
    var options = {
      'init': function(mscope) {
        mscope.bank = bank;
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
        $BankService.edit(mscope.bank).then(function(response) {
          var data = response.data;
          if (data && data.type == 1) {
            mscope.message = data.message;
          }
          else {
            mscope.close();
            $scope.refresh();
          }
        });
      },
    };
    $BankService.show_edit_modal(options);
  };
  
  $scope.delete = function (bank) {
    if (!confirm_del()) {
      return false;
    }
    
    $BankService.delete(bank).then(function(response) {
      $scope.refresh();
    });
    
  };
  $scope.refresh = function() {
    $scope.init();
  };
});
