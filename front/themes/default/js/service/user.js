app.service('$UserService', function($rootScope, $http, $modal, $q) {
  $scope = this;
  
  this.view = function(id) {
    var url = generate_url('user', 'view');
    return $http({
      method  : 'GET',
      url     : url + '&id=' + id,
      headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
     });
  };
  
  this.add = function (user) {
    var url = generate_url('user', 'add');
    return $http({
      'method': 'POST',
      'url': url,
      'data': user,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.add_downline = function (user) {
    var url = generate_url('userdownline', 'add');
    return $http({
      'method': 'POST',
      'url': url,
      'data': user,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.edit = function (user) {
    var url = generate_url('user', 'edit');
    return $http({
      'method': 'PUT',
      'url': url,
      'data': user,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.delete = function (user) {
    var url = generate_url('user', 'delete');
    
    return $http({
      'method': 'DELETE',
      'url': url,
      'data': user,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.get_list = function (page, pageSize) {
    var url = generate_url('user', 'get_list');
    url += '&page=' + page + "&pageSize=" + pageSize;
    return $http.get(url);
  };
  
  this.search_text = function (page, pageSize, s_text) {
    var url = generate_url('user', 'get_list');
    url += "&page=" + page + "&pageSize=" + pageSize + "&s_text=" + s_text;
    return $http.get(url);
  };
  
  this.view_downline = function(id, system_code) {
    var url = generate_url('userdownline', 'view');
    return $http({
      method  : 'GET',
      url     : url + '&id=' + id + '&system_code=' + system_code,
      headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
     });
  };
  
  this.search_text_downline = function (page, pageSize, s_text) {
    var url = generate_url('userdownline', 'get_list');
    url += "&page=" + page + "&pageSize=" + pageSize + "&s_text=" + s_text;
    return $http.get(url);
  };
  
  this.get_list_downline = function (page, pageSize) {
    var url = generate_url('userdownline', 'get_list');
    url += '&page=' + page + "&pageSize=" + pageSize;
    return $http.get(url);
  };
  
  this.edit_downline = function (user) {
    var url = generate_url('userdownline', 'edit');
    
    return $http({
      'method': 'PUT',
      'url': url,
      'data': user,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.get_list_mobile = function (user) {
    var url = generate_url('gcm', 'get_list_mobile');
    
     return $http({
      method  : 'GET',
      url     : url + '&user_id=' + user.id + '&system_code=' + user.system_code,
      headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
     });
  };
  
  this.show_mobile_modal = function(user, options) {
    var deferred = $q.defer();
    var url = '//' + appConf.domain + '?mod=user.mobile';
    
    var modal =  $modal.open({
      templateUrl: url,
      windowClass: 'modal-medium',
      controller: 'ModalInstanceCtrl',
      size: 'md',
      resolve: {
        'options': function() {
          return options;
        }
      }
    });
    
    modal.result.then(function(results) {
      deferred.resolve(results);
    },
    function(errors) {
      deferred.reject(errors);
    });
    return deferred.promise;
  };
  
  return this;
});
