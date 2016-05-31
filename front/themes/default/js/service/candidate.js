app.service('$CandidateService', function($rootScope, $http, $modal, $q) {
  $scope = this;
  
  this.view = function(id) {
    var url = generate_url('candidate', 'view');
    
    return $http({
      'method': 'GET',
      'url': url + '&id=' + id,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.add = function (candidate) {
    var url = generate_url('candidate', 'add');
    return $http({
      'method': 'POST',
      'url': url,
      'data': candidate,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.edit = function (candidate) {
    var url = generate_url('candidate', 'edit');
    return $http({
      'method': 'PUT',
      'url': url,
      'data': candidate,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.delete = function (candidate) {
    var url = generate_url('candidate', 'delete');
    return $http({
      'method': 'DELETE',
      'url': url,
      'data': candidate,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.get_list = function (page, pageSize, s_text="") {
    var url = generate_url('candidate', 'get_list');
    url += "&page=" + page + "&pageSize=" + pageSize + "&s_text=" + s_text;
    return $http.get(url);
  };
  
  this.search_province = function (page, pageSize, s_province) {
    var url = generate_url('candidate', 'get_list');
    url += "&page=" + page + "&pageSize=" + pageSize + "&s_province=" + s_province;
    return $http.get(url);
  };
  
  return this;
});