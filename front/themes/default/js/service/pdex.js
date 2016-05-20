app.service('$PdexService', function($rootScope, $http, $modal, $q) {
  $scope = this;
  
  this.edit = function (pdex) {
    var url = generate_url('pdex', 'edit');
    
    return $http({
      'method': 'PUT',
      'url': url,
      'data': pdex,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
    
  };
  this.get_all = function (date) {
    var url = generate_url('pdex', 'get_all');
    
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
    var url = '//' + appConf.domain + '?mod=pdex.confirm';
    
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
