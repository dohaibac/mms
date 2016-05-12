app.service('$MenuService', function($rootScope, $http, $modal, $q) {
  $scope = this;
  
  this.add = function (menu) {
    var url = generate_url('menu', 'add');
    return $http({
      'method': 'POST',
      'url': url,
      'data': menu,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.edit = function (menu) {
    var url = generate_url('menu', 'edit');
    return $http({
      'method': 'PUT',
      'url': url,
      'data': menu,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.delete = function (menu) {
    var url = generate_url('menu', 'delete');
    return $http({
      'method': 'DELETE',
      'url': url,
      'data': menu,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.get_list = function () {
    var url = generate_url('menu', 'get_list');
    
    return $http.get(url);
  };
  
  return this;
});