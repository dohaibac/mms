app.service('$BankService', function($rootScope, $http, $modal, $q) {
  
  this.add = function (bank) {
    var url = generate_url('bank', 'add');
    return $http({
      'method': 'POST',
      'url': url,
      'data': bank,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.edit = function (bank) {
    var url = generate_url('bank', 'edit');
    return $http({
      'method': 'PUT',
      'url': url,
      'data': bank,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.delete = function (bank) {
    var url = generate_url('bank', 'delete');
    return $http({
      'method': 'DELETE',
      'url': url,
      'data': bank,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.get_list = function () {
    var url = generate_url('bank', 'get_list');
    
    return $http.get(url);
  };
  
  this.show_add_modal = function(options) {
    var deferred = $q.defer();
    var url = '//' + appConf.domain + '?mod=bank.add';
    
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
  
  this.show_edit_modal = function(options) {
    var deferred = $q.defer();
    var url = '//' + appConf.domain + '?mod=bank.add';
    
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
  
  this.show_list_modal = function (options) {
    var url = '//' + appConf.domain + '?mod=bank.list';
    var deferred = $q.defer();
    
    options = options || {};
    
    var modal =  $modal.open({
      templateUrl: url,
      windowClass: 'modal-medium',
      controller: 'ModalInstanceCtrl',
      size: 'lg',
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