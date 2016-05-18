app.controller('PlanpdListCtrl', function($scope, $http, $location, $modal, noty, $PlanpdService) {
  
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
  
  $scope.confirm = function (pd) {
    alert('Dang cap nhat!');
  }
});
