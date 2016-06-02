app.controller('PlanListCtrl', function($rootScope, $scope, $http, $location, $modal, $PlanService) {
    $scope.province_list = {};    
    $PlanService.get_provinces().then(function (largeLoad) {
      $scope.provinces = largeLoad.data.provinces;

      for (var i in largeLoad.data.provinces) {
        $scope.province_list[largeLoad.data.provinces[i].id] = largeLoad.data.provinces[i].name;
      }

    });
  
    $scope.planslist = function (){
      $scope.taskItem = {};
      $PlanService.get_list().then(function(response) {
        $scope.loading = false;
        if (response.data.type == 1) {
          $scope.message_type = 1;
          $scope.message = response.data.message;
          return;
        }

        $scope.taskItem = response.data.plans_list;
        
      });
    }
  // JS Code for todoList
  
    today = new Date();
    //$scope.saved = localStorage.getItem('taskItems');
    //$scope.taskItem = (localStorage.getItem('taskItems')!==null) ? JSON.parse($scope.saved) : [ {description: "Why not add a task?", date: $scope.today, complete: false}];
    //localStorage.setItem('taskItems', JSON.stringify($scope.taskItem));
    
    $scope.newTask = null;
    $scope.newTaskDate = null;
    $scope.newProvinces = "";
    
    $scope.addNew = function () {
      $planItem = {};
        if ($scope.newTaskDate == null || $scope.newTaskDate == '') {
            $planItem["taskdate"] = "No deadline";
        } else {
            $planItem["taskdate"] =  $scope.newTaskDate;
        }

        $planItem["province"] = $scope.newProvinces.id;
        $planItem["description"] = $scope.newTask;
        
        $PlanService.add($planItem);
        
        $scope.newTask = '';
        $scope.newTaskDate = '';
        //$scope.newTaskCategory = $scope.categories;
        //localStorage.setItem('taskItems', JSON.stringify($scope.taskItem));
        
        $scope.planslist();
    };
    
    
    $scope.deleteTask = function () {
        var completedTask = $scope.taskItem;
        var tasks_id = [];
        $tasks_list = {};
        angular.forEach(completedTask, function (taskItem) {
            if (taskItem.taskStatus == 1) {
              tasks_id.push(taskItem.id);
            }
        });

        $tasks_list["task_id"] = tasks_id;

        $PlanService.delete($tasks_list);
        $scope.planslist();
    };
    
    $scope.save = function (task_id) {
      $planItem = {};
      $planItem["task_id"] = task_id;
      $PlanService.update_status($planItem);
      $scope.planslist();
    };
    
    $scope.get_candidate = function(province_id){
        //alert(province_id);
    };
    
    $scope.planslist();
});
