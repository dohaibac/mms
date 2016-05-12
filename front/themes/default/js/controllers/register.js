app.controller('RegisterController', function($scope, $http) {
  $scope.user = {};
  
  $scope.processing = false;
  $scope.registered = false;
  
  $scope.disabled = function() {
    if (!$scope.user.full_name || !$scope.user.email || 
        !$scope.user.mobile || !$scope.user.password || !$scope.user.repassword ||
        !$scope.user.captcha ||$scope.processing) {
      return true;
    }
    
    return $scope.user.full_name.length > 0 && $scope.user.email.length > 0 && 
           $scope.user.mobile.length > 0 && $scope.user.password.length > 0 && $scope.user.repassword.length > 0 && 
           $scope.user.captcha.length > 0 ? false : true;
  };
  
  $scope.submit = function() {
    $scope.message = '';
    $scope.message_type = 1;
    $scope.processing = true;
    
   var url = generate_url ('user', 'register');
   
   $http({
    method  : 'POST',
    url     : url,
     data    : $.param($scope.user), 
    headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
   })
   .success(function(data) {
      $scope.message = data.message;
      $scope.message_type = data.type;
      $('.recaptcha').click();
      $scope.processing = false;
      
      if (data.type == 0) {
        $scope.registered = true;
        // cho 60s back to home page
        setTimeout(function(){ window.location = '/';}, 60000);
      }
   });
  };
  
});