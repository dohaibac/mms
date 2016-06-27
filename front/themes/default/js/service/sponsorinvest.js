app.service('$SponsorInvestService', function($rootScope, $http, $modal, $q) {
  $scope = this;
  
  this.get_list = function ($defer, params, filter) {
    var url = generate_url('sponsorinvest', 'get_list');
    
    var keyword = filter ? filter.$ : '';
    return $http({
      'method': 'GET',
      'url': url,
      'params': {'page_number': params.$params.page, 'limit': params.$params.count, 'filter': keyword},
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  return this;
});
