app.controller('SponsorListInvestCtrl', 
  function($scope, $http, $location, $modal, noty, $SponsorInvestService, ngTableParams, $timeout) {
  
  $scope.noty = noty;
  $scope.sponsors = {};
  $scope.loading = false;
  
  $scope.tableParams = new ngTableParams(
    {
      page: 1,            // show first page
      count: 25,           // count per page
      sorting: {sponsor:'asc'}
    },
    {
      total: 0, // length of data
      getData: function($defer, params) {
        $scope.loading = true;
        $SponsorInvestService.get_list($defer, params, $scope.filter).then(function(response) {
          $scope.loading = false;
          
          var data = response.data;
          
          params.total(data.total);
          $defer.resolve(data.sponsors);
        });
      }
  });
  
  var filterTextTimeout;
  
  $scope.$watch("filter.$", function (val) {
    if (filterTextTimeout) $timeout.cancel(filterTextTimeout);
    
    filterTextTimeout = $timeout(function() {
       if ($scope.filter && $scope.filter.$ != '') {
         $scope.tableParams.$params.page = 1;
         $scope.tableParams.reload();
       }
    }, 250);
  });
  
  $scope.view_all = function (pd) {
    if ($scope.filter) $scope.filter.$ = '';
    $scope.tableParams.reload();
  };
  
});
