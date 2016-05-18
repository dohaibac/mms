app.service('$PlanpdService', function($rootScope, $http, $modal, $q) {
  $scope = this;
  
  this.get_all = function (date) {
    var url = generate_url('planpd', 'get_all');
    
    return $http({
      'method': 'GET',
      'url': url,
      'params': {'date': date},
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  return this;
});
