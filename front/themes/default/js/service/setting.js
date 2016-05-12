app.service('$SettingService', function($rootScope, $http, $modal, $q) {
  $scope = this;
  
   this.view = function() {
    var url = generate_url('setting', 'view');
    return $http({
      method  : 'GET',
      url     : url,
      headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
     });
  };
  
  
  this.add = function (setting) {
    var url = generate_url('setting', 'add');
    return $http({
      'method': 'POST',
      'url': url,
      'data': setting,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.edit = function (setting) {
    var url = generate_url('setting', 'edit');
    return $http({
      'method': 'PUT',
      'url': url,
      'data': setting,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  return this;
});