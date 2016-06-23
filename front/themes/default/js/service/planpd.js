app.service('$PlanpdService', function($rootScope, $http, $modal, $q) {
  $scope = this;
  
  this.auto_create_pd = function (pd) {
    var url = generate_url('planpd', 'auto_create_pd');
    
    return $http({
      'method': 'POST',
      'url': url,
      'data': pd,
      'headers': {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
    
  };
  this.get_all = function (date) {
    var url = generate_url('planpd', 'get_all');
    
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
    var url = '//' + appConf.domain + '?mod=planpd.confirm';
    
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

app.service("$PlanpdListService", function($http, $filter) {
  var service = {
    getData:function($defer, params, filter) {
      var url = generate_url('planpd', 'get_list');
      var keyword = filter ? filter.$ : '';
      return $http({
        'method': 'GET',
        'url': url,
        'params': {'page_number': params.$params.page, 'limit': params.$params.count, 'filter': keyword},
        'headers': {
          'Content-Type': 'application/x-www-form-urlencoded'
        }
      });
    }
  };
  return service;
});