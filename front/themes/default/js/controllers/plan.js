app.controller('PlanListCtrl', function($rootScope, $scope, $http, $location, $modal, $PlanService) {
    $scope.province_list = {};    
    $PlanService.get_provinces().then(function (largeLoad) {
      $scope.provinces = largeLoad.data.provinces;

      for (var i in largeLoad.data.provinces) {
        $scope.province_list[largeLoad.data.provinces[i].id] = largeLoad.data.provinces[i].name;
      }

    });
  
    $PlanService.get_list().then(function(response) {
      $scope.loading = false;
      if (response.data.type == 1) {
        $scope.message_type = 1;
        $scope.message = response.data.message;
        return;
      }

      $scope.taskItem = response.data.plans_list;
      //console.log($scope.plans);

    });
  // JS Code for todoList
  
    $scope.today = new Date();
    $scope.saved = localStorage.getItem('taskItems');
    //$scope.taskItem = (localStorage.getItem('taskItems')!==null) ? JSON.parse($scope.saved) : [ {description: "Why not add a task?", date: $scope.today, complete: false}];
    localStorage.setItem('taskItems', JSON.stringify($scope.taskItem));
    
    $scope.newTask = null;
    $scope.newTaskDate = null;
    $scope.newProvinces = "";
    
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
})
