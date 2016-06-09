app.controller('LoginController', function($scope, $http) {
  $scope.user = {};
  $scope.user.email = '';
  $scope.user.password = '';
  $scope.processing = false;
  $scope.show_form_code = false;
  
  $scope.init = function () {
    var url = generate_url('user', 'get_input_code');
    $http.get(url).success(function(response) {
      
      $scope.show_form_code = !response.check_code ? false : true;
      
    });
  };
  
  $scope.disabled = function() {
    if (!$scope.user.email || !$scope.user.password || $scope.processing) {
      return true;
    }
    return $scope.user.email.length > 0 && $scope.user.password.length > 0 ? false : true;
  };
  
  $scope.submit = function() {
    $scope.message = '';
    $scope.processing = true;
    
    var url = generate_url ('user', 'login');
    
    $http({
     method  : 'POST',
     url     : url,
     data    : $scope.user, 
     headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
    })
    .success(function(data) {
      $scope.processing = false;
      
      if (data.type == 0) {
        if (data.from && data.from != '') {
          window.location.href = data.from;
          return;
        }
      }
      else if (data.code == 'login-message-require_input_code') {
        $scope.show_form_code = true;
      }
      else {
        $scope.message = data.message;
      }
   });
  };
  
  $scope.continue = function() {
    if ($scope.user.input_code == '') {
      return false;
    }
    $scope.message_code = '';
    $scope.processing = true;
    
    var url = generate_url ('user', 'check_input_code');
    
    
    $http({
     method  : 'POST',
     url     : url,
     data    : $scope.user, 
     headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
    })
    .success(function(data) {
      $scope.processing = false;
      
      if (data.type == 0) {
        if (data.from && data.from != '') {
          window.location.href = data.from;
          return;
        }
      }
      $scope.message_code = data.message;
   });
  };
});