app.service('$PlanGetService', function($rootScope, $http, $modal, $q) {
  $scope = this;
  
  this.auto_create_get = function (get) {
    var url = generate_url('planget', 'auto_create_get');
    
    return $http({
      'method': 'POST',
      'url': url,
      'data': get,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
    
  };
  
  this.get_all = function (date) {
    var url = generate_url('planget', 'get_all');
    
    return $http({
      'method': 'GET',
      'url': url,
      'params': {'date': date},
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.show_confirm_modal = function(options) {
    var deferred = $q.defer();
    var url = '//' + appConf.domain + '?mod=planget.confirm';
    
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
