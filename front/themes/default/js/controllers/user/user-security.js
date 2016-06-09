app.controller('UserSecurityCtrl', function($scope, $http, $location, noty, $UserService) {
  $scope.user = {};
  $scope.user.send_code = 'Email';
  
  $scope.noty = noty;
  
  $scope.processing = false;

  $scope.edit = false;
  
  $scope.init = function() {
    $UserService.get_password2().then(function(response){
      var data = response.data;
      $scope.user.enabled = data.enabled;
      $scope.user.send_code = data.send_code;
    });
  };
  
  $scope.disable = function () {
    $scope.message = '';
    $scope.message_type = 1;
    $scope.processing = true;
    
    $scope.user.enabled = false;
    
    $UserService.enable_password2($scope.user).then(function(response) {
      $scope.processing = false;
      var data = response.data;
      
      $scope.noty.add({type:'info', title:'Thông báo', body:data.message});
    }); 
  };
  $scope.enable = function() {
    $scope.message = '';
    $scope.message_type = 1;
    $scope.processing = true;
    
    $scope.user.enabled = true;
    
    $UserService.enable_password2($scope.user).then(function(response) {
      $scope.processing = false;
      var data = response.data;
      
      $scope.noty.add({type:'info', title:'Thông báo', body:data.message});
    }); 
  };
  
});

