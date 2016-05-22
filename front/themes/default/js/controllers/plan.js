app.controller('PlanListCtrl', function($rootScope, $scope, $http, $location, $modal, $BankService) {
  
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

  $scope.toggleSelection = function (item) {
    var idx = $scope.selectedItems.indexOf(item);
    if (idx > -1) {
      $scope.selectedItems.splice(idx, 1);
    }
    else {
      $scope.selectedItems.push(item);
    }
    $rootScope.$broadcast('grid:banks:checkbox:checked', $scope.selectedItems);
  };
  
  
  // JS Code for todoList
  
    $scope.today = new Date();
    $scope.saved = localStorage.getItem('taskItems');
    $scope.taskItem = (localStorage.getItem('taskItems')!==null) ? 
    JSON.parse($scope.saved) : [ {description: "Why not add a task?", date: $scope.today, complete: false}];
    localStorage.setItem('taskItems', JSON.stringify($scope.taskItem));
    
    $scope.newTask = null;
    $scope.newTaskDate = null;
    $scope.provinces = [
        {id: '1', name: 'Ha Noi'},
        {id: '2', name: 'TP HCM'},
        {id: '3', name: 'Hai Phong'},
        {id: '4', name: 'Da Nang'},
        {id: '5', name: 'Can Tho'}
    ];
    
    $scope.newProvinces = $scope.provinces;
    
    $scope.addNew = function () {
        if ($scope.newTaskDate == null || $scope.newTaskDate == '') {
            $scope.taskItem.push({
                description: $scope.newTask,
                date: "No deadline",
                complete: false,
                category: $scope.newProvinces.name
            }) 
        } else {
            $scope.taskItem.push({
                description: $scope.newTask,
                date: $scope.newTaskDate,
                complete: false,
                category: $scope.newProvinces.name
            })
        };
        $scope.newTask = '';
        $scope.newTaskDate = '';
        $scope.newTaskCategory = $scope.categories;
        localStorage.setItem('taskItems', JSON.stringify($scope.taskItem));
    };
    
    
    $scope.deleteTask = function () {
        var completedTask = $scope.taskItem;
        $scope.taskItem = [];
        angular.forEach(completedTask, function (taskItem) {
            if (!taskItem.complete) {
                $scope.taskItem.push(taskItem);
            }
        });
        localStorage.setItem('taskItems', JSON.stringify($scope.taskItem));
    };
    
    $scope.save = function () {
        localStorage.setItem('taskItems', JSON.stringify($scope.taskItem));
    }
});
