app.service('$PdService', function($rootScope, $http, $modal, $q) {
  $scope = this;
  
  this.view = function(id) {
    var url = generate_url('pd', 'view');
    
    return $http({
      'method': 'GET',
      'url': url + '&id=' + id,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.add = function (pd) {
    var url = generate_url('pd', 'add');
    return $http({
      'method': 'POST',
      'url': url,
      'data': pd,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.edit = function (pd) {
    var url = generate_url('pd', 'edit');
    return $http({
      'method': 'PUT',
      'url': url,
      'data': pd,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.delete = function (pd) {
    var url = generate_url('pd', 'delete');
    return $http({
      'method': 'DELETE',
      'url': url,
      'data': pd,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.get_list = function (page, pageSize) {
    var url = generate_url('pd', 'get_list');
    url += '&page=' + page + "&pageSize=" + pageSize;
    return $http.get(url);
  };
  
  return this;
});
