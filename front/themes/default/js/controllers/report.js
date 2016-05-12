app.controller('GroupListCtrl', function($scope, $http, $location, noty) {
  
  $scope.noty = noty;
  $scope.loading = false;
  
  $scope.get_list = function() {
    $scope.loading = true;
    var url = generate_url ('group', 'get_list');
    $http.get(url).success(function(data) {
      $scope.data = data;
      $scope.loading = false;
    });
  };
  
  $scope.get_list();
  
  $scope.delete = function(group) {
     if (!confirm_del()) {
       return false;
     }
     
    $scope.processing = false;
    $scope.group = {};
    $scope.group.group_id = group.id;
    
    var url = generate_url ('group', 'delete');
    
    $http({
      method  :'DELETE',
      url     : url,
      data    : $scope.group, 
      headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
     })
     .success(function(data) {
        $scope.noty.add({type:'info', title:'Thông báo', body:'Xóa nhóm thành công!'});
        $scope.get_list();
     });
  };
  
});

app.controller('GroupAddCtrl', function($scope, $http, $location, noty) {
  $scope.processing = false;
  
  $scope.group = {};
    
  $scope.disabled = function() {
    if (!$scope.group.name ||$scope.processing) {
      return true;
    }
    return $scope.group.name.length > 0 ? false : true;
  };
  
  $scope.noty = noty;
  
  $scope.submit = function() {
    $scope.message = '';
    $scope.message_type = 1;
    $scope.processing = true;
    
    var url = generate_url ('group', 'add');
   
    $http({
      method  : 'POST',
      url     : url,
      data    : $scope.group, 
      headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
    })
   .success(function(data) { 
      $scope.processing = false;
      
      if (data.type == 0) {
        $scope.noty.add({type:'info', title:'Thông báo', body:'Thêm nhóm thành công!'});
        $location.path("/group/list");
      }
      else {
        $scope.message = data.message;
        $scope.message_type = data.type;
      }
   });
  };
});

app.controller('GroupEditCtrl',  function($scope, $routeParams, $http) {
    $scope.processing = false;
    
    $scope.groupId = $routeParams.groupId;
    $scope.group = {};
    
    $scope.group.group_id = $scope.groupId;
    
    var url = generate_url ('group', 'view');
    
    $http({
      method  : 'GET',
      url     : url + '&group_id=' + $scope.group.group_id,
      headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
     })
     .success(function(data) {
        $scope.message = data.message;
        $scope.message_type = data.type;
        $scope.group = data;
        
        if ($scope.group && $scope.group.block) {
          $scope.group.block = $scope.group.block == 1? true: false;
        }
     });
     
    $scope.disabled = function() {
      if (!$scope.group.name ||$scope.processing) {
        return true;
    }
      
    return $scope.group.name.length > 0 ? false : true;
  };
  
  $scope.submit = function() {
    $scope.message = '';
    $scope.message_type = 1;
    $scope.processing = true;
    
    var url = generate_url ('group', 'edit');
   
   $http({
    method  : 'PUT',
    url     : url,
    data    : $scope.group, 
    headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
   })
   .success(function(data) {
      $scope.message = data.message;
      $scope.message_type = data.type;
      
      $scope.processing = false;
   });
  };
    
});
 
