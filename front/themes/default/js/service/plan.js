app.service('$PlanService', function($rootScope, $http, $modal, $q) {
  $scope = this;
  
  this.add = function (plans) {
    var url = generate_url('plans', 'add');
    return $http({
      'method': 'POST',
      'url': url,
      'data': plans,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.edit = function (plans) {
    var url = generate_url('plans', 'edit');
    return $http({
      'method': 'PUT',
      'url': url,
      'data': plans,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.delete = function (plans) {
    var url = generate_url('plans', 'delete');
    return $http({
      'method': 'DELETE',
      'url': url,
      'data': plans,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.get_list = function () {
    var url = generate_url('plans', 'get_list');
    
    return $http.get(url);
  };
    
  this.get_provinces = function () {
    var url = generate_url('plans', 'get_provinces');
    return $http.get(url);
  };
  
  return this;
});
