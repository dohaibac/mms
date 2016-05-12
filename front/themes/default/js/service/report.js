app.service('$GroupService', function($rootScope, $http, $modal, $q) {
  $scope = this;
  
  this.add = function (group) {
    var url = generate_url('group', 'add');
    return $http({
      'method': 'POST',
      'url': url,
      'data': group,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.edit = function (group) {
    var url = generate_url('group', 'edit');
    return $http({
      'method': 'PUT',
      'url': url,
      'data': group,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.delete = function (group) {
    var url = generate_url('group', 'delete');
    return $http({
      'method': 'DELETE',
      'url': url,
      'data': group,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.get_list = function () {
    var url = generate_url('group', 'get_list');
    
    return $http.get(url);
  };
  
  return this;
});