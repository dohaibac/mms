app.controller('ProfitModalCtrl', function($scope, $http, $location, $modal, $SponsorService, $BankService,  $compile, noty) {
  $scope.sponsor = {};
  $scope.sponsor.item = {};
  
  $scope.result_test = [];
  
  $scope.loading = false;
  
  $scope.$on('SponsorListCtrl::send::data::show_profit', function(e, data) {
     
     $scope.sponsor = data.sponsor; 
    
     $scope.mscope = data.mscope;
     
     /*$scope.loading = true;
     
     $SponsorService.get_all($scope.sponsor.item).then(function(response){
       $scope.loading = false;
       
       var data = response.data;
       
       var sponsor = data.sponsors[$scope.sponsor.item.lusername];
       
     });*/
  });
  
  $scope.processing = false;
  
  $scope.disabled = function() {
    if (!$scope.sponsor.item.username ||  $scope.processing) {
      return true;
    }
    
    return $scope.sponsor.item.username.length > 0 ? false : true;
  };
  
});
