app.service('$SponsorService', function($rootScope, $http, $modal, $q) {
  $scope = this;
  
  this.view = function(username) {
    var url = generate_url('sponsor', 'get_check_by_username');
    
    return $http({
      'method': 'GET',
      'url': url,
      'params': {'username': username},
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.add = function (sponsor) {
    var url = generate_url('sponsor', 'add');
    return $http({
      'method': 'POST',
      'url': url,
      'data': sponsor,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.edit = function (sponsor) {
    var url = generate_url('sponsor', 'edit');
    return $http({
      'method': 'PUT',
      'url': url,
      'data': sponsor,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.delete = function (sponsor) {
    var url = generate_url('sponsor', 'delete');
    return $http({
      'method': 'DELETE',
      'url': url,
      'data': sponsor,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.get_list = function() {
    var url = generate_url ('sponsor', 'get_list');
    return $http.get(url);
  };
  
  this.search = function(keyword) {
    var url = generate_url ('sponsor', 'search');
    
    return $http({
      'method': 'GET',
      'url': url,
      'params': {'keyword': keyword},
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  this.show_add_modal = function(options) {
    var deferred = $q.defer();
    var url = '//' + appConf.domain + '?mod=sponsor.add_modal';
    
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
    var url = '//' + appConf.domain + '?mod=sponsor.add';
    
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
  
  this.show_list_modal = function () {
    var url = '//' + appConf.domain + '?mod=sponsor.list';
    var deferred = $q.defer();
    
    var modal =  $modal.open({
      templateUrl: url,
      windowClass: 'modal-medium',
      controller: 'ModalInstanceCtrl',
      size: 'lg',
      resolve: {
        'options': function() {
          return {};
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
  
  this.show_modal_detail = function(options) {
    var deferred = $q.defer();
    var url = '//' + appConf.domain + '?mod=sponsor.detail';
    
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
  
  this.get_sponsor_owner = function () {
    var url = generate_url('sponsor', 'get_sponsor_owner');
    
    return $http.get(url);
  };
  
  this.check_sponsor_invest = function (sponsor) {
    var url = generate_url('sponsorinvest', 'check_sponsor_invest');
    
    return $http({
      'method': 'GET',
      'url': url,
      'params': {'sponsor': sponsor},
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  };
  
  return this;
});