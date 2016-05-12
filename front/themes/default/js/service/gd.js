app.service('$GdService', function($rootScope, $http, $modal, $q) {
  $scope = this;
  
  this.view = function(id) {
    var url = generate_url('gd', 'view');
    
    return $http({
      'method': 'GET',
      'url': url + '&id=' + id,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.add = function (gd) {
    var url = generate_url('gd', 'add');
    return $http({
      'method': 'POST',
      'url': url,
      'data': gd,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.edit = function (gd) {
    var url = generate_url('gd', 'edit');
    return $http({
      'method': 'PUT',
      'url': url,
      'data': gd,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.delete = function (gd) {
    var url = generate_url('gd', 'delete');
    return $http({
      'method': 'DELETE',
      'url': url,
      'data': gd,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.get_list = function () {
    var url = generate_url('gd', 'get_list');
    
    return $http.get(url);
  };
  
  return this;
});