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
  
  function filterData(data, filter){
    return $filter('filter')(data, filter);
  };
  
  function orderData(data, params){
    return params.sorting() ? $filter('orderBy')(data, params.orderBy()) : filteredData;
  };
  
  function sliceData(data, params){
    return data.slice((params.page() - 1) * params.count(), params.page() * params.count());
  };
  
  function transformData(data,filter,params){
    return sliceData( orderData( filterData(data,filter), params ), params);
  };
  
  var service = {
    cachedData:[],
    getData:function($defer, params, filter){
      if(service.cachedData.length > 0){
        var filteredData = filterData(service.cachedData, filter);
        var transformedData = sliceData(orderData(filteredData, params),params);
        params.total(filteredData.length);
        $defer.resolve(transformedData);
      }
      else{
        var url = generate_url('planpd', 'get_all');
    
        $http.get(url).success(function(resp)
        {
          resp = resp.planpds;
          angular.copy(resp, service.cachedData);
          params.total(resp.length);
          var filteredData = $filter('filter')(resp, filter);
          var transformedData = transformData(resp,filter,params);
          
          $defer.resolve(transformedData);
        });  
      }
    }
  };
  return service;
});
