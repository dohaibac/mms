app.service('$GdexService', function($rootScope, $http, $modal, $q) {
  $scope = this;
  this.edit = function (gd) {
    var url = generate_url('gdex', 'edit');
    
    return $http({
      'method': 'PUT',
      'url': url,
      'data': gd,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
    
  };
  this.get_all = function (date) {
    var url = generate_url('gdex', 'get_all');
    
    return $http({
      'method': 'GET',
      'url': url,
      'params': {'date': date},
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  this.show_confirm_approve_modal = function(options) {
    var deferred = $q.defer();
    var url = '//' + appConf.domain + '?mod=gdex.confirm_approved';
    
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
