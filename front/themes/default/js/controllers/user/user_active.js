app.controller('UserActiveController', function($scope, $http) {
  $scope.user = {};
  
  $scope.processing = false;
  
  $scope.disabled = function() {
    if (!$scope.user.email || $scope.processing) {
      return true;
    }
    
    return $scope.user.email.length > 0 ? false : true;
  };
  
  $scope.init = function() {
    $scope.message = '';
    $scope.message_type = 1;
    $scope.processing = true;
    
   var url = generate_url ('user', 'active_user');
   
   $http({
    method  : 'POST',
    url     : url,
    data    : $.param($scope.user), 
    headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
   })
   .success(function(data) {
      $scope.message = data.message;
      $scope.message_type = data.type;
      
      $scope.processing = false;
      
      if (data.type == 0) {
        // cho 10s back to home page
        setTimeout(function(){ window.location = '/';}, 30000);
      }
   });
  };
  
});