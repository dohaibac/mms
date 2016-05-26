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
  
  this.update_status = function (pd) {
    var url = generate_url('pd', 'update_status');
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
  
  this.search_text = function (page, pageSize, s_text) {
    var url = generate_url('pd', 'get_list');
    url += "&page=" + page + "&pageSize=" + pageSize + "&s_text=" + s_text;
    return $http.get(url);
  };
  
  this.get_status = function () {
    var url = generate_url('pd', 'get_status');
    return $http.get(url);
  };
  
  this.get_all_by_status = function(status) {
    var url = generate_url('pd', 'get_all_by_status');
    
    return $http({
      'method': 'GET',
      'url': url + '&status=' + status,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  return this;
});
