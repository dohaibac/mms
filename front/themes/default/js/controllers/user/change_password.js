app.controller('ChangepasswordController', function($scope, $http) {
  $scope.user = {};
  
  $scope.processing = false;
  
  $scope.disabled = function() {
    if (!$scope.user.password_old || !$scope.user.password_new || !$scope.user.password_renew || $scope.processing) {
      return true;
    }
    return $scope.user.password_old.length > 0 && $scope.user.password_new.length > 0 && $scope.user.password_renew.length > 0 ? false : true;
  };
  
  $scope.submit = function() {
    $scope.message = '';
    $scope.message_type = 1;
    $scope.processing = true;
    
    var url = generate_url ('user', 'change_password');
   
   $http({
    method  : 'POST',
    url     : url,
    data    : $scope.user, 
    headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
   })
   .success(function(data) {
      check_ajax_required_login(data);
      $scope.message = data.message;
      $scope.message_type = data.type;
      
      $scope.processing = false;
   });
  };
});