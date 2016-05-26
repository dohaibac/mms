app.controller('SponsorListInvestCtrl', function($scope, $http, $location, $modal, noty, $SponsorInvestService) {
  
  $scope.noty = noty;
  $scope.sponsors = {};
  $scope.loading = false;
  
  $scope.init = function () {
    
    $scope.loading = true;
      $SponsorInvestService.get_list().then(function(response) {
      $scope.loading = false;
      if (response.data.type == 1) {
        $scope.message_type = 1;
        $scope.message = response.data.message;
        return;
      }
      
      $scope.sponsors = response.data.sponsors;

    });
  };
  
});
