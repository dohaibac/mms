app.service('$SponsorInvestService', function($rootScope, $http, $modal, $q) {
  $scope = this;
  
  this.get_list = function () {
    var url = generate_url('sponsorinvest', 'get_list');
    
    return $http.get(url);
  };
  
  return this;
});
