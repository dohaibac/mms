app.controller('DashboardCtrl', function($scope, $http, $PdService, $GdService) {
  
  $scope.pds = {};
  $scope.loading = false;
  $scope.myData = [];

  $scope.init = function () {
    $scope.loading = true;
    
      $PdService.get_status().then(function(response) {
      $scope.loading = false;
      if (response.data.type == 1) {
        $scope.message_type = 1;
        $scope.message = response.data.message;
        return;
      }
      
      $scope.pds = response.data.pds;
      console.log($scope.pds);

    });
  };
});
