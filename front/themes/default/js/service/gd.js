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
  
  this.get_list = function (page, pageSize) {
    var url = generate_url('gd', 'get_list');
    url += "&page=" + page + "&pageSize=" + pageSize;
    return $http.get(url);
  };
  
  this.search_text = function (page, pageSize, s_text) {
    var url = generate_url('gd', 'get_list');
    url += "&page=" + page + "&pageSize=" + pageSize + "&s_text=" + s_text;
    return $http.get(url);
  };
  
  this.get_status = function () {
    var url = generate_url('gd', 'get_status');
    return $http.get(url);
  };
  
  this.get_all = function (status) {
    var url = generate_url('gd', 'get_all');
    
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
